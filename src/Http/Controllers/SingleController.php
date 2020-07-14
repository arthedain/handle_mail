<?php


namespace Arthedain\HandleMail\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

class SingleController
{
    public function single(Request $request)
    {
        $mail = app('HandleMailModel')->where('id', $request->id)->firstOrFail();

        $data = collect($mail->toArray())->except(['updated_at']);

        $data['created_at'] = Carbon::parse($mail->created_at)->toDateTimeString();

        return response()->json($data->toArray());
    }
}
