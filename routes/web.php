<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'handle-mail'], function () {
    Route::post('/send', 'Arthedain\HandleMail\Senders\MailSender@send')->name('handle-mail.send');
});
