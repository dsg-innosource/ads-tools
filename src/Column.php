<?php

namespace ResultData\ADSTools;

use Illuminate\Support\Facades\DB;

class Column
{
    public $name;

    public $type;

    public $default;

    public $nullable;

    public function __construct($name, $type, $default, $nullable)
    {
        $this->name = $name;
        $this->type = $type;
        $this->default = $default;
        $this->nullable = $nullable;
    }
}
