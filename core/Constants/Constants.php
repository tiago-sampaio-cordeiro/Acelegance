<?php

namespace Core\Constants;

class Constants
{
    public static function rootPath()
    {
        return new StringPath(dirname(dirname(__DIR__)));
    }

    public static function databasePath()
    {
        return self::rootPath()->join('/database');
    }
}
