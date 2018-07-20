<?php

namespace ResultData\ADSTools;

use Illuminate\Support\Facades\DB;

class Database
{
    public $name;
    public $connection;
    public $tables;

    public function __construct($connection)
    {
        $this->connection = $connection;
        $this->name = $connection['database'];
        $this->getTables();
    }

    public function getTables()
    {
        $c = DB::connection($this->connection['name'])->getPdo();

        $s = $c->prepare("select * from information_schema.tables where table_schema = '{$this->name}'");

        $s->execute();

        $results = $s->fetchAll(\PDO::FETCH_ASSOC);

        $this->tables = collect($results)->map(function ($t) {
            return new Table($t['TABLE_NAME'], $t['TABLE_TYPE'], $t['TABLE_ROWS'], $this);
        });

        return $this;
    }

    public function __toString()
    {
        return json_encode($this->toArray());
    }

    public function toArray()
    {
        return [
            'type' => 'database',
            'name' => $this->name,
            'connection' => $this->connection,
            'tables' => $this->tables->map->toArray()->toArray(),
        ];
    }
}
