<?php
namespace app\api\service;

use app\application\api\service\Token;
use app\application\lib\exception\TokenException;
use app\application\lib\exception\WeChtException;
use think\Exception;
use app\api\model\User;

class UserToken extends Token
{
    protected $code;
    protected $wxAppID;
    protected $wxAppSecret;
    protected $wxLoginUrl;
    function __construct($code)
    {
        $this->code = $code;
        $this->wxAppID = config('wx.app_id');
        $this->wxAppSecret =config('wx.app_secret');
        $this->wxLoginUrl = sprintf(config('wx.login_url'),$this->wxAppID,$this->wxAppSecret,$this->code);
    }

    public function get(){
        $result = curl_get($this->wxLoginUrl);
        $wxResult = json_decode($result,true);
        if(empty($wxResult)){
            throw new Exception('获取异常openId');
        }
        else{
            $loginFail = array_key_exists('errcode',$wxResult);
            if ($loginFail){
                $this->processLoginError();
            }else{
                return $this->grantToken($wxResult);
            }
        }
    }
    protected function grantToken($wxResult){
        //拿到openid
        //数据库里看一下  这个openid是不是存在
        //如果存在不处理，不存在，新增一条  User记录
        //生成令牌，准备缓存数据，写人缓存
        //把令牌返回到客户端去
        //key : 令牌
        //value : wxResult uid  scope
        $openid = $wxResult['openid'];
        $user = UserModel::getByOpenID($openid);
        if ($user){
            $uid = $user->id;
        }else{
            $uid = $this->newUser($openid);
        }
        $cachedValue = $this->prepareCacheaValue($wxResult,$uid);
        $token =$this->saveToCache($cachedValue);
        return $token;
    }

    protected function saveToCache($cachedValue){
        $key = self::generateToken();
        $value = json_encode($cachedValue);
        $expire_in = config('setting.token_expire_in');
        $request = cache($key,$value,$expire_in);
        if(!$request){
            throw new TokenException([
                'msg'=>'服务器缓存异常',
                'errorCode'=>10005
            ]);
        }
        return $key;
    }

    protected function prepareCacheaValue($wxResult,$uid){
            $cachedValue = $wxResult;
            $cachedValue['uid'] = $uid;
            $cachedValue['scope']= 16;
            return $cachedValue;
    }

    protected function newUser($openid){
        $user = UserModel::create([
            'openid'=>$openid
        ]);
        return $user->id;
    }


    protected function processLoginError($wxResult){
        throw new WeChtException([
            'msg'=>$wxResult['errmsg'],
            'errorCode'=>$wxResult['errCode']
        ]);
    }
}