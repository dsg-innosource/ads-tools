<?php

namespace ResultData\ADSTools;

class Column
{
    public $name;

    public $type;

    public $default;

    public $nullable;

    public $maxLength;

    public function __construct($name, $type, $default, $nullable, $maxLength)
    {
        $this->name = $name;
        $this->type = $type;
        $this->default = $default;
        $this->nullable = $nullable;
        $this->maxLength = $maxLength;
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
            'maxLength' => $this->maxLength,
        ];
    }
}
