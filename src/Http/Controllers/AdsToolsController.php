<?php

namespace ResultData\ADSTools\Http\Controllers;

use Illuminate\Support\Facades\View;
use ResultData\ADSTools\Connection;

class AdsToolsController extends Controller
{
    public function index()
    {
        $connections = (new Connection)->getAll();

        // dd($connections);
        return View::make('ads-tools::index')
                ->with('connections', $connections);
    }
}
