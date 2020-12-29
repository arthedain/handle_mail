<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Tool API Routes
|--------------------------------------------------------------------------
|
| Here is where you may register API routes for your tool. These routes
| are loaded by the ServiceProvider of your tool. They are protected
| by your tool's "Authorize" middleware by default. Now, go build!
|
*/

// Route::get('/endpoint', function (Request $request) {
//     //
// });

/*
 * Tool
 */
Route::get('/mails', 'Arthedain\HandleMail\Http\Controllers\IndexController@getMails');
Route::get('/chart', 'Arthedain\HandleMail\Http\Controllers\IndexController@getChartData');
Route::get('/failed_count', 'Arthedain\HandleMail\Http\Controllers\IndexController@failed');
Route::post('/delete/{id}', 'Arthedain\HandleMail\Http\Controllers\IndexController@delete');

/*
 * Single mail
 */
Route::get('/single/{id}', 'Arthedain\HandleMail\Http\Controllers\SingleController@single');
Route::get('/view/single', 'Arthedain\HandleMail\Http\Controllers\SingleController@view');
Route::post('/resend/{id}', 'Arthedain\HandleMail\Http\Controllers\SingleController@resend');

/*
 * Failed
 */
Route::get('/failed_list', 'Arthedain\HandleMail\Http\Controllers\FailedController@get');
Route::get('/failed_single/{id}', 'Arthedain\HandleMail\Http\Controllers\FailedController@single');
Route::post('/resend_mail/{id?}', 'Arthedain\HandleMail\Http\Controllers\FailedController@retry');
Route::post('/delete_failed/{id}', 'Arthedain\HandleMail\Http\Controllers\FailedController@delete');

/*
 * Metrika
 */
Route::get('/get_map_data', 'Arthedain\HandleMail\Http\Controllers\MetrikaController@getByDate');
Route::get('/metrika/get_all', 'Arthedain\HandleMail\Http\Controllers\MetrikaController@getAll');
Route::get('/metrika/get_spam', 'Arthedain\HandleMail\Http\Controllers\MetrikaController@getSpam');

Route::get('/metrika/users/{ip}', 'Arthedain\HandleMail\Http\Controllers\MetrikaController@getUser');
