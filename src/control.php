<?php

namespace wanghanwanghan\someUtils;

use wanghanwanghan\someUtils\utils\createUuid;

class control
{
    /*
     * 控制要调用的哪个工具
     */

    private function __construct(){}
    private function __clone(){}

    public static function getUuid($limit=32)
    {
        return createUuid::getUuid($limit);
    }





}
