<?php
namespace MsPhp\App\Entity;

class Database extends Service {

    const POSTGRE_SQL = 'PostgreSql';
    const MY_SQL = 'MySql';
    protected string $driver = '';
    public function getDriver(): string {
        return $this->driver;
    }
    public function setDriver(string $driver): Database {
        if($driver === self::POSTGRE_SQL || $driver === self::MY_SQL) {
            $this->driver = $driver;
        }
        return $this;
    }
}
