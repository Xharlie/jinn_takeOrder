<?php


Blade::setContentTags('<%', '%>');
Blade::setEscapedContentTags('<%%','%%>');
Blade::setRawTags('<%%%', '%%%>');

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('main');
});

Route::get('getServiceTypes','MenuController@getServiceTypes');

Route::get('getPayMethods','MenuController@getPayMethods');

Route::get('getMenu/{id}','MenuController@getMenu');

Route::post('postOrder','MenuController@postOrder');



Route::get('getOrderHistory/{HTL_ID}/{ST_TM}/{END_TM}','OrderHistoryController@getOrderHistory');
Route::post('updateStatus','OrderHistoryController@updateStatus');
//Route::get('history','OrderHistoryController');
