<?php
namespace MsPhp\Quality\Entity;

class DatabaseColumnExistence extends Database {
    protected $schemaName;
    protected $tableName;

    public function setSchemaName($schemaName) {
        $this->schemaName = $schemaName;
        return $this;
    }

    public function setTableName($tableName) {
        $this->tableName = $tableName;
        return $this;
    }
    
    public function setResult($columnName){
        $schemas = $this->database->setColumns($this->schemaName,$this->tableName)->getColumns();
        foreach($schemas as $row){
            if($row['column_name'] == $columnName){
                $this->result = true;
                break;
            }
        }
        parent::setResult($columnName);
        return $this;
    }
}
