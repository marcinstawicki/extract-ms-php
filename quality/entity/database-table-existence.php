<?php
namespace MsPhp\Quality\Entity;

class DatabaseTableExistence extends Database {
    protected $schemaName;

    public function setSchemaName($schemaName) {
        $this->schemaName = $schemaName;
        return $this;
    }

    public function setResult($tableName){
        $schemas = $this->database->setTables($this->schemaName)->getTables();
        foreach($schemas as $row){
            if($row['table_name'] == $tableName){
                $this->result = true;
                break;
            }
        }
        parent::setResult($tableName);
        return $this;
    }
}


