<?php

namespace wanghanwanghan\someUtils\moudles\laravelDB;

use Illuminate\Database\Capsule\Manager;
use Illuminate\Database\Connection;

class laravelDB
{
    private static $instance;

    private function __construct(...$args)
    {
        $capsule = new Manager();

        foreach ($args[0] as $name => $conn_info) {
            $capsule->addConnection($conn_info, $name);
        }

        $capsule->setAsGlobal();
        $capsule->bootEloquent();
    }

    static function getInstance(...$args): laravelDB
    {
        if (!isset(self::$instance)) {
            self::$instance = new static(...$args);
        }

        return self::$instance;
    }

    function connection(string $name): Connection
    {
        return Manager::connection($name);
    }
}
