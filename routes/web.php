<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'handle-mail'], function(){
    Route::post('/send', 'Arthedain\HandleMail\Http\Controllers\User\HandleMailController@post')->name('handle-mail.send');
});

