<?php

namespace ResultData\ADSTools;

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

    public function __toString()
    {
        return json_encode($this->toArray());
    }

    public function toArray()
    {
        return [
            'name' => $this->name,
            'type' => $this->type,
            'default' => $this->default,
            'nullable' => $this->nullable,
        ];
    }
}
