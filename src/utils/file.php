<?php

namespace wanghanwanghan\someUtils\utils;

class file
{
    //删除文件夹下$n分钟前创建的文件
    static function delFileByCtime($dir, $n = '', $ignore = [])
    {
        $ignore = array_merge($ignore, ['.', '..', '.gitignore']);

        if (is_dir($dir) && !empty($n)) {
            if ($dh = opendir($dir)) {
                while (false !== ($file = readdir($dh))) {
                    if (!in_array($file, $ignore, true)) {
                        $fullpath = $dir . DIRECTORY_SEPARATOR . $file;
                        if (is_dir($fullpath)) {
                            if (count(scandir($fullpath)) == 2 && $file != date('Y-m-d')) {
                                //目录为空,=2是因为.和..存在
                                rmdir($fullpath); // 删除空目录
                            } else {
                                self::delFileByCtime($fullpath, $n, $ignore); //不为空继续判断文件夹中文件
                            }
                        } else {
                            $filedate = filemtime($fullpath); //获取文件创建时间
                            $minutes = round((time() - $filedate) / 60); //计算已创建分钟
                            if ($minutes > $n) unlink($fullpath); //删除过期文件
                        }
                    }
                }
            }
            closedir($dh);
        }

        return true;
    }

    //写日志
    static function writeLog($content = '', $path = '', $type = 'info', $logFileName = '')
    {
        //非字符串的内容处理一下
        if (!empty($content) && !is_string($content)) $content = json_encode($content);

        $content = '[' . date('Y-m-d H:i:s', time()) . '] [' . strtoupper($type) . '] : ' . $content . PHP_EOL;

        //传绝对路径
        is_dir($path) || mkdir($path, 0755);

        $path .= DIRECTORY_SEPARATOR;

        if (empty($logFileName)) $logFileName = 'run.log.' . date('Ymd', time());

        $status = true;

        try {
            file_put_contents($path . $logFileName, $content, FILE_APPEND | LOCK_EX);
        } catch (\Exception $e) {
            $status = false;
        }

        return $status;
    }

    //一行一行的读文件内容
    static function readFile($file, $page = 1, $limit = 20): ?array
    {
        if (!is_file($file)) {
            return null;
        }

        $handle = new \SplFileObject($file, 'r');

        $offset = ($page - 1) * $limit;

        $handle->seek($offset);

        $res = [];

        for ($i = 0; $i < $limit; $i++) {
            $current = $handle->current();
            if (!$current) break;
            $res[] = $current;
            $handle->next();
        }

        return $res;
    }

}
