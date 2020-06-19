<?php

namespace wanghanwanghan\someUtils\utils;

class arr
{
    public static function array_random($array,$number=null)
    {
        $requested=is_null($number) ? 1 : $number;

        $count=count($array);

        if ($requested > $count) return [];

        if (is_null($number)) return $array[array_rand($array)];

        if ((int)$number === 0) return [];

        $keys=array_rand($array,$number);

        $results=[];

        foreach ((array) $keys as $key)
        {
            $results[]=$array[$key];
        }

        return $results;
    }

    //修改一维或多维数组的键名，参数一：需要修改的数组，参数二：['从什么'=>'改成什么']
    public static function changeArrKey($arr,$example)
    {
        $res = [];

        foreach ($arr as $key => $value)
        {
            if (is_array($value))
            {
                if (array_key_exists($key,$example))
                {
                    $key = $example[$key];
                }

                $res[$key] = self::changeArrKey($value,$example);

            }else
            {
                if (array_key_exists($key,$example))
                {
                    $res[$example[$key]] = $value;

                }else
                {
                    $res[$key] = $value;
                }
            }
        }

        return $res;
    }


}
