<?php

namespace ResultData\ADSTools\Http\Controllers;

use Illuminate\Support\Facades\View;
use ResultData\ADSTools\Connection;

class ConnectionController extends Controller
{
    public function index($connectionName)
    {
        $connection = new Connection();

        $connection->connect($connectionName);

        return View::make('ads-tools::connections.show')
            ->with('connection', $connection);
    }
}
