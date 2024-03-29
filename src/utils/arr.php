<?php

namespace wanghanwanghan\someUtils\utils;

class arr
{
    //laravel的
    static function array_random($array, $number = null)
    {
        mt_srand();

        $requested = is_null($number) ? 1 : $number;

        $count = count($array);

        if ($requested > $count) return [];

        if (is_null($number)) return $array[array_rand($array)];

        if ((int)$number === 0) return [];

        $keys = array_rand($array, $number);

        $results = [];

        foreach ((array)$keys as $key) {
            $results[] = $array[$key];
        }

        return $results;
    }

    //修改一维或多维数组的键名，参数一：需要修改的数组，参数二：['从什么'=>'改成什么']
    static function changeArrKey($arr, $example)
    {
        $res = [];

        foreach ($arr as $key => $value) {
            if (is_array($value)) {
                if (array_key_exists($key, $example)) {
                    $key = $example[$key];
                }
                $res[$key] = self::changeArrKey($value, $example);
            } else {
                if (array_key_exists($key, $example)) {
                    $res[$example[$key]] = $value;
                } else {
                    $res[$key] = $value;
                }
            }
        }

        return $res;
    }

    //递归处理数组数据，参数一：需要修改的数组，参数二：[从什么]，参数三：变成什么
    static function changeArrVal($arr, $saki = ['', null], $moto = '-', $useTrim = true)
    {
        if (!is_array($arr)) return $arr;

        foreach ($arr as $key => $value) {
            if (is_array($value)) {
                $arr[$key] = self::changeArrVal($value, $saki, $moto, $useTrim);
            } else {
                if (is_string($value)) {
                    $tmp = [];
                    foreach ($saki as $val) {
                        !is_string($val) ?: array_push($tmp, $val);
                    }
                    empty($tmp) ?: $arr[$key] = str_replace($tmp, $moto, $useTrim ? trim($value) : $value);
                }
                if (in_array($value, $saki, true)) $arr[$key] = $moto;
            }
        }

        return $arr;
    }

    //删除一维或多维数组的元素
    static function removeArrKey($arr, $example = ['created_at', 'updated_at'])
    {
        $res = [];

        foreach ($arr as $key => $value) {
            if (in_array($key, $example)) continue;
            if (is_array($value)) {
                $res[$key] = self::removeArrKey($value, $example);
            } else {
                $res[$key] = $value;
            }
        }

        return $res;
    }

    //二维数组按照某key排序
    static function sortArrByKey($array, $key = 'id', $rule = 'desc')
    {
        strtolower($rule) === 'asc' ? $rule = 'SORT_ASC' : $rule = 'SORT_DESC';

        $arrSort = [];

        foreach ($array as $unique => $row) {
            foreach ($row as $key => $value) {
                $arrSort[$key][$unique] = $value;
            }
        }

        array_multisort($arrSort[$key], constant($rule), $array);

        return $array;
    }

    //二维数组按照某key排序
    static function sortArrByKeyNew($array, $key = 'id', $rule = 'desc')
    {
        strtolower($rule) === 'asc' ? $rule = 'SORT_ASC' : $rule = 'SORT_DESC';

        $array_column = array_column($array, $key);
        array_multisort($array_column, constant($rule), $array);

        return $array;
    }

    //快速排序
    static function quickSort($array)
    {
        if (count($array) <= 1) return $array;

        $key = current($array);

        $left_arr = $right_arr = [];

        for ($i = 1; $i < count($array); $i++) {
            if ($array[$i] <= $key) {
                $left_arr[] = $array[$i];
            } else {
                $right_arr[] = $array[$i];
            }
        }

        $left_arr = self::quickSort($left_arr);
        $right_arr = self::quickSort($right_arr);

        return array_merge($left_arr, [$key], $right_arr);
    }

    //冒泡排序
    static function bubbleSort($array)
    {
        for ($i = 0; $i < count($array); $i++) {
            for ($j = $i + 1; $j < count($array); $j++) {
                if ($array[$i] > $array[$j]) {
                    list($array[$i], $array[$j]) = [$array[$j], $array[$i]];
                }
            }
        }

        return $array;
    }

    //替代range函数，因为太占内存
    static function xRange($start, $stop, $step)
    {
        //需要用foreach迭代
        //$res=xRange(1,20);
        //foreach ($res as $num)
        //{
        //    echo $num.PHP_EOL;
        //}

        for ($i = $start; $i <= $stop; $i += $step) {
            yield $i;
        }
    }

    //多维数组变一维
    static function array_flatten($array, $depth = INF)
    {
        if (!is_array($array)) return null;

        $result = [];

        foreach ($array as $item) {
            if (!is_array($item)) {
                $result[] = $item;
            } elseif ($depth === 1) {
                $result = array_merge($result, array_values($item));
            } else {
                $result = array_merge($result, static::array_flatten($item, $depth - 1));
            }
        }

        return $result;
    }

    //laravel head
    static function head($arr)
    {
        return reset($arr);
    }

    //laravel last
    static function last($arr)
    {
        return end($arr);
    }

    //二分查找
    static function binarySearch($find, $arr, $startIndex, $indexTotal)
    {
        $middleKey = ($startIndex + $indexTotal) / 2;

        if ($middleKey <= $startIndex || $middleKey >= $indexTotal) {
            return null;
        }

        if ($find === $arr[$middleKey]) {
            return $arr[$middleKey];
        }

        if ($find > $arr[$middleKey]) {
            return arr::binarySearch($find, $arr, $middleKey, $indexTotal);
        } else {
            return arr::binarySearch($find, $arr, $startIndex, $middleKey);
        }
    }


}
