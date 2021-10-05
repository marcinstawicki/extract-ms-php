<?php
namespace MsPhp\App\Entity;

use MsPhp\Google\TextToSpeech\Entity\TextToSpeech;
use MsPhp\Payment\PayPal\Entity\PayPal;

class Configuration {
    protected string $timeZone = 'Europe/Berlin';
    protected int $errorReporting = E_ALL;
    protected Smtp $smtp;
    protected Imap $imap;
    protected PayPal $payPal;
    protected Database $database;
    protected \SQLite3 $sqlite;
    protected TextToSpeech $textToSpeech;
    protected Redis $redis;
    protected string $adminEmail = '';
    protected string $testingEmail = '';
    protected int $indexCheckpointID = 0;
    protected string $uriTokenInitialisationVector = '';
    protected string $uriTokenSalt = '';
    protected string $locale = '';
    protected array $locales = [];
    protected string $languageCode = '';
    protected string $currencyCode = '';
    protected array $languageCodes = [];
    protected array $currencyCodes = [];
    protected array $internHosts = [];
    protected string $noAccessType = 'NO_ACCESS_TYPE_SOFT';
    const NO_ACCESS_TYPE_SOFT = 'NO_ACCESS_TYPE_SOFT';
    const NO_ACCESS_TYPE_HARD = 'NO_ACCESS_TYPE_HARD';
    const ENVIRONMENT_DEV = 'dev';
    const ENVIRONMENT_INT = 'int';
    const ENVIRONMENT_PRO = 'pro';
    protected string $environment = self::ENVIRONMENT_DEV;

    public function setErrorReporting(int $errorReporting): Configuration {
        $this->errorReporting = $errorReporting;
        return $this;
    }
    public function setTimeZone(string $timeZone): Configuration {
        $this->timeZone = $timeZone;
        return $this;
    }
    public function setSmtp(Smtp $instance){
        $this->smtp = $instance;
        return $this;
    }
    public function setImap(Imap $instance){
        $this->imap = $instance;
        return $this;
    }
    public function setPayPal(PayPal $instance): Configuration {
        $this->payPal = $instance;
        return $this;
    }
    public function setDatabase(Database $instance): Configuration {
        $this->database = $instance;
        return $this;
    }
    public function getSqlite(): \SQLite3
    {
        return $this->sqlite;
    }
    public function setSqlite(\SQLite3 $sqlite): Configuration
    {
        $this->sqlite = $sqlite;
        return $this;
    }

    public function setRedis(Redis $instance): Configuration {
        $this->redis = $instance;
        return $this;
    }
    public function setAdminEmail(string $adminEmail): Configuration {
        $this->adminEmail = $adminEmail;
        return $this;
    }
    public function setNoAccessType(string $noAccessType = self::NO_ACCESS_TYPE_HARD): Configuration {
        $this->noAccessType = $noAccessType;
    }
    public function setLocale(string $locale): Configuration {
        $this->locale = $locale;
        return $this;
    }
    public function setLanguageCodes(array $languageCodes): Configuration {
        $this->languageCodes = $languageCodes;
        return $this;
    }
    public function setCurrencyCodes(array $currencyCodes): Configuration {
        $this->currencyCodes = $currencyCodes;
        return $this;
    }
    public function setLocales(array $locales): Configuration {
        $this->locales = $locales;
        return $this;
    }
    public function setLanguageCode(string $languageCode): Configuration {
        $this->languageCode = $languageCode;
        return $this;
    }
    public function setCurrencyCode(string $currencyCode): Configuration {
        $this->currencyCode = $currencyCode;
        return $this;
    }
    public function setTextToSpeech(TextToSpeech $instance): Configuration {
        $this->textToSpeech = $instance;
        return $this;
    }
    public function setIndexCheckpointID(int $checkpointID): Configuration {
        $this->indexCheckpointID = $checkpointID;
        return $this;
    }
    public function setInternHosts(array $internHosts): Configuration
    {
        $this->internHosts = $internHosts;
        return $this;
    }
    public function addInternHost(string $internHost): Configuration
    {
        $this->internHosts[] = $internHost;
        return $this;
    }
    public function setEnvironment(string $environment): Configuration
    {
        $this->environment = $environment;
        return $this;
    }
    public function getLanguageCode(): string {
        return $this->languageCode;
    }
    public function getLocales(): array {
        return $this->locales;
    }
    public function getPayPal(): PayPal {
        return $this->payPal;
    }
    public function getDatabase(): Database {
        return $this->database;
    }
    public function getTextToSpeech(): TextToSpeech {
        return $this->textToSpeech;
    }
    public function getRedis(): Redis {
        return $this->redis;
    }
    public function getSmtp(): Smtp {
        return $this->smtp;
    }
    public function getIndexCheckpointID(): int {
        return $this->indexCheckpointID;
    }
    public function getNoAccessType(): string {
        return $this->noAccessType;
    }
    public function getLocale(): string {
        return $this->locale;
    }
    public function getLanguageCodes(): array {
        return $this->languageCodes;
    }
    public function getCurrencyCodes(): array {
        return $this->currencyCodes;
    }
    public function getInternHosts(): array
    {
        return $this->internHosts;
    }
    public function isInternHost(string $internHost): bool
    {
        return array_key_exists($internHost,$this->internHosts);
    }
    public function getEnvironment(): string
    {
        return $this->environment;
    }
}
