<?php

class wanghan
{
    public $BaseDir = '/mnt/web/cyqlh/public/video/file/';

    //遍历文件夹，返回不含有mp4的文件
    public function dir($dir)
    {
        $res = [];

        if ($handle = opendir($dir)) {
            while (($file = readdir($handle)) !== false) {
                if ($file != ".." && $file != ".") {
                    //排除根目录
                    if (is_dir($dir . "/" . $file)) {
                        //如果是子文件夹，就进行递归
                        $res[$file] = $this->dir($dir . "/" . $file);
                    } else {
                        //不然就将文件的名字存入数组
                        //判断是否含有mp4
                        if (preg_match('/mp4|docx|doc|xlsx|xls|pdf|rar|zip|jpg|jpeg|png/', $file)) continue;
                        $res[] = $file;
                    }
                }
            }

            closedir($handle);

            return $res;
        }

        return [];
    }
}

$redis = new Redis;
$host = '127.0.0.1';
$post = '6379';
$res = $redis->connect($host, $post);
if (!$res) die('redis server链接失败');
$redis->auth('qilianhui123');

//有未完成的任务，直接退出
if (is_numeric($redis->get('crontab_handle_video_file'))) exit;

//加标记
$redis->set('crontab_handle_video_file', time());

$dir = new wanghan();

$dirArray = $dir->dir($dir->BaseDir);

foreach ($dirArray as $key => $val) {
    if (empty($val)) continue;

    foreach ($val as $one) {
        $fileInfo = explode('.', $one);

        //肯定是有错
        if (count($fileInfo) != 2) continue;

        try {
            //获取文件时间戳
            $filename = $dir->BaseDir . $key . DIRECTORY_SEPARATOR . $one;

            $cmd = "stat -c %Y $filename";

            exec(escapeshellcmd($cmd), $output, $status);

            $time = $output[0];

            if (!is_numeric($time) || strlen($time) != 10) continue;

            //视频上传10分钟后才可以被转化
            if (time() - $time < 10 * 60) continue;

        } catch (Exception $e) {

        }

        try {
            $be = $dir->BaseDir . $key . DIRECTORY_SEPARATOR . $one;
            $af = $dir->BaseDir . $key . DIRECTORY_SEPARATOR . $fileInfo[0] . '.mp4';

            //$cmd="ffmpeg -i {$be} -y -qscale 0 -vcodec libx264 copy {$af}";
            $cmd = "ffmpeg -i {$be} -y -qscale 0 -vcodec libx264 {$af}";

            exec(escapeshellcmd($cmd), $output, $status);

            if (!is_dir($be)) unlink($be);

        } catch (Exception $e) {

        }
    }
}

try {
    $cmd = "chmod -R 777 {$dir->BaseDir}";
    exec(escapeshellcmd($cmd), $output, $status);

} catch (Exception $e) {

}

//删标记
$redis->del('crontab_handle_video_file');