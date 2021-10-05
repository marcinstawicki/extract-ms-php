<?php
namespace MsPhp\Conversion\Entity;

use MsPhp\App\Entity\PostgreSql;

class ConversionSqlVocabularyItemId extends Conversion {
    protected $languageId;
    public function setLanguageId(int $languageId){
        $this->languageId = $languageId;
        return $this;
    }
    public function setResult() {
        if(!empty($this->value)){
            $value = str_replace("''","'",strip_tags(trim($this->value)));
            $value = str_replace("'","''",$value);
            $db = PostgreSql::getInstance();
            $sql =<<<QUERY
            SELECT id 
            FROM vocabulary_item.string AS t0
            INNER JOIN vocabulary_item.language_id AS t1 USING (id)
            WHERE string='$value'
            AND t1.language_id={$this->languageId};
QUERY;
            $db->setQuery($sql)->setResult();
            $result = $db->getResult();
            if(!empty($result)) {
                $id = (int) $result[0]['id'];
            } else {
                $sql =<<<QUERY
                WITH q1 AS (INSERT INTO vocabulary_item.type_id (type_id) VALUES(1) RETURNING id),
                q2 AS (INSERT INTO vocabulary_item.string (id,string) SELECT id, '$value' FROM q1 RETURNING id)
                INSERT INTO vocabulary_item.language_id (id,language_id) SELECT id, {$this->languageId} FROM q2 RETURNING id;
QUERY;
                $db->setQuery($sql)->setResult();
                $result = $db->getResult();
                $id = (int) $result[0]['id'];
            }
            $this->result = $id;
        }
        return $this;
    }
}
