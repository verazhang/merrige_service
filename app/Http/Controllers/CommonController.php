<?php
/**
 * Created by PhpStorm.
 * User: anaqingfeng
 * Date: 2018/6/10
 * Time: 下午2:17
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Common;

class CommonController extends Controller
{
    /**
     * 获取所有信息
     * @return \Illuminate\Http\JsonResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function getList()
    {
        $result = Common::get();

        return $this->resultJson($result);
    }

    /**
     * 根据ID获取
     * @param $id
     * @return \Illuminate\Http\JsonResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function get($id)
    {
        $result = Common::find($id);
        return $this->resultJson($result);
    }

    /**
     * 根据ID更新记录
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function update($id, Request $request)
    {
        $title = $request->input('title', '');
        $note = $request->input('note', '');

        $model = Common::where("id", $id);
        if ($title) {
            $model->update(["title" => $title]);
        }
        if ($note) {
            $model->update(["note" => $note]);
        }
        return $this->resultJson($model->get());
    }
}