<?php
namespace MsPhp\App\Entity;

use MsPhp\Entity\Attribute\Prototype\EmailMessage;

class Smtp extends Service {
    protected EmailMessage $emailMessage;
    protected string $label;
    public function setEmailMessage(EmailMessage $instance){
        $this->emailMessage = $instance;
        return $this;
    }
    public function getLabel(): string {
        return $this->label;
    }
    public function setLabel(string $label): Smtp {
        $this->label = $label;
        return $this;
    }
    public function setResult() {
        if(!is_null($this->userName) && !is_null($this->password)){
            $this->result = false;
            $socket = fsockopen($this->host, $this->port, $errno, $errstr, 30);
            $isResp = [];
            if ($socket === false) {
                die('email socket!!!');
            } else {
                $date = new \DateTime();
                $this->emailMessage->setResult();
                $response = fgets($socket);
                if((int) substr($response,0,3) === 220){
                    $ehlo = 'EHLO ' . $this->host;
                    fwrite($socket, $ehlo . PHP_EOL);
                    $response = (int) substr(fread($socket,300),0,3);
                    if($response === 250){
                        fwrite($socket, 'STARTTLS' . PHP_EOL);
                        $response = fgets($socket);
                        if((int) substr($response,0,3) === 220){
                            $isEncrypted = stream_socket_enable_crypto($socket, true, STREAM_CRYPTO_METHOD_TLSv1_2_CLIENT);
                            if($isEncrypted === true) {
                                $elements = [
                                    $ehlo,
                                    'AUTH LOGIN',
                                    base64_encode($this->userName),
                                    base64_encode($this->password),
                                    'MAIL FROM: <' . $this->emailMessage->getAddresser() . '>',
                                    'RCPT TO: <'.$this->emailMessage->getAddressee().'>',
                                    'DATA',
                                    'Date: ' . $date->format('D, d M Y H:i:s O'),
                                    'From: '.$this->emailMessage->getLabel().' <' . $this->emailMessage->getAddresser() . '>',
                                    'To: <'.$this->emailMessage->getAddressee().'>',
                                    'Subject: ' . $this->emailMessage->getSubject(),
                                    $this->emailMessage->getResult(),
                                    '.',
                                    'QUIT'
                                ];
                                foreach ($elements as $element) {
                                    fwrite($socket, $element . PHP_EOL);
                                    $isResp[] = fgets($socket);
                                }
                                fclose($socket);
                                $allowedCodes = [220, 250, 235, 334, 354];
                                $this->result = true;
                                foreach ($isResp as $value) {
                                    $respCode = substr($value, 0, 3);
                                    if (!in_array((int) $respCode, $allowedCodes)) {
                                        $this->result = $respCode;
                                        break;
                                    }
                                }
                            } else {
                                die('isEncrypted');
                            }
                        } else {
                            die('STARTTLS');
                        }
                    } else {
                        die('EHLO:'.(int) $response);
                    }
                } else {
                    die('SMTP BANNER');
                }
            }
        }
        return $this;
    }
}
/*
****** THIS IS PATTERN FOR PHP::  does not work with telnet because of required TLS handshake and encryption after STARTTLS
    -> telnet mail.example.com 465
    Trying 85.214.162.209...
    Connected to mail.example.com.
    Escape character is '^]'.
    220 mail.example.com ESMTP Postfix
    -> EHLO mail.example.com
    250-mail.example.com
    250-PIPELINING
    250-SIZE 10240000
    250-VRFY
    250-ETRN
    250-STARTTLS
    250-ENHANCEDSTATUSCODES
    250-8BITMIME
    250-DSN
    250 SMTPUTF8
    -> STARTTLS
    220 2.0.0 Ready to start TLS
    -> EHLO mail.example.com
    -> AUTH LOGIN

******** this works in terminal
    openssl s_client -starttls smtp -connect mail.example.com:465 -crlf
 */
