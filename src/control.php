<?php

namespace wanghanwanghan\someUtils;

use wanghanwanghan\someUtils\utils\file;
use wanghanwanghan\someUtils\utils\idCard;
use wanghanwanghan\someUtils\utils\img;
use wanghanwanghan\someUtils\utils\num;
use wanghanwanghan\someUtils\utils\str;
use wanghanwanghan\someUtils\utils\uuid;
use wanghanwanghan\someUtils\utils\arr;

class control
{
    /*
     * 控制要调用的哪个工具
     */

    private function __construct()
    {
    }

    private function __clone()
    {
    }

    static function install()
    {
        return 'hello world';
    }

    //uuid
    static function getUuid($limit = 32)
    {
        return uuid::getUuid($limit);
    }

    //是否移动端
    static function isMobile()
    {
        // 如果有HTTP_X_WAP_PROFILE则一定是移动设备
        if (isset($_SERVER['HTTP_X_WAP_PROFILE'])) return true;

        // 如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
        // 找不到为flase,否则为TRUE
        if (isset($_SERVER['HTTP_VIA'])) return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;

        // 判断手机发送的客户端标志,兼容性有待提高
        if (isset($_SERVER['HTTP_USER_AGENT'])) {
            $clientkeywords = [
                'mobile',
                'nokia',
                'sony',
                'ericsson',
                'mot',
                'samsung',
                'htc',
                'sgh',
                'lg',
                'sharp',
                'sie-',
                'philips',
                'panasonic',
                'alcatel',
                'lenovo',
                'iphone',
                'ipod',
                'blackberry',
                'meizu',
                'android',
                'netfront',
                'symbian',
                'ucweb',
                'windowsce',
                'palm',
                'operamini',
                'operamobi',
                'openwave',
                'nexusone',
                'cldc',
                'midp',
                'wap',
            ];

            // 从HTTP_USER_AGENT中查找手机浏览器的关键字
            if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT']))) return true;
        }

        // 协议法，因为有可能不准确，放到最后判断
        if (isset($_SERVER['HTTP_ACCEPT'])) {
            // 如果只支持wml并且不支持html那一定是移动设备
            // 如果支持wml和html但是wml在html之前则是移动设备
            if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html')))) {
                return true;
            }
        }

        return false;
    }

    //比较两个字符串是否完全相等
    //等于0 - 两个字符串相等
    //小于0 - str1 长度小于 str2
    //大于0 - str1 长度大于 str2
    static function comparingTwoStrings($str1, $str2, $length = 'all')
    {
        return str::comparingTwoStrings($str1, $str2, $length);
    }

    //截取中文字符串
    static function substrChinese($string, $start = 0, $length = 1)
    {
        return str::substrChinese($string, $start, $length);
    }

    //反转中文字符串
    static function strrevChinese($str)
    {
        return str::strrevChinese($str);
    }

    //随机产生用户名
    static function randomUserName()
    {
        if (time() % 2) {
            $firstName = ['赵', '钱', '孙', '李', '周', '吴', '郑', '王', '冯', '陈', '褚', '卫', '蒋', '沈', '韩', '杨', '朱', '秦', '尤', '许', '何', '吕', '施', '张', '孔', '曹', '严', '华', '金', '魏', '陶', '姜', '戚', '谢', '邹',
                '喻', '柏', '水', '窦', '章', '云', '苏', '潘', '葛', '奚', '范', '彭', '郎', '鲁', '韦', '昌', '马', '苗', '凤', '花', '方', '任', '袁', '柳', '鲍', '史', '唐', '费', '薛', '雷', '贺', '倪', '汤', '滕', '殷', '罗',
                '毕', '郝', '安', '常', '傅', '卞', '齐', '元', '顾', '孟', '平', '黄', '穆', '萧', '尹', '姚', '邵', '湛', '汪', '祁', '毛', '狄', '米', '伏', '成', '戴', '谈', '宋', '茅', '庞', '熊', '纪', '舒', '屈', '项', '祝',
                '董', '梁', '杜', '阮', '蓝', '闵', '季', '贾', '路', '娄', '江', '童', '颜', '郭', '梅', '盛', '林', '钟', '徐', '邱', '骆', '高', '夏', '蔡', '田', '樊', '胡', '凌', '霍', '虞', '万', '支', '柯', '管', '卢', '莫',
                '柯', '房', '裘', '缪', '解', '应', '宗', '丁', '宣', '邓', '单', '杭', '洪', '包', '诸', '左', '石', '崔', '吉', '龚', '程', '嵇', '邢', '裴', '陆', '荣', '翁', '荀', '于', '惠', '甄', '曲', '封', '储', '仲', '伊',
                '宁', '仇', '甘', '武', '符', '刘', '景', '詹', '龙', '叶', '幸', '司', '黎', '溥', '印', '怀', '蒲', '邰', '从', '索', '赖', '卓', '屠', '池', '乔', '胥', '闻', '莘', '党', '翟', '谭', '贡', '劳', '逄', '姬', '申',
                '扶', '堵', '冉', '宰', '雍', '桑', '寿', '通', '燕', '浦', '尚', '农', '温', '别', '庄', '晏', '柴', '瞿', '阎', '连', '习', '容', '向', '古', '易', '廖', '庾', '终', '步', '都', '耿', '满', '弘', '匡', '国', '文',
                '寇', '广', '禄', '阙', '东', '欧', '利', '师', '巩', '聂', '关', '荆', '司马', '上官', '欧阳', '夏侯', '诸葛', '闻人', '东方', '赫连', '皇甫', '尉迟', '公羊', '澹台', '公冶', '宗政', '濮阳', '淳于', '单于', '太叔',
                '申屠', '公孙', '仲孙', '轩辕', '令狐', '徐离', '宇文', '长孙', '慕容', '司徒', '司空', '皮'];

            $lastName = ['伟', '刚', '勇', '毅', '俊', '峰', '强', '军', '平', '保', '东', '文', '辉', '力', '明', '永', '健', '世', '广', '志', '义', '兴', '良', '海', '山', '仁', '波', '宁', '贵', '福', '生', '龙', '元', '全'
                , '国', '胜', '学', '祥', '才', '发', '武', '新', '利', '清', '飞', '彬', '富', '顺', '信', '子', '杰', '涛', '昌', '成', '康', '星', '光', '天', '达', '安', '岩', '中', '茂', '进', '林', '有', '坚', '和', '彪', '博', '诚'
                , '先', '敬', '震', '振', '壮', '会', '思', '群', '豪', '心', '邦', '承', '乐', '绍', '功', '松', '善', '厚', '庆', '磊', '民', '友', '裕', '河', '哲', '江', '超', '浩', '亮', '政', '谦', '亨', '奇', '固', '之', '轮', '翰'
                , '朗', '伯', '宏', '言', '若', '鸣', '朋', '斌', '梁', '栋', '维', '启', '克', '伦', '翔', '旭', '鹏', '泽', '晨', '辰', '士', '以', '建', '家', '致', '树', '炎', '德', '行', '时', '泰', '盛', '雄', '琛', '钧', '冠', '策'
                , '腾', '楠', '榕', '风', '航', '弘', '秀', '娟', '英', '华', '慧', '巧', '美', '娜', '静', '淑', '惠', '珠', '翠', '雅', '芝', '玉', '萍', '红', '娥', '玲', '芬', '芳', '燕', '彩', '春', '菊', '兰', '凤', '洁', '梅', '琳'
                , '素', '云', '莲', '真', '环', '雪', '荣', '爱', '妹', '霞', '香', '月', '莺', '媛', '艳', '瑞', '凡', '佳', '嘉', '琼', '勤', '珍', '贞', '莉', '桂', '娣', '叶', '璧', '璐', '娅', '琦', '晶', '妍', '茜', '秋', '珊', '莎'
                , '锦', '黛', '青', '倩', '婷', '姣', '婉', '娴', '瑾', '颖', '露', '瑶', '怡', '婵', '雁', '蓓', '纨', '仪', '荷', '丹', '蓉', '眉', '君', '琴', '蕊', '薇', '菁', '梦', '岚', '苑', '婕', '馨', '瑗', '琰', '韵', '融', '园'
                , '艺', '咏', '卿', '聪', '澜', '纯', '毓', '悦', '昭', '冰', '爽', '琬', '茗', '羽', '希', '欣', '飘', '育', '滢', '馥', '筠', '柔', '竹', '霭', '凝', '晓', '欢', '霄', '枫', '芸', '菲', '寒', '伊', '亚', '宜', '可', '姬'
                , '舒', '影', '荔', '枝', '丽', '阳', '妮', '宝', '贝', '初', '程', '梵', '罡', '恒', '鸿', '桦', '骅', '剑', '娇', '纪', '宽', '苛', '灵', '玛', '媚', '琪', '晴', '容', '睿', '烁', '堂', '唯', '威', '韦', '雯', '苇', '萱'
                , '阅', '彦', '宇', '雨', '洋', '忠', '宗', '曼', '紫', '逸', '贤', '蝶', '菡', '绿', '蓝', '儿', '翠', '烟'];

            if (time() % 10 > 4) return arr::array_random($firstName) . arr::array_random($lastName) . arr::array_random($lastName);

            return arr::array_random($firstName) . arr::array_random($lastName);

        } else {
            $firstName = ['迷你的', '鲜艳的', '飞快的', '真实的', '清新的', '幸福的', '可耐的', '快乐的', '冷静的', '醉熏的', '潇洒的', '糊涂的', '积极的', '冷酷的', '深情的', '粗暴的',
                '温柔的', '可爱的', '愉快的', '义气的', '认真的', '威武的', '帅气的', '传统的', '潇洒的', '漂亮的', '自然的', '专一的', '听话的', '昏睡的', '狂野的', '等待的', '搞怪的',
                '幽默的', '魁梧的', '活泼的', '开心的', '高兴的', '超帅的', '留胡子的', '坦率的', '直率的', '轻松的', '痴情的', '完美的', '精明的', '无聊的', '有魅力的', '丰富的', '繁荣的',
                '饱满的', '炙热的', '暴躁的', '碧蓝的', '俊逸的', '英勇的', '健忘的', '故意的', '无心的', '土豪的', '朴实的', '兴奋的', '幸福的', '淡定的', '不安的', '阔达的', '孤独的',
                '独特的', '疯狂的', '时尚的', '落后的', '风趣的', '忧伤的', '大胆的', '爱笑的', '矮小的', '健康的', '合适的', '玩命的', '沉默的', '斯文的', '香蕉', '苹果', '鲤鱼', '鳗鱼',
                '任性的', '细心的', '粗心的', '大意的', '甜甜的', '酷酷的', '健壮的', '英俊的', '霸气的', '阳光的', '默默的', '大力的', '孝顺的', '忧虑的', '着急的', '紧张的', '善良的',
                '凶狠的', '害怕的', '重要的', '危机的', '欢喜的', '欣慰的', '满意的', '跳跃的', '诚心的', '称心的', '如意的', '怡然的', '娇气的', '无奈的', '无语的', '激动的', '愤怒的',
                '美好的', '感动的', '激情的', '激昂的', '震动的', '虚拟的', '超级的', '寒冷的', '精明的', '明理的', '犹豫的', '忧郁的', '寂寞的', '奋斗的', '勤奋的', '现代的', '过时的',
                '稳重的', '热情的', '含蓄的', '开放的', '无辜的', '多情的', '纯真的', '拉长的', '热心的', '从容的', '体贴的', '风中的', '曾经的', '追寻的', '儒雅的', '优雅的', '开朗的',
                '外向的', '内向的', '清爽的', '文艺的', '长情的', '平常的', '单身的', '伶俐的', '高大的', '懦弱的', '柔弱的', '爱笑的', '乐观的', '耍酷的', '酷炫的', '神勇的', '年轻的',
                '唠叨的', '瘦瘦的', '无情的', '包容的', '顺心的', '畅快的', '舒适的', '靓丽的', '负责的', '背后的', '简单的', '谦让的', '彩色的', '缥缈的', '欢呼的', '生动的', '复杂的',
                '慈祥的', '仁爱的', '魔幻的', '虚幻的', '淡然的', '受伤的', '雪白的', '高高的', '糟糕的', '顺利的', '闪闪的', '羞涩的', '缓慢的', '迅速的', '优秀的', '聪明的', '含糊的',
                '俏皮的', '淡淡的', '坚强的', '平淡的', '欣喜的', '能干的', '灵巧的', '友好的', '机智的', '机灵的', '正直的', '谨慎的', '俭朴的', '殷勤的', '虚心的', '辛勤的', '自觉的',
                '无私的', '无限的', '踏实的', '老实的', '现实的', '可靠的', '务实的', '拼搏的', '个性的', '粗犷的', '活力的', '成就的', '勤劳的', '单纯的', '落寞的', '朴素的', '悲凉的',
                '忧心的', '洁净的', '清秀的', '自由的', '小巧的', '单薄的', '贪玩的', '刻苦的', '干净的', '壮观的', '和谐的', '文静的', '调皮的', '害羞的', '安详的', '自信的', '端庄的',
                '坚定的', '美满的', '舒心的', '温暖的', '专注的', '勤恳的', '美丽的', '腼腆的', '优美的', '甜美的', '甜蜜的', '整齐的', '动人的', '典雅的', '尊敬的', '舒服的', '妩媚的',
                '秀丽的', '喜悦的', '甜美的', '彪壮的', '强健的', '大方的', '俊秀的', '聪慧的', '迷人的', '陶醉的', '悦耳的', '动听的', '明亮的', '结实的', '魁梧的', '标致的', '清脆的',
                '敏感的', '光亮的', '大气的', '老迟到的', '知性的', '冷傲的', '呆萌的', '野性的', '隐形的', '笑点低的', '微笑的', '笨笨的', '难过的', '沉静的', '火星上的', '失眠的',
                '安静的', '纯情的', '要减肥的', '迷路的', '烂漫的', '哭泣的', '贤惠的', '苗条的', '温婉的', '发嗲的', '会撒娇的', '贪玩的', '执着的', '眯眯眼的', '花痴的', '想人陪的',
                '眼睛大的', '高贵的', '傲娇的', '心灵美的', '爱撒娇的', '细腻的', '天真的', '怕黑的', '感性的', '飘逸的', '怕孤独的', '忐忑的', '高挑的', '傻傻的', '冷艳的', '爱听歌的',
                '还单身的', '怕孤单的', '懵懂的'];

            $lastName = ['嚓茶', '皮皮虾', '皮卡丘', '马里奥', '小霸王', '凉面', '便当', '毛豆', '花生', '可乐', '灯泡', '哈密瓜', '野狼', '背包', '眼神', '缘分', '雪碧', '人生', '牛排',
                '蚂蚁', '飞鸟', '灰狼', '斑马', '汉堡', '悟空', '巨人', '绿茶', '自行车', '保温杯', '大碗', '墨镜', '魔镜', '煎饼', '月饼', '月亮', '星星', '芝麻', '啤酒', '玫瑰',
                '大叔', '小伙', '哈密瓜，数据线', '太阳', '树叶', '芹菜', '黄蜂', '蜜粉', '蜜蜂', '信封', '西装', '外套', '裙子', '大象', '猫咪', '母鸡', '路灯', '蓝天', '白云',
                '星月', '彩虹', '微笑', '摩托', '板栗', '高山', '大地', '大树', '电灯胆', '砖头', '楼房', '水池', '鸡翅', '蜻蜓', '红牛', '咖啡', '机器猫', '枕头', '大船', '诺言',
                '钢笔', '刺猬', '天空', '飞机', '大炮', '冬天', '洋葱', '春天', '夏天', '秋天', '冬日', '航空', '毛衣', '豌豆', '黑米', '玉米', '眼睛', '老鼠', '白羊', '帅哥', '美女',
                '季节', '鲜花', '服饰', '裙子', '白开水', '秀发', '大山', '火车', '汽车', '歌曲', '舞蹈', '老师', '导师', '方盒', '大米', '麦片', '水杯', '水壶', '手套', '鞋子', '自行车',
                '鼠标', '手机', '电脑', '书本', '奇迹', '身影', '香烟', '夕阳', '台灯', '宝贝', '未来', '皮带', '钥匙', '心锁', '故事', '花瓣', '滑板', '画笔', '画板', '学姐', '店员',
                '电源', '饼干', '宝马', '过客', '大白', '时光', '石头', '钻石', '河马', '犀牛', '西牛', '绿草', '抽屉', '柜子', '往事', '寒风', '路人', '橘子', '耳机', '鸵鸟', '朋友',
                '苗条', '铅笔', '钢笔', '硬币', '热狗', '大侠', '御姐', '萝莉', '毛巾', '期待', '盼望', '白昼', '黑夜', '大门', '黑裤', '钢铁侠', '哑铃', '板凳', '枫叶', '荷花', '乌龟',
                '仙人掌', '衬衫', '大神', '草丛', '早晨', '心情', '茉莉', '流沙', '蜗牛', '战斗机', '冥王星', '猎豹', '棒球', '篮球', '乐曲', '电话', '网络', '世界', '中心', '鱼', '鸡', '狗',
                '老虎', '鸭子', '雨', '羽毛', '翅膀', '外套', '火', '丝袜', '书包', '钢笔', '冷风', '八宝粥', '烤鸡', '大雁', '音响', '招牌', '胡萝卜', '冰棍', '帽子', '菠萝', '蛋挞', '香水',
                '泥猴桃', '吐司', '溪流', '黄豆', '樱桃', '小鸽子', '小蝴蝶', '爆米花', '花卷', '小鸭子', '小海豚', '日记本', '小熊猫', '小懒猪', '小懒虫', '荔枝', '镜子', '曲奇', '金针菇',
                '小松鼠', '小虾米', '酒窝', '紫菜', '金鱼', '柚子', '果汁', '百褶裙', '项链', '帆布鞋', '火龙果', '奇异果', '煎蛋', '唇彩', '小土豆', '高跟鞋', '戒指', '雪糕', '睫毛', '铃铛',
                '手链', '香氛', '红酒', '月光', '酸奶', '银耳汤', '咖啡豆', '小蜜蜂', '小蚂蚁', '蜡烛', '棉花糖', '向日葵', '水蜜桃', '小蝴蝶', '小刺猬', '小丸子', '指甲油', '康乃馨', '糖豆',
                '薯片', '口红', '超短裙', '乌冬面', '冰淇淋', '棒棒糖', '长颈鹿', '豆芽', '发箍', '发卡', '发夹', '发带', '铃铛', '小馒头', '小笼包', '小甜瓜', '冬瓜', '香菇', '小兔子',
                '含羞草', '短靴', '睫毛膏', '小蘑菇', '跳跳糖', '小白菜', '草莓', '柠檬', '月饼', '百合', '纸鹤', '小天鹅', '云朵', '芒果', '面包', '海燕', '小猫咪', '龙猫', '唇膏', '鞋垫',
                '羊', '黑猫', '白猫', '万宝路', '金毛', '山水', '音响', '纸飞机', '烧鹅'];

            return arr::array_random($firstName) . arr::array_random($lastName);
        }
    }

    //删除文件夹下$n分钟前创建的文件
    static function delFileByCtime($dir, $n = '', $ignore = [])
    {
        return file::delFileByCtime($dir, $n, $ignore);
    }

    //只含有26个字母或者数字的并且都是半角的字符串，转换成数字，用于hash分表
    static function string2Number($str)
    {
        return str::string2Number($str);
    }

    //修改一维或多维数组的键名，参数一：需要修改的数组，参数二：['从什么'=>'改成什么']
    static function changeArrKey($arr, $target)
    {
        return arr::changeArrKey($arr, $target);
    }

    //递归处理数组数据，参数一：需要修改的数组，参数二：[从什么]，参数三：变成什么
    static function changeArrVal($arr, $saki = ['', null], $moto = '-', $useTrim = true)
    {
        return arr::changeArrVal($arr, $saki, $moto, $useTrim);
    }

    //
    static function removeArrKey($arr, $example = ['created_at', 'updated_at'])
    {
        return arr::removeArrKey($arr, $example);
    }

    //为字符串的指定位置添加指定字符
    static function insertSomething($str, array $offset, $delimiter = '-')
    {
        return str::insertSomething($str, $offset, $delimiter);
    }

    //无限极分类
    static function traverseMenu($menus, &$result, $pid = 0)
    {
        //数据样子
        //$menus = [
        //    ['id' => 1, 'pid' => 0, 'name' => '商品管理'],
        //    ['id' => 2, 'pid' => 1, 'name' => '平台自营'],
        //    ['id' => 3, 'pid' => 2, 'name' => '图书品类'],
        //    ['id' => 4, 'pid' => 2, 'name' => '3C品类'],
        //    ['id' => 5, 'pid' => 0, 'name' => '第三方'],
        //    ['id' => 6, 'pid' => 5, 'name' => '家私用品'],
        //    ['id' => 7, 'pid' => 5, 'name' => '书法品赏'],
        //    ['id' => 8, 'pid' => 7, 'name' => '行书'],
        //    ['id' => 9, 'pid' => 8, 'name' => '行楷'],
        //    ['id' => 10, 'pid' => 9, 'name' => '张山行楷字帖'],
        //    ['id' => 11, 'pid' => 22, 'name' => '李四行楷字帖'],
        //];

        //使用方式
        //$result = [];
        //traverseMenu($menus,$result,0);
        //dd($result);

        foreach ($menus as $child_menu) {
            if ($child_menu['pid'] == $pid) {
                $item = [
                    'id' => $child_menu['id'],
                    'name' => $child_menu['name'],
                    'children' => []
                ];

                self::traverseMenu($menus, $item['children'], $child_menu['id']);

                $result[] = $item;
            } else {
                continue;
            }
        }

        return true;
    }

    //无限级分类
    static function traverseMenuNew($menus, &$result, $pid = 0, $ext = []): bool
    {
        //自定义字段
        $id_field = $ext['id_field'] ?? 'id';
        $pid_field = $ext['pid_field'] ?? 'pid';
        $children_field = $ext['children_field'] ?? 'children';
        //保留字段
        $save_field = $ext['save_field'] ?? [];

        foreach ($menus as $child_menu) {
            if ($child_menu[$pid_field] === $pid) {
                $item = [
                    $id_field => $child_menu[$id_field],
                ];
                foreach ($child_menu as $key => $val) {
                    if (empty($save_field) || in_array($key, $save_field, true)) {
                        $item[$key] = $val;
                    }
                }
                $item[$children_field] = [];
                self::traverseMenuNew($menus, $item[$children_field], $child_menu[$id_field], $ext);
                $result[] = $item;
            }
        }

        return true;
    }

    //中文字符串包含 source源字符串target要判断的是否包含的字符串
    static function hasString($source, $target)
    {
        return str::hasString($source, $target);
    }

    //向前匹配
    static function hasStringFront($source, $target1, $target2)
    {
        return str::hasStringFront($source, $target1, $target2);
    }

    //二维数组按照某key排序
    static function sortArrByKey($array, $key = 'id', $rule = 'desc', $useNew = false)
    {
        if ($useNew) {
            return arr::sortArrByKeyNew($array, $key, $rule);
        }

        return arr::sortArrByKey($array, $key, $rule);
    }

    //快速排序
    static function quickSort($arr)
    {
        return arr::quickSort($arr);
    }

    //冒泡排序
    static function bubbleSort($arr)
    {
        return arr::bubbleSort($arr);
    }

    //aes加密
    static function aesEncode($str, $salt = __CLASS__, $method = 128, $mode = 'hex'): string
    {
        return str::aesEncode($str, $salt, $method, $mode);
    }

    //aes解密
    static function aesDecode($str, $salt = __CLASS__, $method = 128, $mode = 'hex')
    {
        return str::aesDecode($str, $salt, $method, $mode);
    }

    //写log
    static function writeLog($content = '', $path = '', $type = 'info', $logFileName = '')
    {
        return file::writeLog($content, $path, $type, $logFileName);
    }

    //比例计算图片宽高
    static function calculateDimensions($width, $height, $maxWidth, $maxHeight)
    {
        return img::calculateDimensions($width, $height, $maxWidth, $maxHeight);
    }

    //产生随机数
    static function randNum($length = 18)
    {
        return num::randNum($length);
    }

    //获取身份证信息
    static function getIdCardInfo($idCardNum)
    {
        return (new idCard($idCardNum))->getInfo();
    }

    //字符串转化utf8
    static function str2Utf8($str, $addType = [])
    {
        return str::str2Utf8($str, $addType);
    }

    //图片转base64
    static function img2Base64($imgPath, $needPrefix = false)
    {
        return img::img2Base64($imgPath, $needPrefix);
    }

    //代替range
    static function xRange($start, $stop, $step = 1)
    {
        return arr::xRange($start, $stop, $step);
    }

    //
    static function array_flatten($arr, $deep = INF)
    {
        return arr::array_flatten($arr, $deep);
    }

    static function head($arr)
    {
        return arr::head($arr);
    }

    static function last($arr)
    {
        return arr::last($arr);
    }

    static function toChineseNumber($num)
    {
        return num::toChineseNumber($num);
    }

    static function numToStrForId($num): ?string
    {
        return num::numToStringForId($num);
    }

    static function strToNumForId($str): int
    {
        return num::stringToNumForId($str);
    }

    static function rsaEncrypt(string $str = '', string $key = '', string $use = 'pub', string $mark = '_'): ?string
    {
        return str::rsaEncrypt($str, $key, $use, $mark);
    }

    static function rsaDecrypt(string $str = '', string $key = '', string $use = 'pri', string $mark = '_'): ?string
    {
        return str::rsaDecrypt($str, $key, $use, $mark);
    }

    static function createRsa(string $storePath, array $conf = []): ?array
    {
        //RSA加密解密有个填充方式padding的参数，不同编程语言之间交互，需要注意这个。
        //padding can be one of OPENSSL_PKCS1_PADDING, OPENSSL_SSLV23_PADDING, OPENSSL_PKCS1_OAEP_PADDING,OPENSSL_NO_PADDING
        //值得注意的是，如果选择密钥是1024bit长的（openssl genrsa -out rsa_private_key.pem 1024），那么支持加密的明文长度字节最多只能是1024/8=128byte；
        //如果加密的padding填充方式选择的是OPENSSL_PKCS1_PADDING（这个要占用11个字节），那么明文长度最多只能就是128-11=117字节。如果超出，那么这些openssl加解密函数会返回false。
        //这时有个解决办法，把需要加密的源字符串按少于117个长度分开为几组，在解密的时候以172个字节分为几组。
        //其中的『少于117』（只要不大于117即可）和『172』两个数字是怎么来的，值得一说。
        //为什么少于117就行，因为rsa encrypt后的字节长度是固定的，就是密钥长1024bit/8=128byte。因此只要encrypt不返回false，即只要不大于117个字节，那么返回加密后的都是128byte。
        //172是因为什么？因为128个字节base64_encode后的长度固定是172。
        //这里顺便普及下base64_encode。encode的长度是和原文长度有个计算公式：
        //$len2 = $len1%3 >0 ? (floor($len1/3)*4 + 4) : ($len1*4/3);

        return str::createRsa($storePath, $conf);
    }

    static function inArea(string $lat, string $lng, array $area): bool
    {
        return img::inArea($lat, $lng, $area);
    }

    static function checkBankCardNo(string $card): bool
    {
        return num::luhn($card);
    }

    //一行一行的读文件内容
    static function readFile($file, $page = 1, $limit = 20): ?array
    {
        return file::readFile($file, $page, $limit);
    }

    //二分查找
    static function binarySearch($find, $arr, $startIndex, $indexTotal)
    {
        return arr::binarySearch($find, $arr, $startIndex, $indexTotal);
    }

    //SHA256WithRSA MD5WithRSA
    static function xxxWithRsa(string $pem, string $str, int $method, string $priOrPub = 'pri'): ?string
    {
        return str::xxxWithRsa($pem, $str, $method, $priOrPub);
    }

    static function colorInverse($hex_color): string
    {
        return img::colorInverse($hex_color);
    }


}
