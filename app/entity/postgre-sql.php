<?php
namespace MsPhp\App\Entity;

class PostgreSql extends Storage {

    protected $connection;
    protected array $schemas = [];
    protected array $tables = [];
    protected array $columns;
    protected string $query;
    protected $result;

    public function setConnection(Database $service, ?bool $force = false): PostgreSql {
        if(is_null($service->getPassword())){
            $dns=<<<DNS
                host={$service->getHost()} dbname={$service->getName()} user={$service->getUserName()}
DNS;
        } else {
            $dns=<<<DNS
                host={$service->getHost()} port={$service->getPort()} dbname={$service->getName()} user={$service->getUserName()} password={$service->getPassword()}
DNS;
        }
        if($force === true) {
            $this->connection = pg_pconnect($dns,PGSQL_CONNECT_FORCE_NEW);
        } else {
            $this->connection = pg_pconnect($dns);
        }
        return $this;
    }
    public function getConnectionStatus(): bool
    {
        $result = false;
        if(is_resource($this->connection)){
            $status = pg_connection_status($this->connection);
            if ($status === PGSQL_CONNECTION_OK) {
                $result = true;
            }
        }
        return $result;
    }
    public function setQuery(string $query): PostgreSql {
        $this->query = trim(preg_replace('/\s+/', ' ',$query));
        return $this;
    }
    public function setResult(?string $sql = null, ?array $params = null): PostgreSql {
        if(is_null($sql)){
            if(is_null($this->query)){
                return $this;
            } else {
                $sql = $this->query;
            }
        }
        if (is_null($params)) {
            $result = pg_query($this->connection, $sql);
        } else {
            $result = pg_query_params($this->connection, $sql, $params);
        }
        $this->result = $result;
        unset($result);
        return $this;
    }
    public function setSchemas():PostgreSql{
        $sql =<<<QUERY
         SELECT schema_name 
         FROM information_schema.schemata
QUERY;
        $this->schemas = $this->setResult($sql)->getResult();
        return $this;
    }
    public function setTables(string $schema):PostgreSql{
        $sql =<<<QUERY
         SELECT table_name 
         FROM information_schema.tables 
         WHERE table_schema='$schema'
QUERY;
        $this->tables = $this->setResult($sql)->getResult();
        return $this;
    }
    public function setColumns(string $schema,string $tableName): PostgreSql{
        $sql =<<<QUERY
         SELECT *
            FROM information_schema.columns
            WHERE table_schema = '$schema'
              AND table_name   = '$tableName';
QUERY;
        $this->columns = $this->setResult($sql)
            ->getResult();
        return $this;
    }
    public function getResult(?int $lineNumber = null) {
        $lines = [];
        if (pg_num_rows($this->result) > 0) {
            $count = 0;
            while ($line = pg_fetch_assoc($this->result)) {
                $lines[] = $line;
                if (!is_null($lineNumber) && $count == $lineNumber) {
                    $lines = $line;
                    break;
                }
                $count++;
            }
        }
        pg_free_result($this->result);
        return $lines;
    }
    public function getSchemas(): array {
        return $this->schemas;
    }
    public function getTables(): array {
        return $this->tables;
    }
    public function getColumns(): array {
        return $this->columns;
    }
}
