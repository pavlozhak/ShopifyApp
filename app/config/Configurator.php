<?php
namespace config\Configurator;

class Configurator
{
    private static $databaseConfig = array(
        'host' => 'stdev.mysql.tools',
        'user' => 'stdev_shopify',
        'pass' => 'psm2z6cx',
        'dbname' => 'stdev_shopify',
        'charset' => 'utf8'
    );

    public static function getDatabaseConfigParams()
    {
        return self::$databaseConfig;
    }
}