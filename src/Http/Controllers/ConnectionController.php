<?php

namespace ResultData\ADSTools\Http\Controllers;

use ResultData\ADSTools\Connection;
use Illuminate\Support\Facades\View;

class ConnectionController extends Controller
{
    public function index()
    {
        $connections = Connection::all();

        return View::make('ads-tools::index')
            ->with('connections', $connections);
    }

    public function show($connectionName)
    {
        $resource = Connection::find($connectionName)->toArray();

        return View::make('ads-tools::connections.show')
            ->with('resource', $resource);
    }
}
