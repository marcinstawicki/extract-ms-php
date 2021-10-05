<?php

namespace MsPhp\Websocket;

use MsPhp\Quality\Entity\DateTime;

abstract class Server {
    protected string $host = 'localhost';
    protected string $address = '127.0.0.1';
    protected int $port = 8000;
    protected array $users = [];
    protected array $tokens = [];
    protected array $newConnections = [];
    protected array $connections = [];
    protected string $path = '';
    protected $server;
    protected array $shallOrigin = [];
    protected array $intervals = [];
    protected array $intervalAmounts = [];
    protected int $count = 0;

    final public function setPort(int $port)
    {
        $this->port = $port;
        return $this;
    }
    final public function setPath(string $path)
    {
        $this->path = $path;
        return $this;
    }
    final public function addShallOrigin($shallOrigin)
    {
        $this->shallOrigin[] = $shallOrigin;
        return $this;
    }
    final public function setResult() {
        $socket = @socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        if ($socket === false) {
            $error = socket_last_error($socket);
            $msg = socket_strerror($error);
            self::log('error: ' . $msg);
        } else {
            socket_set_option($socket, SOL_SOCKET, SO_REUSEADDR, 1);
            socket_bind($socket, $this->address, $this->port);
            socket_listen($socket);
            $this->server = $socket;
            $this->connections = [$socket];
        }
        $write = NULL;
        $except = NULL;
        $run = true;
        while ($run) {
            $this->newConnections = $this->connections;
            $number = @socket_select($this->newConnections, $write, $except, 0, 10);
            if($number === false){
                $error = socket_strerror(socket_last_error());
                self::log('error: '.$error);
            } else {
                $this->setOnOpen();
                $this->setOnMessage();
                //$this->setOnClose();
            }
        }
        socket_close($this->server);
    }
    //
    final protected static function log(string $message){
        //file_put_contents('/srv/langfreak/public/ws/error.log', $message. PHP_EOL, FILE_APPEND);
    }
    final protected static function getEncoded(string $payload)
    {
        $frameHead = [];
        $payloadLength = strlen($payload);
        $type = 'text';
        switch ($type) {
            case 'text':
                // first byte indicates FIN, Text-Frame (10000001):
                $frameHead[0] = 129;
                break;
            case 'close':
                // first byte indicates FIN, Close Frame(10001000):
                $frameHead[0] = 136;
                break;
            case 'ping':
                // first byte indicates FIN, Ping frame (10001001):
                $frameHead[0] = 137;
                break;
            case 'pong':
                // first byte indicates FIN, Pong frame (10001010):
                $frameHead[0] = 138;
                break;
        }
        /**
         * A server MUST NOT mask any frames that it sends to
         * the client.  A client MUST close a connection if it detects a masked
         * frame.
         */
        $masked = false;
        // set mask and payload length (using 1, 3 or 9 bytes)
        if ($payloadLength > 65535) {
            $payloadLengthBin = str_split(sprintf('%064b', $payloadLength), 8);
            $frameHead[1] = ($masked === true) ? 255 : 127;
            for ($i = 0; $i < 8; $i++) {
                $frameHead[$i + 2] = bindec($payloadLengthBin[$i]);
            }
            // most significant bit MUST be 0 (close connection if frame too big)
            if ($frameHead[2] > 127) {
                /*
                 * todo: disconnect
                 */
            }
        } elseif ($payloadLength > 125) {
            $payloadLengthBin = str_split(sprintf('%016b', $payloadLength), 8);
            $frameHead[1] = ($masked === true) ? 254 : 126;
            $frameHead[2] = bindec($payloadLengthBin[0]);
            $frameHead[3] = bindec($payloadLengthBin[1]);
        } else {
            $frameHead[1] = ($masked === true) ? $payloadLength + 128 : $payloadLength;
        }

        // convert frame-head to string:
        foreach (array_keys($frameHead) as $i) {
            $frameHead[$i] = chr($frameHead[$i]);
        }
        if ($masked === true) {
            // generate a random mask:
            $mask = [];
            for ($i = 0; $i < 4; $i++) {
                $mask[$i] = chr(rand(0, 255));
            }

            $frameHead = array_merge($frameHead, $mask);
        }
        $frame = implode('', $frameHead);

        // append payload to frame:
        for ($i = 0; $i < $payloadLength; $i++) {
            $frame .= ($masked === true) ? $payload[$i] ^ $mask[$i % 4] : $payload[$i];
        }
        return $frame;
    }
    final protected static function getDecoded(string $buffer)
    {
        $rawPayload = '';
        $first = sprintf('%08b', ord($buffer[0]));
        $second = sprintf('%08b', ord($buffer[1]));
        $type = bindec(substr($first, 4, 4));
        $isMasked = $second[0] == '1';
        $payloadLength = ord($buffer[1]) & 127;

        if ($payloadLength === 126) {
            $mask = substr($buffer, 4, 4);
            $payloadOffset = 8;
            $dataLength = bindec(sprintf('%08b', ord($buffer[2])) . sprintf('%08b', ord($buffer[3]))) + $payloadOffset;
        } elseif ($payloadLength === 127) {
            $mask = substr($buffer, 10, 4);
            $payloadOffset = 14;
            $tmp = '';
            for ($i = 0; $i < 8; $i++) {
                $tmp .= sprintf('%08b', ord($buffer[$i + 2]));
            }
            $dataLength = bindec($tmp) + $payloadOffset;
            unset($tmp);
        } else {
            $mask = substr($buffer, 2, 4);
            $payloadOffset = 6;
            $dataLength = $payloadLength + $payloadOffset;
        }
        if ($isMasked === true) {
            for ($i = $payloadOffset; $i < $dataLength; $i++) {
                $j = $i - $payloadOffset;
                if (isset($buffer[$i])) {
                    $rawPayload .= $buffer[$i] ^ $mask[$j % 4];
                }
            }
            $request = $rawPayload;
        } else {
            $payloadOffset = $payloadOffset - 4;
            $request = substr($buffer, $payloadOffset);
        }
        self::log('buffer '. bin2hex($buffer));
        self::log('request '. $request);
        return (string) $request;
    }
    //
    final protected function setOnOpen()
    {
        if (in_array($this->server, $this->newConnections)) {
            $newConnection = socket_accept($this->server);
            if ($newConnection === false) {
                $error = socket_last_error($newConnection);
                $msg = socket_strerror($error);
                self::log($msg);
            }
            $this->connections[] = $newConnection;
            $header = @socket_read($newConnection, 1024);
            if($header !== false) {
                if($this->isAllowedOrigin($header) && $this->isAllowedUser($header)) {
                    preg_match('#Sec-WebSocket-Key: (.*)\r\n#', $header, $matches);
                    $key = base64_encode(sha1(trim($matches[1]) . '258EAFA5-E914-47DA-95CA-C5AB0DC85B11', true));
                    preg_match('#Sec-WebSocket-Protocol: (.*)\r\n#', $header, $protocols);
                    $headers = [
                        'HTTP/1.1 101 Switching Protocols',
                        'Upgrade: websocket',
                        'Connection: Upgrade',
                        'Sec-WebSocket-Protocol: ' . trim($protocols[1]),
                        'Sec-WebSocket-Accept: ' . $key
                    ];
                    $headers = implode("\r\n", $headers) . "\r\n\r\n";
                    //$headers = self::getEncoded($headers);
                    $this->sendBack($headers,$newConnection);
                    /**
                     * remove handshake connection
                     */
                    $newConnectionIndex = array_search($this->server, $this->newConnections);
                    unset($this->newConnections[$newConnectionIndex]);
                } else {
                    $this->close($newConnection);
                }
            } else {
                self::log('no handshake header');
                $this->close($newConnection);
            }
        }
    }
    final protected function setOnMessage() {
        foreach ($this->newConnections as $cKey => $connection) {
            self::log('count '.$this->count++);
            /**
             * check if client is disconnected
             */
            $buffer = @socket_read($connection, 1024);
            self::log('on message 1');
            if ($buffer === false) {
                $connectionID = (int) $connection;
                $key = array_search($connection, $this->connections);
                unset($this->connections[$key]);
                self::log('disconnected '.$connectionID);
                continue;
            } else {
                $buffer = trim($buffer);
                self::log('on message 2');
                if(!empty($buffer)){
                    //self::log('on message 5');
                    self::log('on buffer '.$buffer);
                    $request = self::getDecoded($buffer);
                    if($this->isAllowedPayloadLength($request) && $this->isAllowedPayloadStructure($request) &&
                        $this->isAllowedInterval($connection) && $this->isAllowedIntervalAmount($connection)) {
                        $connectionID = (int) $connection;
                        $this->intervals[$connectionID] = new \DateTime();
                        if(isset($this->intervalAmounts[$connectionID])){
                            $this->intervalAmounts[$connectionID] = [$this->intervalAmounts[$connectionID][0],($this->intervalAmounts[$connectionID][1]+1)];
                        } else {
                            $this->intervalAmounts[$connectionID] = [new \DateTime(),1];
                        }
                        $this->setResponse($request,$connection);
                        //socket_close($connection);
                    } else {
                        continue;
                    }
                }
            }
        }
    }
    final protected function setOnClose() {
        foreach ($this->newConnections as $connection) {
            $buffer = @socket_read($connection, 1024, PHP_NORMAL_READ);
            if ($buffer === false) {
                $this->close($connection);
            }
        }
    }
    final protected function close($connection){
        $connectionID = (int) $connection;
        $connectionIndex = array_search($connection, $this->connections);
        unset($this->connections[$connectionIndex]);
        foreach ($this->users as $channel => $users) {
            foreach ($users as $uKey => $userConnection) {
                if ($connection === $userConnection) {
                    unset($this->users[$channel][$uKey]);
                }
            }
        }
        unset($this->intervals[$connectionID]);
        unset($this->intervalAmounts[$connectionID]);
        socket_close($connection);
    }
    final protected function sendBack($message, $connection) {
        $this->send($message,$connection);
    }
    final protected function forward($message, $channel, $currentConnection) {
        if(isset($this->users[$channel])){
            foreach ($this->users[$channel] as $key => $connection) {
                if ($connection !== $currentConnection) {
                    $this->send($message,$connection);
                }
            }
        }
    }
    final protected function distribute($message, $channel) {
        if(isset($this->users[$channel])){
            foreach ($this->users[$channel] as $key => $connection) {
                $this->send($message,$connection);
            }
        }
    }
    final protected function send($message, $connection)
    {
        $bytes = @socket_write($connection, $message, strlen($message));
        if($bytes === 0) {
            self::log('error: not sent: 0 '. $message);
        } else if($bytes === false) {
            self::log('error: not sent: false '.$message);
        }
    }
    final protected function isAllowedOrigin(string $header){
        $result = false;
        $check = preg_match('#Origin: (.*)\r\n#', $header, $matches);
        if((int) $check === 1){
            $isOrigin = trim($matches[1]);
            foreach($this->shallOrigin as $shallOrigin){
                if($shallOrigin === $isOrigin){
                    $result = true;
                    break;
                }
            }
            if($result === false){
                self::log('error: isOrigin: '.$isOrigin);
            }
        } else {
            self::log('NO Origin');
        }
        return $result;
    }
    final protected function isAllowedPayloadLength($payload){
        $result = strlen($payload) < 500;
        if($result === false){
            self::log('error: too long payload');
        }
        return $result;
    }
    final protected function isAllowedInterval($connection){
        $connectionID = (int) $connection;
        $result = false;
        if(!isset($this->intervals[$connectionID])){
            $result = true;
        } else {
            $wasDatetime = $this->intervals[$connectionID];
            $isDatetime = new \DateTime();
            $interval = $wasDatetime->diff($isDatetime);
            if($interval->format('%s') > 1){
                $result = true;
            } else {
                self::log('error: interval');
            }
        }
        return $result;
    }
    final protected function isAllowedIntervalAmount($connection){
        $connectionID = (int) $connection;
        if(!isset($this->intervalAmounts[$connectionID])){
            $result = true;
        } else {
            $wasDatetime = $this->intervalAmounts[$connectionID][0];
            $amount = (int) $this->intervalAmounts[$connectionID][1];
            $isDatetime = new \DateTime();
            $interval = $wasDatetime->diff($isDatetime);
            if($amount === 2 && $interval->format('%s') < 5){
                $result = false;
                self::log('error: interval amount');
            } else {
                $result = true;
            }
        }
        return $result;
    }
    final protected function isAllowedConnectionAmount($token){
        $result = !in_array($token,$this->tokens);
        if($result === false){
            self::log('error: connection amount');
        }
        return $result;
    }
    //
    protected function isAllowedUser(string $header){
        $result = false;
        $check = preg_match('#Sec-WebSocket-Protocol: (.*)\r\n#', $header, $matches);
        if((int) $check === 1){
            $token = trim($matches[1]);
            if($token === 'ABC'){
                $result = $this->isAllowedConnectionAmount($token);
            } else {
                self::log('WRONG Sec-WebSocket-Protocol');
            }
        } else {
            self::log('NO Sec-WebSocket-Protocol');
        }
        return $result;
    }
    protected function isAllowedPayloadStructure($payload){
        $result = !is_null(json_decode($payload));
        if($result === false){
            self::log('error: not JSON '.$payload);
        }
        return $result;
    }
    protected function setResponse(string $request, $currentConnection) {
        $request = self::getEncoded($request);
        $this->send($request, $currentConnection);
        return $this;
    }
}
