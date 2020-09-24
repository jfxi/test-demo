<?php


namespace app\api\controller\v1;


use app\api\validate\IDColletion;
use app\api\model\Theme as ThemeModel;
use app\api\validate\IDMustBePostiveInt;
use app\lib\exception\ThemeException;

class Theme
{
    public function getSimpleList($ids=''){
        (new IDColletion())->goCheck();
        $ids = explode(',',$ids);
        $result = ThemeModel::with('topicImg,headImg')->select($ids);
        if ($result->isEmpty()){
            throw new ThemeException();
        }
        return $result;
    }

    public function getComplexOne($id){
        (new IDMustBePostiveInt())->goCheck();
        $theme = ThemeModel::getThemeWithProducts($id);
        if(!$theme){
            throw new ThemeException();
        }
        return $theme;
    }
}