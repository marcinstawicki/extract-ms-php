<?php
namespace MsPhp\Entity\ActionPrototype\Set;

use MsPhp\App\Entity\Env;
use MsPhp\App\Entity\XmlHttpResponse;

abstract class SortablePosition {

    protected $schema = '';
    protected $subQuery = '';

    public function __construct(){
        $id = (int) Env::POST('p0');
        $sort = (int) Env::POST('p1');
        $sql =<<<QUERY
            SELECT sort FROM {$this->schema}.sort WHERE id=$id;
QUERY;
        Env::clientSQL()
            ->setQuery($sql)
            ->setResult();
        $result = Env::clientSQL()
            ->getResult();
        $wasSort =  (int) $result[0]['sort'];
        if($wasSort !== $sort){
            $update = $wasSort < $sort ? 'BETWEEN '.$wasSort.' AND '.$sort : 'BETWEEN '.$sort.' AND '.$wasSort;
            $sign = $wasSort < $sort ? '-' : '+';
            $sql =<<<QUERY
                 BEGIN;
                UPDATE {$this->schema}.sort 
                   SET sort=sort $sign 1 
                 WHERE id IN({$this->subQuery}) 
                   AND sort $update;
                UPDATE {$this->schema}.sort SET sort=$sort WHERE id=$id;
                COMMIT;
QUERY;
            Env::clientSQL()
                ->setQuery($sql)
                ->setResult();
        }
        $response = (new XmlHttpResponse())
            ->setSuccess($id)
            ->setPostHash(Env::postHash())
            ->setResult();
        echo $response->getResult();
        die();
    }
}


