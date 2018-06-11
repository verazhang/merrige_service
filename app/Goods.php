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
    const GOODS_SIZE = ['M', 'L', 'XL', 'XXL', 'XXXL'];

    protected $table = "goods";
    protected $fillable = [
        'id',
        'usage',
        'color',
        'size',
        'code',
        'cost',
        'is_sold',
        'created_at',
        'updated_at'
    ];
}