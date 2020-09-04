<?php

namespace wanghanwanghan\someUtils\moudles\ioc;

use wanghanwanghan\someUtils\traits\Singleton;

class ioc
{
    use Singleton;

    private $container = [];

    public function lazyCreate(string $key, $obj, ...$arg)
    {
        $this->container[$key] = [
            'obj' => $obj,
            'params' => $arg,
        ];
    }

    function delete($key)
    {
        unset($this->container[$key]);
    }

    function clear()
    {
        $this->container = [];
    }

    function get(string $key)
    {
        if (isset($this->container[$key]))
        {
            $obj = $this->container[$key]['obj'];
            $params = $this->container[$key]['params'];

            if (is_object($obj) || is_callable($obj))
            {
                return $obj;

            }else if (is_string($obj) && class_exists($obj))
            {
                try
                {
                    $this->container[$key]['obj'] = new $obj(...$params);

                    return $this->container[$key]['obj'];

                }catch (\Throwable $throwable)
                {
                    throw $throwable;
                }
            }else
            {
                return $obj;
            }
        }else
        {
            return null;
        }
    }
}