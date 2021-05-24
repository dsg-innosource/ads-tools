<?php

namespace InnoSource\ADSTools\Http\Controllers;

use InnoSource\ADSTools\Connection;

class ResourcePreviewController extends Controller
{
    public function show($connectionName)
    {
        return Connection::find($connectionName)->getPreviewFromTable(request('name'));
    }
}
