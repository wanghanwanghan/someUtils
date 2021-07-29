<?php

namespace wanghanwanghan\someUtils\utils;

class num
{
    static $alphabet = [
        'A', 'a', 'B', 'b', 'C', 'c', 'D', 'd', 'E', 'e',
        'F', 'f', 'G', 'g', 'H', 'h', 'I', 'i', 'J', 'j',
        'K', 'k', 'L', 'l', 'M', 'm', 'N', 'n', 'O', 'o',
        'P', 'p', 'Q', 'q', 'R', 'r', 'S', 's', 'T', 't',
        'U', 'u', 'V', 'v', 'W', 'w', 'X', 'x', 'Y', 'y',
        'Z', 'z', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9'
    ];

    //产生随机数
    static function randNum($length = 3)
    {
        mt_srand();

        $min = 1;
        $max = 9;

        if ($length >= 18) $length = 18;

        for ($i = $length - 1; $i--;) {
            $min .= 0;
            $max .= 9;
        }

        return mt_rand($min, $max);
    }

    //阿拉伯数字金额转大写金额
    static function toChineseNumber($num)
    {
        $c1 = '零壹贰叁肆伍陆柒捌玖';
        $c2 = '分角元拾佰仟万拾佰仟亿';
        $num = round($num, 2);
        $num = $num * 100;
        if (strlen($num) > 10) {
            return '数据太长，没有这么大的钱吧，检查下';
        }
        $i = 0;
        $c = '';
        while (1) {
            if ($i == 0) {
                $n = substr($num, strlen($num) - 1, 1);
            } else {
                $n = $num % 10;
            }
            $p1 = substr($c1, 3 * $n, 3);
            $p2 = substr($c2, 3 * $i, 3);
            if ($n != '0' || ($n == '0' && ($p2 == '亿' || $p2 == '万' || $p2 == '元'))) {
                $c = $p1 . $p2 . $c;
            } else {
                $c = $p1 . $c;
            }
            $i = $i + 1;
            $num = $num / 10;
            $num = (int)$num;
            if ($num == 0) {
                break;
            }
        }
        $j = 0;
        $slen = strlen($c);
        while ($j < $slen) {
            $m = substr($c, $j, 6);
            if ($m == '零元' || $m == '零万' || $m == '零亿' || $m == '零零') {
                $left = substr($c, 0, $j);
                $right = substr($c, $j + 3);
                $c = $left . $right;
                $j = $j - 3;
                $slen = $slen - 3;
            }
            $j = $j + 3;
        }

        if (substr($c, strlen($c) - 3, 3) == '零') {
            $c = substr($c, 0, strlen($c) - 3);
        }
        if (empty($c)) {
            return '零元整';
        } else {
            return $c . "整";
        }
    }

    //数字转字符串 用于隐藏id
    static function numToStringForId($num): ?string
    {
        if ($num > PHP_INT_MAX || $num < 0) return null;
        $max = count(self::$alphabet) - 1;
        $str = '';

        if ($num <= $max) {
            return self::$alphabet[$num];
        } else if ($num > $max) {
            $tmp1 = $num + 1;
            while ($tmp1 > 0) {
                $tmp2 = ($tmp1 - 1) % ($max + 1);
                if ($tmp2 < 0) {
                    $tmp2 = $tmp2 + ($max + 1);
                }
                $str = self::$alphabet[$tmp2] . $str;
                $tmp1 = floor((($tmp1 - $tmp2) / ($max + 1)));
            }
        }

        return $str;
    }

    //字符串转数字 用于解密id
    static function stringToNumForId($str): int
    {
        $arr = array_flip(self::$alphabet);
        $max = count(self::$alphabet);
        $num = -1;

        $len = strlen($str);

        for ($i = 0; $i < $len; $i++) {
            $num += ($arr[$str[$i]] + 1) * pow($max, ($len - $i - 1));
        }

        return $num;
    }

    //luhn 算法
    static function luhn($card): bool
    {
        $len = strlen($card);
        $all = [];
        $sum_odd = 0;
        $sum_even = 0;
        for ($i = 0; $i < $len; $i++) {
            $all[] = substr($card, $len - $i - 1, 1);
        }
        //all 里的偶数key都是我们要相加的奇数位
        for ($k = 0; $k < $len; $k++) {
            if ($k % 2 == 0) {
                $sum_odd += $all[$k];
            } else {
                //奇数key都是要相加的偶数和
                if ($all[$k] * 2 >= 10) {
                    $sum_even += $all[$k] * 2 - 9;
                } else {
                    $sum_even += $all[$k] * 2;
                }
            }
        }
        $total = $sum_odd + $sum_even;
        return !!($total % 10 === 0);
    }
}
