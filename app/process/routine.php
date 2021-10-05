<?php

namespace MsPhp\App\Process;

use MsPhp\App\Entity\Configuration;
use MsPhp\App\Entity\Env;
use MsPhp\App\Entity\Smtp;
use MsPhp\App\Entity\Uri;
use MsPhp\App\Entity\PostgreSql;
use MsPhp\App\Entity\Session;
use MsPhp\App\Entity\UriAdvanced;
use MsPhp\Conversion\Entity\ConversionCamelCase;
use MsPhp\Entity\Attribute\Prototype\Person;
use MsPhp\FileCache\Entity\FileCacheDay;
use MsPhp\FileCache\Entity\FileCacheHour;
use MsPhp\FileCache\Entity\FileCacheMinute;
use MsPhp\FileCache\Entity\FileCacheWeek;
use MsPhp\Google\TextToSpeech\Entity\TextToSpeech;
use MsPhp\Payment\PayPal\Entity\PayPal;
use MsPhp\Quality\Entity\QualityCheckpoint;
use MsPhp\Security\Process\Security;
use SQLite3;

class Routine
{
    protected Configuration $configuration;
    protected ?Person $user = null;
    protected ?PostgreSql $clientSql = null;
    protected SQLite3 $clientSqlite;
    protected PayPal $clientPayPal;
    protected TextToSpeech $clientGoogleTextToSpeech;
    protected Smtp $clientSmtp;
    protected int $userID;
    protected int $roleID;
    protected int $routeID;
    protected int $checkpointCount = 0;
    protected bool $isLog = false;
    protected array $routeCheckpoints = [];
    protected array $gets = [];
    protected array $languages = [];
    protected array $currencies = [];
    protected ?array $phraseBook = [];
    protected array $internHosts = [];
    protected array $locales = [];
    protected array $routeCheckpoint = [];
    protected string $environment;
    protected string $locale = 'en';
    protected string $workingClass = '';
    protected string $vector = '';
    protected string $token = '';
    protected string $msPhpPath;
    protected string $privatePath;
    protected string $publicPath;
    protected string $modulePath;
    protected string $storagePath;
    protected string $log;

    public function __construct()
    {
        $documentRoot = $_SERVER['DOCUMENT_ROOT'];
        $root = dirname($documentRoot);
        $this->publicPath = $root . DIRECTORY_SEPARATOR . 'public';
        $this->privatePath = $root . DIRECTORY_SEPARATOR . 'private';
        $this->msPhpPath = $this->privatePath . DIRECTORY_SEPARATOR . 'ms-php';
        $this->modulePath = $this->privatePath . DIRECTORY_SEPARATOR . 'module';
        $this->storagePath = $this->privatePath . DIRECTORY_SEPARATOR . 'storage';
    }

    public function setConfiguration(Configuration $configuration): Routine
    {
        $this->configuration = $configuration;
        $this->clientSqlite = $configuration->getSqlite();
        $this->clientPayPal = $configuration->getPayPal();
        $this->clientGoogleTextToSpeech = $configuration->getTextToSpeech();
        $this->clientSmtp = $configuration->getSmtp();
        $this->environment = $configuration->getEnvironment();
        $this->locales = $configuration->getLocales();
        $this->locale = $configuration->getLocale();
        $this->languages = $configuration->getLanguageCodes();
        $this->currencies = $configuration->getCurrencyCodes();
        $this->internHosts = $configuration->getInternHosts();
        return $this;
    }

    public function addCheckpoint(string $checkpoint, array $roles = []): Routine
    {
        $this->routeCheckpoints[$checkpoint] = [
            'id' => ++$this->checkpointCount,
            'pathname' => $checkpoint,
            'roles' => $roles
        ];
        return $this;
    }
    public function getCheckpoints(): array
    {
        return $this->routeCheckpoints;
    }

    public function setIsLog(bool $isLog): Routine
    {
        $this->isLog = $isLog;
        return $this;
    }

    //
    protected function setLog($message): Routine
    {
        if ($this->isLog === true) {
            die($message);
        } else {
            die('r2');
        }
    }

    protected function setUser(bool $isAuthenticated, array | bool | Person $user = null): Routine
    {
        if (!$user instanceof Person) {
            $sql = <<<QUERY
                SELECT t01.id,
                       (SELECT gender_type FROM s00_person.gender_type WHERE id=t01.gender_type_id) as gender,
                       t02.forename,
                       t03.surname,
                       t04.email_address,
                       array_to_json(ARRAY(SELECT role_type_id FROM s00_person.role_type_id WHERE id=t01.id)) AS role_ids,
                       t06.photo,
                       (SELECT cookie FROM  s00_person.cookie WHERE id=t01.id AND cookie ILIKE '_%') AS cookie,
                       t07.time_zone_offset,
                       t08.locale,
                       t09.s01_language_id
                  FROM s00_person.gender_type_id        AS t01
            INNER JOIN s00_person.forename              AS t02 USING(id)
            INNER JOIN s00_person.surname               AS t03 USING(id)
            INNER JOIN s00_person.email_address         AS t04 USING(id)
             LEFT JOIN s00_person.photo                 AS t06 USING(id)
             LEFT JOIN s00_person.time_zone_offset      AS t07 USING(id)
             LEFT JOIN s00_person.locale                AS t08 USING(id)
             LEFT JOIN s00_person.s01_language_id       AS t09 USING(id)
                 WHERE t01.id={$this->userID} 
QUERY;
            $conn = $this->clientSql;
            $conn->setQuery($sql)
                ->setResult();
            $row = $conn->getResult();
            if (!empty($row)) {
                $user = $row[0];
                $sql = true;
            }
        }
        if (is_array($user)) {
            if(isset($sql)){
                $user['role_ids'] = json_decode($user['role_ids'],true);
            }
            $nUser = (object) $user;
            $timeZoneOffset = !is_null($nUser->time_zone_offset) ? $nUser->time_zone_offset : 2;
            $secondsOffset = $timeZoneOffset * 60 * 60;
            $timeZone = timezone_name_from_abbr('', $secondsOffset, date('I'));
            $languageID = !is_null($nUser->s01_language_id) ? (int) $nUser->s01_language_id : 39;
            $person = (new Person())
                ->setID($nUser->id)
                ->setGender($nUser->gender)
                ->setForename($nUser->forename)
                ->setSurname($nUser->surname)
                ->setPhoto($nUser->photo)
                ->addEmailAddress($nUser->email_address)
                ->setAuthenticationCookie($nUser->cookie)
                ->setRoles($nUser->role_ids)
                ->setTimeZoneOffset($timeZoneOffset)
                ->setLocale((string) $nUser->locale)
                ->setCurrentLanguageID($languageID)
                ->setTimeZone($timeZone)
                ->setToken($this->token)
                ->setVector($this->vector);
            $this->user = $person;
            if ($isAuthenticated === true) {
                FileCacheMinute::unset($this->token, $this->storagePath);
                Session::store('MsPhp\Entity\Attribute\Prototype\Person', $person);
            } else {
                FileCacheMinute::set($this->token, $person, $this->storagePath);
            }
        } else if ($user instanceof Person) {
            $this->user = $user;
        }
        return $this;
    }

    protected function includeUser(bool $isAuthenticated)
    {
        $user = Session::retrieve('MsPhp\Entity\Attribute\Prototype\Person');
        if ($user === false) {
            $user = FileCacheMinute::get($this->token, $this->storagePath);
            if ($user === null) {
                if ($this->setClientSql() === true) {
                    $this->setUser($isAuthenticated);
                } else {
                    $this->setLog('setClientSql');
                }
            } else {
                $this->setUser($isAuthenticated, $user);
            }
        } else {
            $this->setUser($isAuthenticated, $user);
        }
    }

    protected function resetFileCache(): Routine
    {
        FileCacheMinute::clear($this->storagePath);
        FileCacheHour::clear($this->storagePath);
        FileCacheDay::clear($this->storagePath);
        FileCacheWeek::clear($this->storagePath);
        return $this;
    }

    protected function isSecureRequest(): bool
    {
        $result = false;
        if (Security::isApprovedHttpAcceptedLanguage() === true) {
            if (Security::isApprovedHttpUserAgent() === true) {
                if (Security::isApprovedRemoteAddress() === true) {
                    if (Security::isApprovedRemoteAddressFrequency($this->storagePath) === true) {
                        if (Security::isApprovedUri() === true) {
                            $initialisationVectorCoordinates = Security::getInitialisationVectorCoordinates($this->clientSqlite, $this->environment, $this->storagePath);
                            if (is_array($initialisationVectorCoordinates) === true) {
                                $this->userID = (int)$initialisationVectorCoordinates[0];
                                $this->vector = (string)$initialisationVectorCoordinates[1];
                                $this->token = (string)$initialisationVectorCoordinates[2];
                                if (Security::isApprovedGETRequest($this->vector, $this->environment) === true) {
                                    $this->gets = $gets = Security::getGET($this->vector, $this->environment);
                                    if (Security::isAuthentication($this->routeCheckpoint['pathname']) === true) {
                                        $this->includeUser(false);
                                        if (Security::isValidAuthentication($gets) === true) {
                                            $result = true;
                                        } else {
                                            $lastResetTimestamp = FileCacheHour::get($this->user->getToken(), $this->storagePath);
                                            if ($lastResetTimestamp === false) {
                                                Security::resetAuthentication($this->user, $this->environment, $this->routeCheckpoints, $this->clientSmtp, $this->storagePath);
                                            }
                                        }
                                    } else {
                                        if (Security::isValidGETRequest($gets) === true) {
                                            if (Security::isXmlHttpRequest() === true) {
                                                if (Security::isValidXmlHttpRequest($this->vector) === false) {
                                                    $this->setLog('isValidXmlHttpRequest');
                                                }
                                            }
                                            if (Security::isAuthenticationCookie() === true) {
                                                if (Security::isApprovedAuthenticationCookie($this->vector) === true) {
                                                    $this->includeUser(true);
                                                    if (Security::isValidAuthenticationCookie($this->user) === true) {
                                                        if (Security::isApprovedPOSTRequest($this->vector) === true) {
                                                            if (Security::isApprovedFILESRequest() === true) {
                                                                if (Security::isApprovedPUTRequest() === true) {
                                                                    $result = true;
                                                                } else {
                                                                    $this->setLog('isApprovedPUTRequest');
                                                                }
                                                            } else {
                                                                $this->setLog('isApprovedFILESRequest');
                                                            }
                                                        } else {
                                                            $this->setLog('isApprovedPOSTRequest');
                                                        }
                                                    } else {
                                                        $this->setLog('isValidAuthenticationCookie');
                                                    }
                                                } else {
                                                    $this->setLog('isApprovedAuthenticationCookie');
                                                }
                                            } else {
                                                $this->includeUser(true);
                                                Security::resetAuthentication($this->user, $this->environment, $this->routeCheckpoints, $this->clientSmtp, $this->storagePath);
                                            }
                                        } else {
                                            $this->includeUser(false);
                                            Security::resetGETRequest($this->user, $this->environment,$this->routeCheckpoints,$this->routeCheckpoint['pathname']);
                                        }
                                    }
                                } else {
                                    $this->setLog('isApprovedGETRequest');
                                }
                            } else {
                                $this->setLog('getInitialisationVectorCoordinates');
                            }
                        } else {
                            $this->setLog('isApprovedUri');
                        }
                    } else {
                        $this->setLog('isApprovedRemoteAddressFrequency');
                    }
                } else {
                    $this->setLog('isApprovedRemoteAddress');
                }
            } else {
                $this->setLog('isApprovedHttpUserAgent');
            }
        } else {
            $this->setLog('isApprovedHttpAcceptedLanguage');
        }
        return $result;
    }

    protected function setRouteID(): Routine
    {
        $path = (new Uri())->getPath();
        $params = (new Uri())->getQuery();
        if ($path === '/') {
            $this->routeID = (int)$this->configuration->getIndexCheckpointID();
        } else {
            /**
             * if link dev used for pro -> redirection to pro url
             */
            $pathElements = explode('/', $path);
            if ($this->environment === Configuration::ENVIRONMENT_PRO) {
                if(!empty($params) && isset($params['_s']) && isset($params['_t'])){
                    $checkpointPath = ltrim(str_replace('/', '.', $path), '.');
                    if (isset($this->routeCheckpoints[$checkpointPath])) {
                        $initialisationVectorCoordinates = Security::getInitialisationVectorCoordinates($this->clientSqlite, Configuration::ENVIRONMENT_DEV, $this->storagePath);
                        $this->userID = (int)$initialisationVectorCoordinates[0];
                        $this->vector = (string)$initialisationVectorCoordinates[1];
                        $this->token = (string)$initialisationVectorCoordinates[2];
                        $sessionToken = Security::createSessionTokenValue();
                        Session::remove('_s');
                        Session::store('_s', $sessionToken);
                        $newQuery = array_merge(Security::getGET($this->vector, Configuration::ENVIRONMENT_DEV), ['_s' => $sessionToken]);
                        $this->includeUser(false);
                        $uri = (new UriAdvanced())
                            ->setEnvironment($this->environment)
                            ->setCheckpoints($this->routeCheckpoints)
                            ->setUser($this->user)
                            ->setCheckpoint($checkpointPath)
                            ->setQuery($newQuery);
                        $route = (new Reroute())->setUri($uri)
                            ->setDelay(1000)->setResult();
                        echo $route->getResult();
                        die('r1');
                    } else {
                        $this->routeID = (int)$this->configuration->getIndexCheckpointID();
                    }
                } else if (count($pathElements) === 3 && is_numeric($pathElements[1]) && $pathElements[1] < 200) {
                    $this->routeID = (int)$pathElements[1];
                } else {
                    $this->routeID = (int)$this->configuration->getIndexCheckpointID();
                }
            } else {
                $checkpointPath = ltrim(str_replace('/', '.', $path), '.');
                if (isset($this->routeCheckpoints[$checkpointPath])) {
                    $this->routeID = $this->routeCheckpoints[$checkpointPath]['id'];
                } else {
                    $this->routeID = (int)$this->configuration->getIndexCheckpointID();
                }
            }
        }
        return $this;
    }

    protected function setRouteCheckpoint(): Routine
    {
        foreach ($this->routeCheckpoints as $checkpoint => $params) {
            if ($params['id'] === $this->routeID) {
                $this->routeCheckpoint = $params;
                break;
            }
        }
        return $this;
    }

    protected function isRouteCheckpoint(): bool
    {
        return !empty($this->routeCheckpoints);
    }

    protected function setClientSql(): bool
    {
        $result = true;
        $dbService = $this->configuration->getDatabase();
        $db = (new PostgreSql())
            ->setConnection($dbService);
        if ($db->getConnectionStatus() === false) {
            $db->setConnection($dbService, true);
            if ($db->getConnectionStatus() === false) {
                $result = false;
            }
        }
        $this->clientSql = $db;
        return $result;
    }

    protected function isAccess(): bool
    {
        /**
         * checkpoints (all) / privileges (assigned)
         * module.process.entity
         * module.process.entity::get.name1
         * module.process.entity::post.name1
         * module.process.entity::put.name1
         * module.process.entity::files.name1
         * module.process.entity::custom.classname1
         */
        $checkpoint = (new QualityCheckpoint())
            ->setShallValue($this->routeCheckpoint['roles'])
            ->setIsValue($this->user->getRoles())
            ->setResult();
        return $checkpoint->getResult();
    }

    protected function setLanguageSupport(): Routine
    {
        if (isset($this->gets['_l'])) {
            foreach ($this->locales as $locale => $data) {
                if ($locale === $this->gets['_l']) {
                    $userID = $this->user->getID();
                    $sql = <<<QUERY
                        INSERT INTO s00_person.locale (id,locale) 
                             VALUES($userID,'$locale') 
          ON CONFLICT ON CONSTRAINT locale_pkey
                      DO UPDATE SET locale='$locale';
QUERY;
                    $conn = $this->clientSql;
                    $conn->setQuery($sql)
                        ->setResult();
                    $this->user->setLocale($locale);
                    $user = Session::retrieve('MsPhp\Entity\Attribute\Prototype\Person');
                    if ($user instanceof Person === true) {
                        Session::replace('MsPhp\Entity\Attribute\Prototype\Person',$this->user);
                    } else {
                        $user = FileCacheMinute::get($this->token, $this->storagePath);
                        if (!is_null($user)) {
                            FileCacheMinute::set($this->token, $user, $this->storagePath);
                        }
                    }
                    break;
                }
            }
        }
        $locale = $this->user->getLocale();
        if (empty($locale)) {
            if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) && !empty($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
                $locale = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
            }
            if (!empty($locale)) {
                if (!key_exists($locale, $this->locales)) {
                    $locale = $this->locale;
                }
            } else {
                $locale = $this->locale;
            }
        }
        $this->locale = (string) $locale;
        $this->user->setLocale($locale);
        //
        $phraseBookOrigin = include $this->storagePath.'/translation/en.inc';
        $phraseBook = $this->storagePath.'/translation/'.$locale.'.inc';
        if(!file_exists($phraseBook)){
            $phraseBook = $phraseBookOrigin;
        } else {
            $phraseBook = include $phraseBook;
        }
        $this->phraseBook = [$phraseBookOrigin,$phraseBook];
        $phraseBook = null;
        unset($phraseBook);
        return $this;
    }

    protected function isWorkingClass(): bool
    {
        return (bool)$this->workingClass;
    }

    protected function setWorkingClass(): Routine
    {
        $allParts = explode('::', $this->routeCheckpoint['pathname']);
        $route = explode('.', $allParts[0]);
        $workingClass = '\\Module';
        foreach ($route as $part) {
            $conversion = (new ConversionCamelCase())
                ->setMode(ConversionCamelCase::MODE_JOIN_WORDS)
                ->setValue($part)
                ->setResult();
            $workingClass .= '\\' . $conversion->getResult();
        }
        if (class_exists($workingClass, true) === true) {
            $this->workingClass = $workingClass;
        }
        return $this;
    }

    //
    public function setResult(): Routine
    {
        $this->resetFileCache()
            ->setRouteID()
            ->setRouteCheckpoint();
        if ($this->isSecureRequest() === true) {
            if ($this->isRouteCheckpoint() === true) {
                $this->setWorkingClass();
                if ($this->isWorkingClass() === true) {
                    if ($this->isAccess() === true) {
                        if(!is_resource($this->clientSql)){
                            $this->setClientSql();
                        }
                        $this->setLanguageSupport();
                        $GLOBALS['Routine'] = [
                            'checkpoints' => $this->routeCheckpoints,
                            'checkpoint' => $this->routeCheckpoint,
                            'environment' => $this->environment,
                            'intern-hosts' => $this->internHosts,
                            'locales' => $this->locales,
                            'languages' => $this->languages,
                            'currencies' => $this->currencies,
                            'route-id' => $this->routeID,
                            'user' => $this->user,
                            'phrase-book' => $this->phraseBook,
                            'public-path' => $this->publicPath,
                            'private-path' => $this->privatePath,
                            'storage-path' => $this->storagePath,
                            'ms-php-path' => $this->msPhpPath,
                            'module-path' => $this->modulePath,
                            'client-sql' => $this->clientSql,
                            'client-sqlite' => $this->clientSqlite,
                            'client-paypal' => $this->clientPayPal,
                            'client-google-tts' => $this->clientGoogleTextToSpeech,
                            '_p' => Security::getPostHash($this->vector),
                            '_xhr' => Security::getXhrHash($this->vector),
                            'GET' => Security::getGET($this->vector, $this->environment),
                            'POST' => Security::getPOST(),
                            'PUT' => Security::getPUT(),
                            'FILES' => Security::getFILES(),
                        ];
                        $process = (new $this->workingClass())
                            ->setResult();
                        echo $process->getResult();
                    } else {
                        $this->setLog('isAccess');
                    }
                } else {
                    $this->setLog('isWorkingClass');
                }
            } else {
                $this->setLog('isRouteCheckpoint');
            }
        } else {
            $this->setLog('isSecureRequest');
        }
        return $this;
    }
}


