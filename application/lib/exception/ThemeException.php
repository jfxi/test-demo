<?php


namespace app\lib\exception;


use app\api\validate\BaseValidate;

class ThemeException extends BaseException
{
    public $code = 300;
    public $msg = '参数错误';
    public $errorCode = 20000;
}