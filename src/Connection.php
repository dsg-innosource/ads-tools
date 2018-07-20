<?php

namespace ResultData\ADSTools;

class Connection
{
    public static $connections;

    private static function getConnections()
    {
        return collect(config('database.connections'))->map(function ($conn, $name) {
            return array_merge($conn, ['name' => $name]);
        })->values();
    }

    public static function all()
    {
        return collect(self::getConnections());
    }

    public static function find($name)
    {
        $connection = self::getConnections()->filter(function ($c) use ($name) {
            return $c['name'] == $name;
        })->first();
        return new Database($connection);
    }
}
