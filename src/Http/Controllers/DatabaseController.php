<?php

namespace ResultData\ADSTools\Http\Controllers;

use ResultData\ADSTools\Connection;

class DatabaseController extends Controller
{
    public function show($connectionName)
    {
        return Connection::find($connectionName);
    }
}
