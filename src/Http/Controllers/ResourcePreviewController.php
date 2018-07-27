<?php

namespace ResultData\ADSTools\Http\Controllers;

use ResultData\ADSTools\Connection;

class ResourcePreviewController extends Controller
{
    public function show($connectionName)
    {
        return Connection::find($connectionName)->getPreviewFromTable(request('name'));
    }
}
