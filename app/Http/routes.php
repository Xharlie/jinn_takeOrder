<?php
use Illuminate\Http\Request;

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
    return view('main',['userInfo' => session("flashUserInfo")]);

});

Route::get('getServiceTypes','MenuController@getServiceTypes');

Route::get('getPayMethods','MenuController@getPayMethods');

Route::get('getMenu','MenuController@getMenu');

Route::post('postOrder','MenuController@postOrder');

Route::post('postGreetings','GreetingController@postGreetings');



Route::get('getOrderHistory/{ST_TM}/{END_TM}','OrderHistoryController@getOrderHistory');
Route::post('updateStatus','OrderHistoryController@updateStatus');

// getUserInfo
Route::get('/getUserInfo', 'UserController@getUserInfo');

Route::get('/logoutAjax', ['as' => 'logoutAjax',function()
{
    return 'logout!';
}]);

Route::get('/logon', ['as' => 'logon',function()
{
//    return $request->path();
    return view('logon', ['err' => session("err")]);
}]);

Route::post('/logonPost', ['as' => 'logonPost', 'uses' => 'UserController@logonPost']);

Route::get('/logout', ['as' => 'logout',function(Request $request)
{
    $request->session()->flush();
    Auth::logout();
    return redirect('/logon');

}]);
