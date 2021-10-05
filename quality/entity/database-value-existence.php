<?php
namespace MsPhp\Quality\Entity;

class DatabaseValueExistence extends Database {
    protected $schemaName;
    protected $tableName;
    protected $columnName;

    public function setSchemaName($schemaName) {
        $this->schemaName = $schemaName;
        return $this;
    }

    public function setTableName($tableName) {
        $this->tableName = $tableName;
        return $this;
    }

    public function setColumnName($columnName) {
        $this->columnName = $columnName;
        return $this;
    }

    public function setResult($value){
        $sql =<<<QUERY
        SELECT 
          {$this->columnName}
        FROM {$this->schemaName}.{$this->tableName}
        WHERE {$this->columnName}='$value' 
        LIMIT 1
QUERY;
        $this->database->setResult($sql);
        if(!empty($this->database->getResult())){
            $this->result = true;
        }
        parent::setResult($value);
        return $this;
    }
}

