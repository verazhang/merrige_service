<?php
/**
 * Created by PhpStorm.
 * User: anaqingfeng
 * Date: 2018/6/10
 * Time: 下午2:16
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class Common extends Model
{
    protected $table = "common";
    protected $fillable = [
        'id',
        'title',
        'note',
        'created_at',
        'updated_at'
    ];
}