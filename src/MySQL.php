<?php

namespace ResultData\ADSTools;

class MySQL extends Database
{
    public function formatTables($raw_table_data)
    {
        return collect($raw_table_data)->map(function ($t) {
            return new Table(
                    $t['TABLE_NAME'],
                    $t['TABLE_TYPE'] ?? 'BASE TABLE',
                    null,
                    $t['TABLE_ROWS'],
                    $this
                );
        });
    }

    public function formatColumns($raw_column_data)
    {
        return collect($raw_column_data)->map(function ($c) {
            return new Column(
                $c['COLUMN_NAME'],
                $c['COLUMN_TYPE'],
                $c['COLUMN_DEFAULT'],
                $c['IS_NULLABLE']
            );
        });
    }

    public function getTablesQuery()
    {
        return "SELECT * FROM information_schema.tables WHERE table_schema = '{$this->name}'";
    }

    public function getColumnsQuery(Table $table)
    {
        return "SELECT * FROM information_schema.columns WHERE table_name = '$table->name' AND table_schema = '{$this->name}'";
    }
}
