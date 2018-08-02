<?php

namespace ResultData\ADSTools;

use Illuminate\Support\Facades\DB;

class SqlSrv extends Database
{
    public function __construct($connection)
    {
        $this->connection = $connection;
        $this->name = $connection['database'];
        $this->loadTables();
    }

    public function formatTables($results)
    {
        return collect($results)->map(function ($t) {
            return new Table($t['TABLE_NAME'], 'BASE TABLE', $t['SCHEMA_NAME'], $t['TABLE_ROWS'], $this);
        });
    }

    public function formatColumns($raw_column_data)
    {
        return collect($raw_column_data)->map(function ($c) {
            return new Column(
                $c['COLUMN_NAME'],
                $c['DATA_TYPE'],
                $c['COLUMN_DEFAULT'],
                $c['IS_NULLABLE'],
                $c['CHARACTER_MAXIMUM_LENGTH']
            );
        });
    }

    public function getTablesQuery()
    {
        return 'SELECT
                    t.name TABLE_NAME,
                    s.name SCHEMA_NAME,
                    i.Rows TABLE_ROWS
                FROM        sys.tables t
                JOIN        sys.sysindexes I ON T.OBJECT_ID = I.ID
                JOIN        sys.schemas s on t.schema_id = s.schema_id
                WHERE       indid IN (0,1)
            ';
    }

    public function getColumnsQuery(Table $table)
    {
        return "SELECT
                    *
                FROM INFORMATION_SCHEMA.COLUMNS
                WHERE table_name = '$table->name'
                AND table_schema = '$table->schema'
            ";
    }

    public function getPreviewFromTable($table)
    {
        $data = DB::connection($this->connection['name'])->table($table)->limit(5)->get();
        return self::convert_from_latin1_to_utf8_recursively($data);
    }

    public static function convert_from_latin1_to_utf8_recursively($dat)
    {
        if (is_string($dat)) {
            return utf8_encode($dat);
        } elseif (is_array($dat)) {
            $ret = [];
            foreach ($dat as $i => $d) {
                $ret[$i] = self::convert_from_latin1_to_utf8_recursively($d);
            }

            return $ret;
        } elseif (is_object($dat)) {
            foreach ($dat as $i => $d) {
                $dat->$i = self::convert_from_latin1_to_utf8_recursively($d);
            }

            return $dat;
        } else {
            return $dat;
        }
    }
}
