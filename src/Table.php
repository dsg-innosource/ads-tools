<?php

namespace ResultData\ADSTools;

use Illuminate\Support\Facades\DB;

class Table
{
    public $name;

    public $type;

    public $rowCount;

    public $database;

    public $columns;

    public function __construct($name, $type, $rowCount, Database $database)
    {
        $this->name = $name;
        $this->database = $database;
        $this->rowCount = $rowCount;

        switch ($type) {
            case 'BASE TABLE':
                $this->type = 'Table';
                break;

            default:
                $this->type = 'View';

                break;
        };

        $this->getColumns();
    }

    public function getColumns()
    {
        $c = DB::connection($this->database->connection['name'])->getPdo();

        $s = $c->prepare("select * from information_schema.columns where table_name = '" . $this->name . "' and table_schema = '" . $this->database->name . "'");

        $s->execute();

        $results = $s->fetchAll(\PDO::FETCH_ASSOC);

        $this->columns = collect($results)->map(function ($c) {
            return new Column(
                $c['COLUMN_NAME'],
                $c['COLUMN_TYPE'],
                $c['COLUMN_DEFAULT'],
                $c['IS_NULLABLE']
            );
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
            'name' => $this->name,
            'type' => $this->type,
            'rowCount' => $this->rowCount,
            'columns' => $this->columns->map->toArray()->toArray(),
            'database' => $this->database->name,
        ];
    }
}
