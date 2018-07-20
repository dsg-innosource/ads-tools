<?php

namespace ResultData\ADSTools;

use Illuminate\Support\Facades\DB;

class Connection
{
    public $connections;
    public $connection;
    public $driver;
    public $tables;

    public function __construct()
    {
        $this->connections = config('database.connections');
    }

    public function connect($connectionName)
    {
        $this->connection = collect($this->connections)->filter(function ($c) use ($connectionName) {
            return $c['database'] == $connectionName;
        })->toArray();

        $this->driver = $this->connection[$this->getConnectionName()]['driver'];

        $this->getTableList();

        return $this;
    }
    
    public function getTableList()
    {
        $c = DB::connection($this->getConnectionName())->getPdo();

        $s = $c->prepare("select * from information_schema.tables where table_schema = '{$this->getConnectionName()}'");

        $s->execute();

        $results = $s->fetchAll(\PDO::FETCH_ASSOC);
        
        $this->tables = collect($results)->map(function ($t) {
            return new Table($t['TABLE_NAME'], $t['TABLE_TYPE'], $t['TABLE_ROWS'], $this);
        });
        
        return $this;
    }

    public function getConnectionName()
    {
        return array_keys($this->connection)[0];
    }

    public function getAll()
    {
        return $this->connections;
    }
}
