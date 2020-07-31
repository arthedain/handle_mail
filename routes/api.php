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
Route::get('/mails', 'Arthedain\HandleMail\Http\Controllers\ToolController@getMails');
Route::get('/chart', 'Arthedain\HandleMail\Http\Controllers\ToolController@getChartData');
Route::get('/failed_count', 'Arthedain\HandleMail\Http\Controllers\ToolController@failed');
Route::post('/delete/{id}', 'Arthedain\HandleMail\Http\Controllers\ToolController@delete');

/*
 * Single mail
 */
Route::get('/single/{id}', 'Arthedain\HandleMail\Http\Controllers\SingleController@single');

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
Route::get('/get_map_data', 'Arthedain\HandleMail\Http\Controllers\MetrikaController@getMapData');
