<?php

namespace MsPhp\App\Entity;

use MsPhp\App\Entity\Cookie;
use MsPhp\App\Entity\Session;

class TimeZone {

    public static function setDetection(string $timeZoneCookieName): void {
        Session::remove('time-zone-cookie-name');
        Session::store('time-zone-cookie-name',$timeZoneCookieName);
    }
    public static function name(): bool | string {
        $cookieName = Session::retrieve('time-zone-cookie-name');
        if($cookieName !== false){
            $timeZoneOffset = Cookie::retrieve($cookieName);
            if($timeZoneOffset !== false){
                /**
                 * offset = 120:
                 * 1 with daylight saving (Europe/Paris)
                 * 0 without daylight saving (Europe/Helsinki)
                 */
                return timezone_name_from_abbr("", $timeZoneOffset*60,1);
            }
        }
        return false;
    }
}
