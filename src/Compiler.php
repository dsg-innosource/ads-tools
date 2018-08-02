<?php

namespace ResultData\ADSTools;

class Compiler
{
    public static function compile($template, $data, $withoutKeys = true)
    {
        foreach ($data as $key => $value) {
            if (!$withoutKeys) {
                $value = $value . '$' . $key . '$';
            }
            $template = preg_replace("/\\$$key\\$/i", $value, $template);
        }
        return $template;
    }
}
