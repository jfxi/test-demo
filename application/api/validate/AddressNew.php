<?php


namespace app\api\validate;


class AddressNew extends BaseValidate
{
    //客户端提交哪些字段给我们？
    protected $rule = [
        'name' => 'require|isNotEmpty',
        'mobile' => 'require|isMobile',
        'province' => 'require|isNotEmpty',
        'city' => 'require|isNotEmpty',
        'county' => 'require|isNotEmpty',
        'detail' => 'require|isNotEmpty',
    ];
}