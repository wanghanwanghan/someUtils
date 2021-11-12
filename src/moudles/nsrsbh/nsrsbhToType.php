<?php

namespace wanghanwanghan\someUtils\moudles\nsrsbh;

use wanghanwanghan\someUtils\control;
use wanghanwanghan\someUtils\traits\Singleton;

class nsrsbhToType
{
    //http://www.scmiyi.gov.cn/zwgk/zzjg/xjbm/tjj/tjzs/1887316.shtml
    //第1位 登记管理部门代码
    //第2位 机构类别代码
    //第3-8位 登记管理机关行政区划码
    //第9-17位 组织机构代码
    //第18位 校验码

    use Singleton;

    private $code_table = [
        ['id' => 1, 'pid' => 0, 'code' => '1', 'name' => '机构编制'],
        ['id' => 2, 'pid' => 0, 'code' => '2', 'name' => '外交'],
        ['id' => 3, 'pid' => 0, 'code' => '3', 'name' => '司法行政'],
        ['id' => 4, 'pid' => 0, 'code' => '4', 'name' => '文化'],
        ['id' => 5, 'pid' => 0, 'code' => '5', 'name' => '民政'],
        ['id' => 6, 'pid' => 0, 'code' => '6', 'name' => '旅游'],
        ['id' => 7, 'pid' => 0, 'code' => '7', 'name' => '宗教'],
        ['id' => 8, 'pid' => 0, 'code' => '8', 'name' => '工会'],
        ['id' => 9, 'pid' => 0, 'code' => '9', 'name' => '工商'],
        ['id' => 10, 'pid' => 0, 'code' => 'A', 'name' => '中央军委改革和编制办公室'],
        ['id' => 11, 'pid' => 0, 'code' => 'N', 'name' => '农业'],
        ['id' => 12, 'pid' => 0, 'code' => 'Y', 'name' => '其他'],

        ['id' => 13, 'pid' => 1, 'code' => '1', 'name' => '机关'],
        ['id' => 14, 'pid' => 1, 'code' => '2', 'name' => '事业单位'],
        ['id' => 15, 'pid' => 1, 'code' => '3', 'name' => '中央编办直接管理机构编制的群众团体'],
        ['id' => 16, 'pid' => 1, 'code' => '9', 'name' => '其他'],

        ['id' => 17, 'pid' => 2, 'code' => '1', 'name' => '外国常住新闻机构'],
        ['id' => 18, 'pid' => 2, 'code' => '9', 'name' => '其他'],

        ['id' => 19, 'pid' => 3, 'code' => '1', 'name' => '律师执业机构'],
        ['id' => 20, 'pid' => 3, 'code' => '2', 'name' => '公证处'],
        ['id' => 21, 'pid' => 3, 'code' => '3', 'name' => '基层法律服务所'],
        ['id' => 22, 'pid' => 3, 'code' => '4', 'name' => '司法鉴定机构'],
        ['id' => 23, 'pid' => 3, 'code' => '5', 'name' => '仲裁委员会'],
        ['id' => 24, 'pid' => 3, 'code' => '9', 'name' => '其他'],

        ['id' => 25, 'pid' => 4, 'code' => '1', 'name' => '外国在华文化中心'],
        ['id' => 26, 'pid' => 4, 'code' => '9', 'name' => '其他'],

        ['id' => 27, 'pid' => 5, 'code' => '1', 'name' => '社会团体'],
        ['id' => 28, 'pid' => 5, 'code' => '2', 'name' => '民办非企业单位'],
        ['id' => 29, 'pid' => 5, 'code' => '3', 'name' => '基金会'],
        ['id' => 30, 'pid' => 5, 'code' => '9', 'name' => '其他'],

        ['id' => 31, 'pid' => 6, 'code' => '1', 'name' => '外国旅游部门常驻代表机构'],
        ['id' => 32, 'pid' => 6, 'code' => '2', 'name' => '港澳台地区旅游部门常驻内地（大陆）代表机构'],
        ['id' => 33, 'pid' => 6, 'code' => '9', 'name' => '其他'],

        ['id' => 34, 'pid' => 7, 'code' => '1', 'name' => '宗教活动场所'],
        ['id' => 35, 'pid' => 7, 'code' => '2', 'name' => '宗教院校'],
        ['id' => 36, 'pid' => 7, 'code' => '9', 'name' => '其他'],

        ['id' => 37, 'pid' => 8, 'code' => '1', 'name' => '基层工会'],
        ['id' => 38, 'pid' => 8, 'code' => '9', 'name' => '其他'],

        ['id' => 39, 'pid' => 9, 'code' => '1', 'name' => '企业'],
        ['id' => 40, 'pid' => 9, 'code' => '2', 'name' => '个体工商户'],
        ['id' => 41, 'pid' => 9, 'code' => '3', 'name' => '农民专业合作社'],

        ['id' => 42, 'pid' => 10, 'code' => '1', 'name' => '军队事业单位'],
        ['id' => 43, 'pid' => 10, 'code' => '9', 'name' => '其他'],

        ['id' => 44, 'pid' => 11, 'code' => '1', 'name' => '组级集体经济组织'],
        ['id' => 45, 'pid' => 11, 'code' => '2', 'name' => '村级集体经济组织'],
        ['id' => 46, 'pid' => 11, 'code' => '3', 'name' => '乡镇级集体经济组织'],
        ['id' => 47, 'pid' => 11, 'code' => '9', 'name' => '其他'],

        ['id' => 48, 'pid' => 12, 'code' => '1', 'name' => '不再具体划分机构类别（统一用1表示）'],

        ['id' => 49, 'pid' => 0, 'code' => 'G', 'name' => '境外非政府组织代表机构'],
        ['id' => 50, 'pid' => 0, 'code' => 'J', 'name' => '业主委员会'],
        ['id' => 51, 'pid' => 0, 'code' => 'M', 'name' => '民办非企业单位'],
        ['id' => 52, 'pid' => 0, 'code' => 'Q', 'name' => '基层侨联'],
        ['id' => 53, 'pid' => 0, 'code' => 'S', 'name' => '司法鉴定机构'],
    ];

    private $nsrsbh;

    function setNsrsbh(string $nsrsbh): nsrsbhToType
    {
        $this->nsrsbh = trim($nsrsbh);
        return $this;
    }

    function getType(): string
    {
        $nsrsbh = $this->nsrsbh;

        $result = [];
        control::traverseMenuNew($this->code_table, $result, 0, [
            'save_field' => ['code', 'name']
        ]);

        //获取机构类型
        $type = '';

        foreach ($result as $place1) {
            if ($place1['code'] === $nsrsbh[0]) {
                $type = $place1['name'] . '-';
                foreach ($place1['children'] as $place2) {
                    if ($place2['code'] === $nsrsbh[1]) {
                        $type .= $place2['name'];
                        break 2;
                    }
                }
            }
        }

        return $type;
    }


}