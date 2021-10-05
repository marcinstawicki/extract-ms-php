<?php
namespace MsPhp\Entity\Attribute\Prototype;

abstract class Message {

    protected $date;
    protected $addresser;
    protected $addressee;
    protected $subject;
    protected $body;

    public function getAddresser() {
        return $this->addresser;
    }

    public function getAddressee() {
        return $this->addressee;
    }

    public function setAddresser(string $address) {
        $this->addresser = $address;
        return $this;
    }

    public function setAddressee(string $address) {
        $this->addressee = $address;
        return $this;
    }

    public function setSubject(string $subject) {
        $this->subject = $subject;
        return $this;
    }

    public function getSubject() {
        return $this->subject;
    }

    public function setDate($date) {
        $this->date = $date;
        return $this;
    }

    public function getDate() {
        return $this->date;
    }

    public function getBody() {
        return $this->body;
    }

    public function setBody($body) {
        $this->body = $body;
        return $this;
    }
}
