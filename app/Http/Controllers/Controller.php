<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    const STATUS_SUCCESS = 1;
    const STATUS_FAIL = 0;
    /**
     * result serialize
     * @param int $success sucess or fail
     * @param string $data
     * @param string $message fail message or explain
     * @param array $extra
     * @return \Illuminate\Http\JsonResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function resultJson($data = '', $success = self::STATUS_SUCCESS, $message = '', $extra = [])
    {
        $source = ['success' => $success, 'msg' => $message, 'data' => $data];
        return response()->json(array_merge($source, $extra));
    }

    /**
     * result is bool, return 1 or 0 for resultJson
     * @param $result true or false
     * @return \Illuminate\Http\JsonResponse|\Symfony\Component\HttpFoundation\Response
     */
    protected function getBoolResult($result)
    {
        return $this->resultJson('', $result ? self::STATUS_SUCCESS : self::STATUS_FAIL);
    }
}
