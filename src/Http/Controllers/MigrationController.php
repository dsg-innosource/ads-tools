<?php

namespace ResultData\ADSTools\Http\Controllers;

use ResultData\ADSTools\Connection;
use ResultData\ADSTools\Migration;

class MigrationController extends Controller
{
    public function store($connectionName, $tableName)
    {
        $migration = new Migration($connectionName, $tableName, request()->type, request()->columns);

        return $migration->generate();
    }
}
