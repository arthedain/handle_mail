<?php


namespace Arthedain\HandleMail\Http\Controllers;


use App\Models\HandleMail;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SingleController
{
    public function single(Request $request)
    {
        $mail = HandleMail::where('id', $request->id)->firstOrFail();
        $data = collect($mail->toArray())->except(['updated_at']);

        $data['created_at'] = Carbon::parse($data['created_at'])->toDateTimeString();

        return response()->json($data->toArray());
    }
}
