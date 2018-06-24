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

use App\AipOcr;

class GoodsController extends Controller
{
    // 你的 APPID AK SK
    const APP_ID = '11436299';
    const API_KEY = '2xZHYPsT5uZhPxi0GKFLo6OR';
    const SECRET_KEY = 'MM9NNAu7GAmeVDZIlkmdcvFr8UfxF8UW';

    public function getUCS()
    {
        $client = new AipOcr(self::APP_ID, self::API_KEY, self::SECRET_KEY);
//        $url = "http://img0.bdstatic.com/static/searchresult/img/logo-2X_b99594a.png";
// 如果有可选参数
        $options = array();
        $options["language_type"] = "CHN_ENG";
        $options["detect_direction"] = "true";
        $options["detect_language"] = "true";
        $options["probability"] = "true";

// 带参数调用通用文字识别, 图片参数为远程url图片
//        $res = $client->basicGeneralUrl($url);

        $image = file_get_contents(storage_path('app/mmexport.jpg'));
        $res = $client->basicGeneral($image);
//        return $this->resultJson($res);
//    $res['words_result'] = [
//        ["words"=> "品牌: MERRIGE"],
//        ["words"=> "晶名:科技塑身纤体衣"],
//        ["words"=> "羡计微线"],
//        ["words"=> "负号:0087#"],
//        ["words"=> "颜色:凝脂肤色"],
//        ["words"=> "尺码:2XL"],
//        ["words"=> "手机扫码辨百伪"],
//        ["words"=> "物滴码:809413162811"],
//        ["words"=> "市场指导价:￥￥1688RMB"],
//        ["words"=> "排排排排体"]
//    ];
        $init = [];
        foreach ($res['words_result'] as $i => $item) {
            switch ($i) {
                case 1:
                    $words = explode(":", $item['words']);
                    $init['usage'] = $words[1];
                    break;
                case 4:
                    $words = explode(":", $item['words']);
                    $init['color'] = $words[1];
                    break;
                case 5:
                    $words = explode(":", $item['words']);
                    $init['size'] = $words[1];
                    break;
            }
//            if (($pos = strpos($item['words'], "品名:")) !== false)  {
//                $words = explode(":", $item['words']);
//                $init['usage'] = $words[1];
//            }
//            if (($pos = strpos($item['words'], "颜色:")) !== false)  {
//                $words = explode(":", $item['words']);
//                $init['color'] = $words[1];
//            }
//            if (($pos = strpos($item['words'], "尺码:")) !== false)  {
//                $words = explode(":", $item['words']);
//                $init['size'] = $words[1];
//            }
        }


        return $this->resultJson($init);
    }

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
            if ($attributes[$field]) {
                $model->where($field, $attributes[$field]);
            }
        }
        $p = $request->input("p");
        $pagesize = Goods::GOODS_PAGESIZE;
        $result = $model->offset(($p - 1) * $pagesize)->limit($pagesize)->get();

        return $this->resultJson($result);
    }

}