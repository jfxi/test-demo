<?php


namespace app\api\model;


class Product extends BaseModel
{
    protected $hidden = ['update_time','delete_time','main_img_id','pivot','from','category_id','create_time'];

    public function getMainImgUrlAttr($value,$data){
        return $this->prefixImgUrl($value,$data);
    }

    public function imgs(){
        return $this->hasMany('ProductImage','product_id','id');
    }

    public function properties(){
        return $this->hasMany('ProductProperty','product_id','id');
    }

    public static function getMostRecent($count){
//        指定数量limit
        $prouducts = self::limit($count)
//            tp5排序用order方法
            ->order('create_time desc')
            ->select();
        return $prouducts;
    }

    public static function getProductsByCategoryID($categoryID)
    {
        $products = self::where('category_id','=',$categoryID)
            ->select();
        return $products;
    }
//商品详情查询逻辑
    public static function getProductDetail($id)
    {
        $product = self::with([
            'imgs' => function ($query) {
                $query->with(['imgUrl'])
                    ->order('order', 'asc');
            }
        ])
            ->with(['properties'])
            ->find($id);
        return $product;
    }
}