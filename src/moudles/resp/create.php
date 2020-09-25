<?php

namespace wanghanwanghan\someUtils\moudles\resp;

use wanghanwanghan\someUtils\traits\Singleton;

class create
{
    use Singleton;

    function createResp($code = 200, $page = [], $result = [], $msg = '')
    {
        $code = $this->checkCode($code);
        $page = $this->checkPage($page);
        $result = $this->checkResult($result);
        $msg = $this->checkMsg($msg);

        return ['code' => $code, 'page' => $page, 'result' => $result, 'msg' => $msg];
    }

    private function checkCode($code)
    {
        return (int)$code;
    }

    private function checkPage($page)
    {
        $info = ['page' => null, 'pageSize' => null, 'pageTotal' => null];

        if (is_array($page) && !empty($page)) {
            !isset($page['page']) ?: $info['page'] = (int)$page['page'];
            !isset($page['pageSize']) ?: $info['pageSize'] = (int)$page['pageSize'];
            !isset($page['pageTotal']) ?: $info['pageTotal'] = (int)$page['pageTotal'];
        }

        return $info;
    }

    private function checkResult($result)
    {
        return empty($result) ? [] : $result;
    }

    private function checkMsg($msg)
    {
        return empty($msg) ? '' : (string)$msg;
    }

}