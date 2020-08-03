<?php

namespace wanghanwanghan\someUtils\utils;

class num
{
    //产生随机数
    public static function randNum($length = 3)
    {
        mt_srand();

        $min = 1;
        $max = 9;

        if ($length >= 18) $length = 18;

        for ($i = $length - 1; $i--;)
        {
            $min .= 0;
            $max .= 9;
        }

        return mt_rand($min, $max);
    }








}
