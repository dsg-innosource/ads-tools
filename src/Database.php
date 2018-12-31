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
        $this->loadTables();
    }

    public static function get($connection)
    {
        switch ($connection['driver']) {
            case 'mysql':
                return new MySQL($connection);
                break;
            case 'sqlsrv':
                return new SqlSrv($connection);
                break;
        }
    }

    public function loadTables()
    {
        $c = DB::connection($this->connection['name'])->getPdo();

        $s = $c->prepare($this->getTablesQuery());

        $s->execute();

        $results = $s->fetchAll(\PDO::FETCH_ASSOC);

        $this->tables = $this->formatTables($results);

        return $this;
    }

    public function getPreviewFromTable($table)
    {
        return DB::connection($this->connection['name'])->table($table)->inRandomOrder()->limit(5)->get();
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
