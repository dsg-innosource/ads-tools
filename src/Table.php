<?php

namespace InnoSource\ADSTools;

use Illuminate\Support\Facades\DB;

class Table
{
    public $name;

    public $type;

    public $rowCount;

    public $database;

    public $databaseName;

    public $columns;

    public function __construct($name, $type, $schema, $rowCount, Database $database)
    {
        $this->name = $name;
        $this->database = $database;
        $this->databaseName = $database->name;
        $this->schema = $schema;
        $this->rowCount = $rowCount;

        switch ($type) {
            case 'BASE TABLE':
                $this->type = 'Table';
                break;

            default:
                $this->type = 'View';

                break;
        };
        
        $this->loadColumns();
    }

    public function loadColumns()
    {
        $c = DB::connection($this->database->connection['name'])->getPdo();

        $s = $c->prepare($this->database->getColumnsQuery($this));

        $s->execute();

        $results = $s->fetchAll(\PDO::FETCH_ASSOC);
        $this->columns = $this->database->formatColumns($results);

        return $this;
    }

    public function __toString()
    {
        return json_encode($this->toArray());
    }

    public function toArray()
    {
        return [
            'name' => $this->name,
            'schema' => $this->schema,
            'type' => $this->type,
            'rowCount' => $this->rowCount,
            'columns' => $this->columns->map->toArray()->toArray(),
            'database' => $this->databaseName,
        ];
    }
}
