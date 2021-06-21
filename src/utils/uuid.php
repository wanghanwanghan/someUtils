<?php

namespace wanghanwanghan\someUtils\utils;

class uuid
{
    //随机字符串uuid
    static function getUuid($limit = 32)
    {
        mt_srand();
        return $limit >= 32 ?
            md5(uniqid(microtime(true), true)) :
            substr(md5(uniqid(microtime(true), true)), 0, $limit);
    }







}
