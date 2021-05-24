<?php

namespace InnoSource\ADSTools;

use Illuminate\Support\Facades\DB;

class Migration
{
    public $database;

    public $tableName;

    public $type;

    public $columns;


    public function __construct($connectionName, $tableName, $type, $columns)
    {
        $this->database = Connection::find($connectionName);
        $this->tableName = $tableName;
        $this->type = $type;
        $this->columns = $columns;
    }

    public function generate()
    {
        switch ($this->type) {
            case 't1':
                $this->generateTier1Migration();
                break;

            default:
                # code...
                break;
        }
    }

    protected function generateTier1Migration()
    {
        file_put_contents($this->getMigrationFileName(), Compiler::compile(file_get_contents(__DIR__ . '/stubs/tier1_migration.stub'), [
            'TABLE_NAME' => $this->getGeneratedTableName(),
            'TABLE_NAME_STUDLY_CASE' => studly_case($this->getGeneratedTableName()),
            'FIELDS' => $this->getFormattedMigrationTier1Columns()
        ]));
    }

    protected function getMigrationFileName()
    {
        return base_path() . "/database/migrations/" . date('Y_m_d_his_') . 'create_' . $this->getGeneratedTableName() . '_table.php';
    }

    protected function getGeneratedTableName()
    {
        return $this->type . '_' . $this->database->name . '_' . $this->tableName;
    }

    protected function getFormattedMigrationTier1Columns()
    {
        $string = '';

        foreach ($this->columns as $column) {
            $string .= "\n\t\t\t\$table->string('" . $column['name'] . "'";

            if ($column['maxLength']) {
                $string .= ", " . $column['maxLength'] . ")->nullable();";
            } else {
                $string .= ")->nullable();";
            }
        }

        return $string;
    }
}
