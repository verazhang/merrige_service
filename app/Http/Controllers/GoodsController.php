<?php
/**
 * Created by PhpStorm.
 * User: anaqingfeng
 * Date: 2018/6/10
 * Time: 下午2:04
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Goods;

class GoodsController extends Controller
{
    /**
     * 添加新货
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function create(Request $request)
    {
        $fields = [
            'usage',
            'color',
            'size',
//            'code',
            'cost',
            'codehref',
        ];
        foreach ($fields as $field) {
            $attributes[$field] = $request->input($field);
        }
        $attributes['is_sold'] = Goods::GOODS_IS_SOLD_NO;

        $model = new Goods();
        $model->setRawAttributes($attributes);
        $result = $model->save();

        return $this->resultJson($model->getAttributes(), $result);
    }

    /**
     * 获取商品概要信息
     * @return \Illuminate\Http\JsonResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function getSummary(Request $request)
    {
        $fields = [
            'usage',
            'color',
            'size',
        ];

        $model = new Goods();
        $model = $model
            ->selectRaw("color,`usage`,size,count(1) as total")
            ->groupBy("size");
        foreach ($fields as $field) {
            $attributes[$field] = $request->input($field);
            $model->where($field, $attributes[$field]);
        }
        $p = $request->input("p");
        $pagesize = Goods::GOODS_PAGESIZE;
        $result = $model->offset(($p - 1) * $pagesize)->limit($pagesize)->get();

        return $this->resultJson($result);
    }

}