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

    public function getUCS(Request $request)
    {
        $client = new AipOcr(self::APP_ID, self::API_KEY, self::SECRET_KEY);

        $filename = $request->input("name");
        $image = file_get_contents(storage_path()."/app/".$filename);
        //可选参数
        $options = array();
        $options["language_type"] = "CHN_ENG";
        $options["detect_direction"] = "true";
        $options["detect_language"] = "true";
        $options["probability"] = "true";

        // 带参数调用通用文字识别, 图片参数为本地图片
        $res = $client->basicGeneral($image);

        return $this->resultJson($res);
        
        if (!$res["words_result"]) {
            return $this->resultJson($res);
        }
        $init = [];
        foreach ($res['words_result'] as $i => $item) {
//            switch ($i) {
//                case 1:
//                    $words = explode(":", $item['words']);
//                    $init['usage'] = $words[1];
//                    break;
//                case 4:
//                    $words = explode(":", $item['words']);
//                    $init['color'] = $words[1];
//                    break;
//                case 5:
//                    $words = explode(":", $item['words']);
//                    $init['size'] = $words[1];
//                    break;
//            }
            if (($pos = strpos($item['words'], "品名:")) !== false)  {
                $words = explode(":", $item['words']);
                $init['usage'] = $words[1];
            }
            if (($pos = strpos($item['words'], "颜色:")) !== false)  {
                $words = explode(":", $item['words']);
                $init['color'] = $words[1];
            }
            if (($pos = strpos($item['words'], "尺码:")) !== false)  {
                $words = explode(":", $item['words']);
                $init['size'] = $words[1];
            }
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

    /**
     * 格式化size显示
     */
    protected function formatSize($b, $times=0)
    {
        if ($b > 1024) {
            $temp = $b / 1024;
            return $this->formatSize($temp, $times + 1);
        } else {
            $unit = 'B';
            switch ($times) {
                case '0':
                    $unit = 'B';
                    break;
                case '1':
                    $unit = 'KB';
                    break;
                case '2':
                    $unit = 'MB';
                    break;
                case '3':
                    $unit = 'GB';
                    break;
                case '4':
                    $unit = 'TB';
                    break;
                case '5':
                    $unit = 'PB';
                    break;
                case '6':
                    $unit = 'EB';
                    break;
                case '7':
                    $unit = 'ZB';
                    break;
                default:
                    $unit = '单位未知';
            }
            return sprintf('%.2f', $b) . $unit;
        }
    }

    public function upload(Request $request)
    {
        $destinationPath = storage_path()."/app";
        $file = $request->file('file');
        if (!$file->isValid()) {
            return $this->resultJson('', Controller::STATUS_FAIL, "无效文件");
        }
        if ($file->getMaxFilesize() < $file->getClientSize()) {
            return $this->resultJson('', Controller::STATUS_FAIL, '允许上传文件最大为'.$this->formatSize($file->getMaxFilesize()));
        }
        $filename = $file->getClientOriginalName();
        $file->move($destinationPath, $filename);
        echo $filename;
        exit;
    }
}