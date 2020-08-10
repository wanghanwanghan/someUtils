<?php

namespace wanghanwanghan\someUtils\utils;

class idCard
{
    private $idCard;

    function __construct($idNum)
    {
        $this->idCard = $idNum;
    }

    function getInfo()
    {
        $info = [];

        //性别
        $info['sex'] = $this->getSex();

        //星座
        $info['constellation'] = $this->getConstellation();

        //生肖
        $info['animal'] = $this->get12Animals();

        //省份
        $info['province'] = $this->getProvince();

        return $info;
    }

    //返回性别
    private function getSex()
    {
        $num = substr($this->idCard, 16, 1);

        return $num % 2 === 0 ? '女' : '男';
    }

    //返回星座
    private function getConstellation()
    {
        $bir = substr($this->idCard, 10, 4);
        $month = substr($bir, 0, 2);
        $day = substr($bir, 2);

        $strValue = '';

        if (($month == 1 && $day <= 21) || ($month == 2 && $day <= 19)) {
            $strValue = '水瓶座';
        } else if (($month == 2 && $day > 20) || ($month == 3 && $day <= 20)) {
            $strValue = '双鱼座';
        } else if (($month == 3 && $day > 20) || ($month == 4 && $day <= 20)) {
            $strValue = '白羊座';
        } else if (($month == 4 && $day > 20) || ($month == 5 && $day <= 21)) {
            $strValue = '金牛座';
        } else if (($month == 5 && $day > 21) || ($month == 6 && $day <= 21)) {
            $strValue = '双子座';
        } else if (($month == 6 && $day > 21) || ($month == 7 && $day <= 22)) {
            $strValue = '巨蟹座';
        } else if (($month == 7 && $day > 22) || ($month == 8 && $day <= 23)) {
            $strValue = '狮子座';
        } else if (($month == 8 && $day > 23) || ($month == 9 && $day <= 23)) {
            $strValue = '处女座';
        } else if (($month == 9 && $day > 23) || ($month == 10 && $day <= 23)) {
            $strValue = '天秤座';
        } else if (($month == 10 && $day > 23) || ($month == 11 && $day <= 22)) {
            $strValue = '天蝎座';
        } else if (($month == 11 && $day > 22) || ($month == 12 && $day <= 21)) {
            $strValue = '射手座';
        } else if (($month == 12 && $day > 21) || ($month == 1 && $day <= 20)) {
            $strValue = '魔羯座';
        }

        return $strValue;
    }

    //返回生肖
    private function get12Animals()
    {
        $start = 1901;
        $end = $end = substr($this->idCard, 6, 4);
        $x = ($start - $end) % 12;
        $value = '';

        if ($x == 1 || $x == -11) {
            $value = '鼠';
        }
        if ($x == 0) {
            $value = '牛';
        }
        if ($x == 11 || $x == -1) {
            $value = '虎';
        }
        if ($x == 10 || $x == -2) {
            $value = '兔';
        }
        if ($x == 9 || $x == -3) {
            $value = '龙';
        }
        if ($x == 8 || $x == -4) {
            $value = '蛇';
        }
        if ($x == 7 || $x == -5) {
            $value = '马';
        }
        if ($x == 6 || $x == -6) {
            $value = '羊';
        }
        if ($x == 5 || $x == -7) {
            $value = '猴';
        }
        if ($x == 4 || $x == -8) {
            $value = '鸡';
        }
        if ($x == 3 || $x == -9) {
            $value = '狗';
        }
        if ($x == 2 || $x == -10) {
            $value = '猪';
        }

        return $value;
    }

    //返回省份
    private function getProvince()
    {
        $index = substr($this->idCard, 0, 2);

        $area = [
            11 => '北京', 12 => '天津', 13 => '河北', 14 => '山西', 15 => '内蒙古', 21 => '辽宁',
            22 => '吉林', 23 => '黑龙江', 31 => '上海', 32 => '江苏', 33 => '浙江', 34 => '安徽',
            35 => '福建', 36 => '江西', 37 => '山东', 41 => '河南', 42 => '湖北', 43 => '湖南',
            44 => '广东', 45 => '广西', 46 => '海南', 50 => '重庆', 51 => '四川', 52 => '贵州',
            53 => '云南', 54 => '西藏', 61 => '陕西', 62 => '甘肃', 63 => '青海', 64 => '宁夏',
            65 => '新疆', 71 => '台湾', 81 => '香港', 82 => '澳门', 91 => '国外'
        ];

        return $area[$index];
    }

}
