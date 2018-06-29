<?php
/**
 * Created by PhpStorm.
 * User: anaqingfeng
 * Date: 2018/6/29
 * Time: 下午5:13
 */

namespace App\Http\Controllers;

use App\Goods;
use App\Order;

class ReportController extends Controller
{
    public function getGoods()
    {
        $goodModel = new Goods();
        $totalGoods = $goodModel->count();
        $totalCost = $goodModel->sum("cost");
        $totalByColor = $goodModel->selectRaw("color, count(1) total")->groupBy("color")->get();
        $totalByUsage = $goodModel->selectRaw("`usage`, count(1) total")->groupBy("usage")->get();
        $totalBySize = $goodModel->selectRaw("`size`, count(1) total")->groupBy("size")->get();

        return $this->resultJson([
            "total_goods" => $totalGoods,
            "total_cost" => $totalCost,
            "total_by_color" => $totalByColor,
            "total_by_usage" => $totalByUsage,
            "total_by_size" => $totalBySize,
        ]);
    }

    public function getOrder()
    {
        $orderModel = new Order();
        $totalOrder = $orderModel->count();
        $totalCost = $orderModel->sum("cost");
        $totalPrice = $orderModel->sum("price");

        return $this->resultJson([
            "total_order" => $totalOrder,
            "total_cost" => $totalCost,
            "total_price" => $totalPrice,
            "total_income" => sprintf("%.2f", $totalPrice - $totalCost)
        ]);
    }
}