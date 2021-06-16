<?php

namespace wanghanwanghan\someUtils\utils;

class str
{
    //比较两个字符串是否完全相等
    static function comparingTwoStrings($str1, $str2, $length = 'all')
    {
        if ($length === 'all') {
            $length1 = mb_strlen($str1);
            $length2 = mb_strlen($str2);

            $length = $length1 > $length2 ? $length1 : $length2;
        }

        //等于0 - 两个字符串相等
        //小于0 - str1 长度小于 str2
        //大于0 - str1 长度大于 str2
        return strncasecmp($str1, $str2, $length);
    }

    //实现中文字串截取无乱码的方法
    static function substrChinese($string, $start = 0, $length = 1)
    {
        return join('', array_slice(preg_split("//u", $string, -1, PREG_SPLIT_NO_EMPTY), $start, $length));
    }

    //实现中文字串反转
    static function strrevChinese($string)
    {
        return join('', array_reverse(preg_split("//u", $string)));
    }

    //只含有26个字母或者数字的并且都是半角的字符串，转换成数字，用于hash分表
    static function string2Number($str)
    {
        $j = 0;

        for ($i = 0; $i < strlen($str); $i++) {
            if (is_numeric($str[$i])) {
                $j += $str[$i];
            } else {
                $j += ord($str[$i]);
            }
        }

        return $j;
    }

    //为字符串的指定位置添加指定字符
    static function insertSomething($str, $offset, $delimiter = '-')
    {
        foreach ($offset as $i => $v) {
            $str = self::mbSubstrReplace($str, $delimiter, $i + $v, 0);
        }

        return $str;
    }

    private static function mbSubstrReplace($string, $replacement, $start, $length = null)
    {
        if (is_array($string)) {
            $num = count($string);
            // $replacement
            $replacement = is_array($replacement) ? array_slice($replacement, 0, $num) : array_pad(array($replacement), $num, $replacement);
            // $start
            if (is_array($start)) {
                $start = array_slice($start, 0, $num);
                foreach ($start as $key => $value) $start[$key] = is_int($value) ? $value : 0;
            } else {
                $start = array_pad(array($start), $num, $start);
            }
            // $length
            if (!isset($length)) {
                $length = array_fill(0, $num, 0);
            } elseif (is_array($length)) {
                $length = array_slice($length, 0, $num);
                foreach ($length as $key => $value) $length[$key] = isset($value) ? (is_int($value) ? $value : $num) : 0;
            } else {
                $length = array_pad(array($length), $num, $length);
            }
            // Recursive call
            return array_map(__FUNCTION__, $string, $replacement, $start, $length);
        }
        preg_match_all('/./us', (string)$string, $smatches);
        preg_match_all('/./us', (string)$replacement, $rmatches);
        if ($length === NULL) $length = mb_strlen($string);
        array_splice($smatches[0], $start, $length, $rmatches[0]);
        return join($smatches[0]);
    }

    //中文字符串包含 source源字符串target要判断的是否包含的字符串
    static function hasString($source, $target)
    {
        preg_match_all("/$target/sim", $source, $strResult, PREG_PATTERN_ORDER);

        return !empty(current($strResult));
    }

    //向前匹配
    static function hasStringFront($source, $target1, $target2)
    {
        preg_match_all("/{$target1}(.*)(?={$target2})/sim", $source, $strResult, PREG_PATTERN_ORDER);

        return !empty(current($strResult));
    }

    //aes加密
    static function aesEncode($str, $salt = __CLASS__, $method = 128)
    {
        $method === 128 ? $method = 'AES-128-ECB' : $method = 'AES-256-ECB';

        return bin2hex(openssl_encrypt($str, $method, $salt, OPENSSL_RAW_DATA));
    }

    //aes解密
    static function aesDecode($str, $salt = __CLASS__, $method = 128)
    {
        $method === 128 ? $method = 'AES-128-ECB' : $method = 'AES-256-ECB';

        return openssl_decrypt(pack("H*", $str), $method, $salt, OPENSSL_RAW_DATA);
    }

    static function rsaEncrypt(string $str = '', string $key = '', string $use = 'pub', string $mark = '_'): ?string
    {
        strtolower($use) === 'pub' ? $key = openssl_pkey_get_public($key) : $key = openssl_pkey_get_private($key);

        if ($key === false) return null;

        if (strlen($str) > 117) {
            $res = '';
            foreach (str_split($str, 117) as $chunk) {
                strtolower($use) === 'pub' ?
                    $en_info = openssl_public_encrypt($chunk, $en, $key) :
                    $en_info = openssl_private_encrypt($chunk, $en, $key);
                if ($en_info === false) return null;
                $res .= base64_encode($en) . $mark;
            }
        } else {
            strtolower($use) === 'pub' ?
                $en_info = openssl_public_encrypt($str, $en, $key) :
                $en_info = openssl_private_encrypt($str, $en, $key);
            if ($en_info === false) return null;
            $res = base64_encode($en);
        }

        return trim($res, $mark);
    }

    static function rsaDecrypt(string $str = '', string $key = '', string $use = 'pri', string $mark = '_'): ?string
    {
        strtolower($use) === 'pub' ? $key = openssl_pkey_get_public($key) : $key = openssl_pkey_get_private($key);

        if ($key === false) return null;

        if (strpos($str, $mark) !== false) {
            $res = '';
            foreach (explode($mark, $str) as $chunk) {
                $chunk = base64_decode($chunk);
                strtolower($use) === 'pub' ?
                    $de_info = openssl_public_decrypt($chunk, $de, $key) :
                    $de_info = openssl_private_decrypt($chunk, $de, $key);
                if ($de_info === false) return null;
                $res .= $de;
            }
        } else {
            $str = base64_decode($str);
            strtolower($use) === 'pub' ?
                $de_info = openssl_public_decrypt($str, $res, $key) :
                $de_info = openssl_private_decrypt($str, $res, $key);
            if ($de_info === false) return null;
        }

        return $res;
    }

    //字符串转utf8
    static function str2Utf8($str, $addType = [])
    {
        $type = ['ASCII', 'UTF-8', 'GB2312', 'GBK', 'BIG5'];

        if (!empty($addType)) {
            foreach ($addType as $one) {
                array_push($type, $one);
            }
        }

        $type = mb_detect_encoding($str, $type);

        if ($type == 'UTF-8') {
            return $str;
        } else {
            return mb_convert_encoding($str, 'UTF-8', $type);
        }
    }


}
