<?php


namespace app\application\lib\exception;


use app\lib\exception\BaseException;

class TokenException extends BaseException
{
    public $code = 401;
    public $msg = 'Token过期';
    public $errorCode = 10001;
}