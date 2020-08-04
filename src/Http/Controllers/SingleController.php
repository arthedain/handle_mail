<?php


namespace Arthedain\HandleMail\Http\Controllers;

use Arthedain\HandleMail\Jobs\HandleMailJob;
use Arthedain\HandleMail\Traits\HandleJob;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SingleController
{
    use HandleJob;

    public function single(Request $request)
    {
        $mail = app('HandleMailModel')->where('id', $request->id)->firstOrFail();

        $data = collect($mail->toArray())->except(['updated_at']);

        $data['created_at'] = Carbon::parse($mail->created_at)->toDateTimeString();

        return response()->json($data->toArray());
    }

    public function resend(Request $request){
        $mail = app('HandleMailModel')->where('id', $request->id)->firstOrFail();

        $content = collect($mail)->except(['id', 'created_at', 'updated_at', 'status', 'ip', 'data.ip_info'])->toArray();

        foreach ($content['data'] as $key => $item) {
            $content[$key] = $item;
        }
        unset($content['data']);

        $this->createJob("Request", $content, $mail->id);

        $mail->status = "process";
        $mail->save();

        return response('', 200);
    }
}
