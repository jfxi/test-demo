<?php


namespace app\api\service;

use app\lib\exception\TokenException;
use think\Cache;
use think\Request;

class Token
{
    public static function generateToken()
    {
        //32位随机字符串
        $randChars = getRandChar(32);
        //用三组字符串进行md5加密
        $timestamp = $_SERVER['REQUEST_TIME_FLOAT'];
        $salt = config('secure.token_salt');
        return md5($randChars . $timestamp . $salt);
    }

    public static function getcurrenTokenVar($key)
    {
        //实例化了
        $token = Request::instance()
            ->header('token');
        $vars = Cache::get($token);
        if (!$vars) {
            throw new TokenException();
        } else {
            if (!is_array($vars))
                $vars = json_decode($vars, true);
        }
        if (array_key_exists($key, $vars)) {
            return $vars[$key];
        }
        else{
            new Exception('尝试获取token变量不存在');
        }
    }

    public static function getCurrenUid(){
        //token
        $uid = self::getcurrenTokenVar('uid');
        return $uid;
    }
}