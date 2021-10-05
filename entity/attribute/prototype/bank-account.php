<?php
namespace MsPhp\Entity\Attribute\Prototype;

class BankAccount {
    protected $businessIdentifierCode;
    protected $bankName;
    protected $internationalBankAccountNumber;

    public function getBusinessIdentifierCode() {
        return $this->businessIdentifierCode;
    }
    public function setBusinessIdentifierCode($businessIdentifierCode) {
        $this->businessIdentifierCode = $businessIdentifierCode;
        return $this;
    }
    public function getBankName() {
        return $this->bankName;
    }
    public function setBankName($bankName) {
        $this->bankName = $bankName;
        return $this;
    }
    public function getInternationalBankAccountNumber() {
        return $this->internationalBankAccountNumber;
    }
    public function setInternationalBankAccountNumber($internationalBankAccountNumber) {
        $this->internationalBankAccountNumber = $internationalBankAccountNumber;
        return $this;
    }
}
