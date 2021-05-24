<?php

namespace InnoSource\ADSTools\Http\Controllers;

use InnoSource\ADSTools\Connection;

class DatabaseController extends Controller
{
    public function show($connectionName)
    {
        return Connection::find($connectionName);
    }
}
