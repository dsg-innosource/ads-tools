<?php

namespace ResultData\ADSTools\Http\Controllers;

use Illuminate\Support\Facades\DB;
use ResultData\ADSTools\Connection;

class ResourcePreviewController extends Controller
{
    public function show($connectionName)
    {
        return DB::connection($connectionName)->table(request('name'))->limit(5)->get();
    }
}
