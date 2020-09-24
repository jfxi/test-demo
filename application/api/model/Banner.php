<?php


namespace app\api\model;
use think\Db;
use think\Model;

class Banner extends BaseModel
{
    protected $hidden = ['update_time','delete_time'];
    public function items(){
        return $this->hasMany('BannerItem','banner_id','id');
    }
    public static function getBannerByID($id){
        $banner =self::with(['items','items.img'])->find($id);
        return $banner;
//        原生SQl
//        $result = Db::query('select * from banner_item where banner_id= ?',[$id] );
//        return $result;
//        查询构造器
//        $result = Db::table('banner_item')
//            ->where('banner_id','=',$id)
//            ->find();//链式方法
//        update
//        delete
//        insert
//        find
//        闭包
//        $result = Db::table('banner_item')
//            ->where(function ($query) use ($id){
//                $query->where('banner_id','=',$id);
//            })
//            ->select();//链式方法
//        return $result;
    }
}