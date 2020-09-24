<?php


namespace app\api\controller\v1;


use app\api\model\User as UserModel;
use app\api\validate\AddressNew;

use app\api\service\Token as TokenService;
use app\lib\exception\UserException;

class Address
{
    public function createOrUpdateAddress()
    {
        //验证客户端提交过来的地址
        (new AddressNew())->goCheck();
        //根据token获取用户的Uid
        //根据uid来查找用户数据，判断用户是否存在，如果不存在抛出异常
        //获取从客户端提交来的地址信息
        //根据用户地址信息是否存在，从而判断是添加还是更新
        $uid = TokenService::getCurrenUid();
        $user = UserModel::get($uid);
        if (!$uid) {
            throw new UserException();
        }
        $dataArray = getdata();
        $userAddress = $user->address();
        if (!$userAddress){

        }
    }
}