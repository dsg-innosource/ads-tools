<?php

namespace InnoSource\ADSTools\Http\Controllers;

use InnoSource\ADSTools\Connection;
use InnoSource\ADSTools\Migration;

class MigrationController extends Controller
{
    public function store($connectionName, $tableName)
    {
        $migration = new Migration($connectionName, $tableName, request()->type, request()->columns);

        return $migration->generate();
    }
}
