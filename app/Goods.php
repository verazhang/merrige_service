<?php
/**
 * Created by PhpStorm.
 * User: anaqingfeng
 * Date: 2018/6/10
 * Time: 下午2:06
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class Goods extends Model
{
    const GOODS_SIZE = ['M', 'L', 'XL', '2XL', '3XL', '4XL'];
    const GOODS_IS_SOLD_NO = 'new';
    const GOODS_IS_SOLD_YES = 'sold';

    protected $table = "goods";
    protected $fillable = [
        'id',
        'usage',
        'color',
        'size',
        'code',
        'cost',
        'codehref',
        'is_sold',
        'created_at',
        'updated_at'
    ];
}