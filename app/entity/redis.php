<?php

namespace MsPhp\App\Entity;

class Redis extends Service {

    protected $socket;
    protected $query;
    protected $error;

    public function __construct() {
        $this->scheme = 'tcp://';
        $this->host = '127.0.0.1';
        $this->port = 6379;
    }

    public function setSocket() {
        $remote = $this->scheme . $this->host . ':' . $this->port;
        $connection = stream_socket_client($remote, $errno, $errstr, 30);
        if ($connection !== false) {
            if(!is_null($this->password)){
                $this->setQuery('AUTH '.$this->password)
                    ->setResult();
                if($this->getResult() === '+OK'){
                    $this->socket = $connection;
                } else {
                    $this->error = $errstr;
                }
            } else {
                $this->socket = $connection;
            }
        } else {
            $this->error = $errstr;
        }
        return $this;
    }
    /**
     * SELECT
     * FLUSHDB
     * SET key:1 "value" [nx | xx]
     * MSET key:1 "value" key "value" key "value"
     * APPEND key:1 "value"
     * GET key:1
     * MGET key:1 key:2 key:3
     * DEL key:1
     * EXISTS key:1
     * EXPIRE key:1 120
     * EXPIREAT key:1 1293840000
     * KEYS *
     * KEYS *title*
     * SAVE !!! BGSAVE !!!
     * For Simple Strings the first byte of the reply is "+" -> "+OK\r\n"
     * For Errors the first byte of the reply is "-" -> "-Error message\r\n"
     * For Integers the first byte of the reply is ":" -> ":1000\r\n"
     * For Bulk Strings the first byte of the reply is "$" -> "$6\r\nfoobar\r\n"
     * For Arrays the first byte of the reply is "*" -> "*0\r\n" -> "*2\r\n$3\r\nfoo\r\n$3\r\nbar\r\n" -> "*3\r\n:1\r\n:2\r\n:3\r\n"
     * @param $query
     * @return $this
     */
    public function setQuery(string $query) {
        /**
         * query must be array: "*3\r\n$3\r\nSET\r\n$4\r\nkey3\r\n$$len\r\n$ser\r\n";
         */
        $query = preg_replace('/\s+/', ' ', trim($query));
        $parts = explode(' ',$query);
        $count = count($parts);
        $crlf = "\r\n";
        $sQuery = '*'.$count.$crlf;
        foreach($parts as $key => $part){
            $part = str_replace('#',' ',$part);
            $length = strlen($part);
            $sQuery.= '$'.$length.$crlf.$part.$crlf;
        }
        $this->query = $sQuery;
        return $this;
    }

    public function setResult()
    {
        $result = null;
        if (!is_null($this->socket)) {
            $write = fwrite($this->socket, $this->query,strlen($this->query));
            if($write === false){
                $this->setLog('no writing for: '.$this->query);
            } else {
                /**
                 * response
                 */
                $info = fgets($this->socket,1024);
                $type = $info[0];
                switch ($type) {
                    case ':':
                    case '+':
                    case '-':
                        $result = substr($info,1);
                        if($type === ':'){
                            $result = (int) $result;
                        }
                        break;
                    case '$':
                        $bytes = trim(substr($info,1),"\r\n");
                        if($bytes === '0'){
                            /**
                             * empty string
                             */
                            $result = '';
                        } elseif ($bytes === '-1'){
                            /**
                             * null
                             */
                            $result = null;
                        } else {
                            $read = true;
                            if($read === false){
                                $this->setLog('no reading \\n for: '.$this->query);
                            } else {
                                $result = fgets($this->socket,(int) $bytes);
                            }
                        }
                        break;
                    case '*':
                        /**
                         * it is not implemented: it is not worth it
                         */
                        break;
                    default:
                        break;
                }
            }
        }
        $this->result = $result;
        return $this;
    }
    /**
     * @param $value
     * @return mixed
     */
    public static function encodeValue($value){
        if(is_array($value)){
            $value = json_encode($value);
        }
        return str_replace(' ','#', $value);
    }
    public static function decodeValue($value){
        if(substr($value,0,1) === '{') {
            $value = json_decode($value,true);
        }
        return $value;
    }
}
