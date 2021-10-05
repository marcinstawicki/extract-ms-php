<?php

namespace MsPhp\Rest\Entity;

class Recipient {
    protected $status = array(
        100 => 'Continue',
        101 => 'Switching Protocols',
        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        203 => 'Non-Authoritative Information',
        204 => 'No Content',
        205 => 'Reset Content',
        206 => 'Partial Content',
        300 => 'Multiple Choices',
        301 => 'Moved Permanently',
        302 => 'Found',
        303 => 'See Other',
        304 => 'Not Modified',
        305 => 'Use Proxy',
        306 => '(Unused)',
        307 => 'Temporary Redirect',
        400 => 'Bad XmlHttpRequest',
        401 => 'Unauthorized',
        402 => 'Payment Required',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        407 => 'Proxy Authentication Required',
        408 => 'XmlHttpRequest Timeout',
        409 => 'Conflict',
        410 => 'Gone',
        411 => 'Length Required',
        412 => 'Precondition Failed',
        413 => 'XmlHttpRequest Entity Too Large',
        414 => 'XmlHttpRequest-URI Too Long',
        415 => 'Unsupported Media Type',
        416 => 'Requested Range Not Satisfiable',
        417 => 'Expectation Failed',
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
        504 => 'Gateway Timeout',
        505 => 'HTTP Version Not Supported'
    );
    protected $statusCode = 200;
    protected $response;
    protected $referrer;
    protected $method;

    public function __construct() {
        switch ($this->method) {
            case "POST":
            case "GET":
            case "DELETE":
            case "PUT":
                $this->referrer = $_SERVER['HTTP_REFERER'];
                $this->method = $_SERVER['REQUEST_METHOD'];
                break;
            default:
                $this->statusCode = 405;
                $this->response = json_encode(array('error' => 'method id not correct'));
                break;
        }
    }
    public function setResult() {
        if(!is_null($this->response)){
            header("HTTP/1.1 " . $this->statusCode . " " . $this->status[$this->statusCode]);
            header("Content-Type: application/json");
            echo $this->response;
        } else {
            throw new \Exception('no response');
        }
    }
    public function setResponse(array $response) {
        $this->response = $response;
        return $this;
    }
    public function getReferrer() {
        return $this->referrer;
    }
    public function getMethod() {
        return $this->method;
    }
}
