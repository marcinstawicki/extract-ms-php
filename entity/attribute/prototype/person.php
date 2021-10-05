<?php
namespace MsPhp\Entity\Attribute\Prototype;

class Person extends Prototype {

    protected string $gender = '';
    protected string $salutation = '';
    protected string $title = '';
    protected string $forename = '';
    protected string $middleName = '';
    protected string $surname = '';
    protected ?string $photo = '';
    protected int $age = 0;
    protected string $dayOfBirth = '';
    protected int $height = 0;
    protected int $weight = 0;
    protected array $languages = [];
    protected ?int $currentLanguageId = 39;
    protected ?string $locale = '';
    protected array $addresses = [];
    protected ?Company $employer = null;
    protected array $phoneNumbers = [];
    protected array $emailAddresses = [];
    /**
     * timezone is also defined for the country
     * this one is because people travel and are in many places for a while!!
     */
    protected ?string $timeZone = '';
    protected ?int $timeZoneOffset;
    protected string $religion = '';
    protected string $martialStatus = '';
    protected string $token = '';
    protected string $vector = '';
    protected string $temporaryToken = '';
    protected ?string $authenticationCookie = '';
    /**
     * @var array
     * privileges and obligations are part of each role
     */
    protected array $roles = [];

    public function __construct(){
        parent::__construct();
    }

    public function setGender(string $gender): Person {
        $this->gender = $gender;
        return $this;
    }
    public function setSalutation(string $salutation): Person {
        $this->salutation = $salutation;
        return $this;
    }
    public function setTitle(string $title): Person {
        $this->title = $title;
        return $this;
    }
    public function setForename(string $forename): Person {
        $this->forename = $forename;
        return $this;
    }
    public function setMiddleName(string $middleName): Person {
        $this->middleName = $middleName;
        return $this;
    }
    public function setSurname(string $surname): Person {
        $this->surname = $surname;
        return $this;
    }
    public function getPhoto(): string {
        return $this->photo;
    }
    public function setPhoto(?string $photo): Person
    {
        $this->photo = $photo;
        return $this;
    }
    public function setAge(int $age): Person {
        $this->age = $age;
        return $this;
    }
    public function setDayOfBirth(string $dayOfBirth): Person {
        $this->dayOfBirth = $dayOfBirth;
        return $this;
    }
    public function setHeight(float $height): Person {
        $this->height = $height;
        return $this;
    }
    public function setWeight(float $weight): Person {
        $this->weight = $weight;
        return $this;
    }
    public function addLanguage(string $languageName): Person {
        if(!in_array($languageName,$this->languages)){
            $this->languages[] = $languageName;
        }
        $this->languages[] = $languageName;
        return $this;
    }
    public function setCurrentLanguageID(?int $currentLanguageId): Person {
        $this->currentLanguageId = $currentLanguageId;
        return $this;
    }
    public function addAddress(Address $instance): Person {
        if(!in_array($instance,$this->addresses)){
            $this->addresses[] = $instance;
        }
        return $this;
    }
    public function setTimeZone(?string $timeZone): Person {
        $this->timeZone = $timeZone;
        return $this;
    }

    public function getTimeZoneOffset(): int
    {
        return $this->timeZoneOffset;
    }

    public function setTimeZoneOffset(?int $timeZoneOffset): Person
    {
        $this->timeZoneOffset = $timeZoneOffset;
        return $this;
    }

    public function setEmployer(Company $instance): Person {
        $this->employer = $instance;
        return $this;
    }
    public function addPhoneNumber(PhoneNumber $instance): Person {
        if(!in_array($instance,$this->phoneNumbers)){
            $this->phoneNumbers[] = $instance;
        }
        return $this;
    }
    public function addEmailAddress(string $emailAddress): Person {
        if(!in_array($emailAddress,$this->emailAddresses)){
            $this->emailAddresses[] = $emailAddress;
        }
        return $this;
    }
    public function setReligion(string $religion): Person {
        $this->religion = $religion;
        return $this;
    }
    public function setMartialStatus(string $martialStatus): Person {
        $this->martialStatus = $martialStatus;
        return $this;
    }
    public function addRole(int $role): Person {
        if(!in_array($role,$this->roles)) {
            $this->roles[] = $role;
        }
        return $this;
    }
    public function setRoles(array $roles): Person {
        $this->roles = $roles;
        return $this;
    }
    public function getLocale() {
        return $this->locale;
    }
    public function setLocale(?string $locale = null): Person {
        $this->locale = $locale;
        return $this;
    }
    //
    public function getGender() {
        return $this->gender;
    }
    public function getSalutation() {
        return $this->salutation;
    }
    public function getTitle() {
        return $this->title;
    }
    public function getForename() {
        return $this->forename;
    }
    public function getMiddleName() {
        return $this->middleName;
    }
    public function getSurname() {
        return $this->surname;
    }
    public function getAge() {
        return $this->age;
    }
    public function getDayOfBirth() {
        return $this->dayOfBirth;
    }
    public function getHeight() {
        return $this->height;
    }
    public function getWeight() {
        return $this->weight;
    }
    public function getLanguages(): array {
        return $this->languages;
    }
    public function getCurrentLanguageID() {
        return $this->currentLanguageId;
    }
    public function getAddresses(): array {
        return $this->addresses;
    }
    public function getTimeZone() {
        return $this->timeZone;
    }
    public function getEmployer() {
        return $this->employer;
    }
    public function getPhoneNumbers(): array {
        return $this->phoneNumbers;
    }
    public function getEmailAddresses() {
        return $this->emailAddresses;
    }
    public function getEmailAddress(int $index) {
        return $this->emailAddresses[$index];
    }
    public function getReligion() {
        return $this->religion;
    }
    public function getMartialStatus() {
        return $this->martialStatus;
    }
    public function getRoles(): array {
        return $this->roles;
    }
    public function getToken()
    {
        return $this->token;
    }
    public function setToken(string $token)
    {
        $this->token = $token;
        return $this;
    }
    public function getVector(): string
    {
        return $this->vector;
    }
    public function setVector(string $vector): Person
    {
        $this->vector = $vector;
        return $this;
    }
    public function getAuthenticationCookie(): ?string
    {
        return $this->authenticationCookie;
    }
    public function setAuthenticationCookie(?string $authenticationCookie = null): Person
    {
        $this->authenticationCookie = $authenticationCookie;
        return $this;
    }

}
