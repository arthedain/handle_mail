<?php


namespace Arthedain\HandleMail\Http\Controllers;

use App\Models\HandleMail;

class TableController
{
    public function getMails(){
        $mail = HandleMail::orderBy('id', 'desc')->paginate(20);
        return response()->json($mail->toArray());
    }
}
