<?php
namespace MsPhp\Quality\Entity;

class DatabaseSchemaExistence extends Database {
    public function setResult($schemaName){
        $schemas = $this->database->setSchemas()->getSchemas();
        foreach($schemas as $row){
            if($row['schema_name'] == $schemaName){
                $this->result = true;
                break;
            }
        }
        parent::setResult($schemaName);
        return $this;
    }
}

