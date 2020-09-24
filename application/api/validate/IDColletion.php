<?php


namespace app\api\validate;


class IDColletion extends BaseValidate
{
    protected $rule = [
        'ids'=>'require|checkIDs'
    ];
    protected $message =[
            'ids'=>'必须正数'
    ];
    protected function checkIDs($value){
        $value = explode('',$value);
        if (empty($value)){
            return false;
        }
        foreach ($value as $id){
            if(!$this->isPositiveInteger($id)){
                return false;
            }
        }
        return true;
    }
}