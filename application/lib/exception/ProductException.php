<?php


namespace app\lib\exception;


class ProductException extends BaseException
{
    public $code = 404;
    public $msg = '指定商品部存在';
    public $errorCode = 20000;
}