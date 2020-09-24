<?php


namespace app\application\lib\exception;


use app\lib\exception\BaseException;

class WeChtException extends BaseException
{
    public $code = 400;
    public $msg = '微信服务器接口调用失败';
    public $errorCode = 999;
}