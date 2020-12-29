<?php

return [

    /*
     * Here you can write multiple emails to send mail to them
     */
    'email' => [
        //
    ],

    'view' => 'vendor.handle-mail.mail',

    'telegram' => false,

    'geo_in_email' => false,

    'history' => false,
    'history_class' => Arthedain\HandleMail\HistoryHandle\HandleMailHistory::class,
];
