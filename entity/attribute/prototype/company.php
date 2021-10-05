<?php

namespace MsPhp\Entity\Attribute\Prototype;

class Company {
    protected $address;
    protected $bankAccount;
    protected $channelOfDistribution;
    protected $companyName;
    protected $companyRegistrationNumber;
    protected $employmentSize;
    protected $industrialClassification;
    protected $relationType;
    protected $typeOfBusiness;
    protected $vatIdentificationNumber;
    protected $website;

    public function getAddress() {
        return $this->address;
    }
    public function setAddress(Address $instance) {
        $this->address = $instance;
        return $this;
    }
    public function getBankAccount() {
        return $this->bankAccount;
    }
    public function setBankAccount(BankAccount $instance) {
        $this->bankAccount = $instance;
        return $this;
    }
    public function getChannelOfDistribution() {
        return $this->channelOfDistribution;
    }
    public function setChannelOfDistribution($channelOfDistribution) {
        $this->channelOfDistribution = $channelOfDistribution;
        return $this;
    }
    public function getCompanyName() {
        return $this->companyName;
    }
    public function setCompanyName($companyName) {
        $this->companyName = $companyName;
        return $this;
    }
    public function getCompanyRegistrationNumber() {
        return $this->companyRegistrationNumber;
    }
    public function setCompanyRegistrationNumber($companyRegistrationNumber) {
        $this->companyRegistrationNumber = $companyRegistrationNumber;
        return $this;
    }
    public function getEmploymentSize() {
        return $this->employmentSize;
    }
    public function setEmploymentSize($employmentSize) {
        $this->employmentSize = $employmentSize;
        return $this;
    }
    public function getIndustrialClassification() {
        return $this->industrialClassification;
    }
    public function setIndustrialClassification($industrialClassification) {
        $this->industrialClassification = $industrialClassification;
        return $this;
    }
    public function getRelationType() {
        return $this->relationType;
    }
    public function setRelationType($relationType) {
        $this->relationType = $relationType;
        return $this;
    }
    public function getTypeOfBusiness() {
        return $this->typeOfBusiness;
    }
    public function setTypeOfBusiness($typeOfBusiness) {
        $this->typeOfBusiness = $typeOfBusiness;
        return $this;
    }
    public function getVatIdentificationNumber() {
        return $this->vatIdentificationNumber;
    }
    public function setVatIdentificationNumber($vatIdentificationNumber) {
        $this->vatIdentificationNumber = $vatIdentificationNumber;
        return $this;
    }
    public function getWebsite() {
        return $this->website;
    }
    public function setWebsite($website) {
        $this->website = $website;
        return $this;
    }
}
