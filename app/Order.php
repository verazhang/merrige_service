<?php
/**
 * Created by PhpStorm.
 * User: anaqingfeng
 * Date: 2018/6/9
 * Time: 下午11:39
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = "order";
    protected $fillable = [
        'id',
        'name',
        'phone',
        'payment',
        'cost',
        'price',
        'number',
        'detail',
        'note',
        'created_at',
        'updated_at'
    ];
}