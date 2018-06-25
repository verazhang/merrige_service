<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

/** 订单 */
$router->post('order/create', 'OrderController@create');

/** 商品 */
$router->post('goods/create', 'GoodsController@create');
$router->get('goods/summary', 'GoodsController@getSummary');
$router->get('goods/getucs', 'GoodsController@getUCS');
$router->post('goods/upload', 'GoodsController@upload');
$router->get('goods/test', 'GoodsController@test');
$router->get('goods/image', 'GoodsController@image');

/** 常用语  */
$router->get('common/list', 'CommonController@getList');
$router->get('common/get/{id}', 'CommonController@get');
$router->post('common/update/{id}', 'CommonController@update');