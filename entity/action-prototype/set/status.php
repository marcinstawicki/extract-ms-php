<?php
namespace MsPhp\Entity\ActionPrototype\Set;

use MsPhp\App\Entity\Env;
use MsPhp\App\Entity\XmlHttpResponse;

abstract class Status {

    protected string $schema = '';
    protected string $field = '';
    protected int $ID;
    protected mixed $status;

    public function __construct(){
        $this->status = str_replace("'","''", $this->status);
        $sql =<<<QUERY
            UPDATE {$this->schema}.{$this->field}
            SET {$this->field}='{$this->status}'
            WHERE id={$this->ID};
QUERY;
        Env::clientSQL()
            ->setQuery($sql)
            ->setResult();
        $response = (new XmlHttpResponse())
            ->setSuccess($this->ID)
            ->setPostHash(Env::postHash())
            ->setResult();
        echo $response->getResult();
        die();
    }
}


