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
        $attributes = $request->input('goods');
        $model = new Goods();
        $result = $model->save($attributes);

        return $this->resultJson($model->getAttributes(), $result);
    }

    /**
     * 获取商品概要信息
     * @return \Illuminate\Http\JsonResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function getSummary()
    {
//        $model = new Goods();
        return $this->resultJson([]);
    }

}