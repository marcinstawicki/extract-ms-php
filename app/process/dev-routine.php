<?php

namespace MsPhp\App\Process;

use MsPhp\Entity\Attribute\Prototype\Person;
use MsPhp\FileCache\Entity\FileCacheMinute;

class DevRoutine extends Routine {

    public function __construct() {
        parent::__construct();
    }

    protected function isSecureRequest(): bool
    {
        $this->includeUser(false);
        return true;
    }

    protected function setUser(bool $isAuthenticated, array | bool | Person $user = null): DevRoutine
    {
        $timeZoneOffset = 2;
        $secondsOffset = $timeZoneOffset * 60 * 60;
        $timeZone = timezone_name_from_abbr('', $secondsOffset, date('I'));
        $languageID = 39;
        $person = (new Person())
            ->setID(1)
            ->addEmailAddress('')
            ->setRoles([1,2,3,4,5,6,7,8,9,10])
            ->setTimeZoneOffset($timeZoneOffset)
            ->setLocale('en')
            ->setCurrentLanguageID($languageID)
            ->setTimeZone($timeZone)
            ->setToken('')
            ->setVector('');
        $this->user = $person;
        FileCacheMinute::set($this->token, $person, $this->storagePath);
        return $this;
    }
}


