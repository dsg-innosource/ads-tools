<?php

namespace ResultData\ADSTools;

use Illuminate\Support\Facades\DB;

class Table
{
    public $name;

    public $type;

    public $rowCount;

    public $connection;

    public $columns;

    public function __construct($name, $type, $rowCount, Connection $connection)
    {
        $this->name = $name;
        $this->connection = $connection;
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
        $c = DB::connection($this->connection->getConnectionName())->getPdo();

        $s = $c->prepare("select * from information_schema.columns where table_name = '{$this->name}'");

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
}
