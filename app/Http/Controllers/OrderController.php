<?php
/**
 * Created by PhpStorm.
 * User: anaqingfeng
 * Date: 2018/6/9
 * Time: 下午10:32
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;

class OrderController extends Controller
{
    /**
     * 创建订单
     * @return \Illuminate\Http\JsonResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function create(Request $request)
    {
        $fields = [
            'name',
            'phone',
            'payment',
            'cost',
            'price',
            'number',
            'detail',
            'note'
        ];
        $model = new Order();
        foreach ($fields as $field) {
//            $attributes[$field] = $request->input($field);
            $model->$field = $request->input($field);
        }

//        $model->setRawAttributes($attributes);
        $result = $model->save();

        return $this->resultJson($model->getAttributes(), $result);
    }
}
