<?php


namespace Arthedain\HandleMail\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class FailedController
{
    public function get(){
        $data = app('FailedJobsModel')->orderBy('id', 'desc')->where('queue', 'handle-mail')->paginate(20);
        return response()->json($data);
    }

    public function single(Request $request){
        $mail = app('FailedJobsModel')->where('id', $request->id)->firstOrFail();
        $content = unserialize(json_decode($mail->payload)->data->command);

        $view = view('vendor.handle-mail.mail', ['subject' => $content->subject, 'content' => $content->content])->render();

        return response()->json(['mail' => $mail, 'content' => $content, 'view' => $view]);
    }

    public function retry(Request $request){
        if($request->id){
            $job = app('FailedJobsModel')->where('id', $request->id)->first();
            $id = unserialize(json_decode($job->payload)->data->command)->id;
            app('HandleMailModel')->where('id', $id)->update([
                'status' => 'process'
            ]);
            Artisan::call('queue:retry '.$request->id);
        }
        else{
            $job = app('FailedJobsModel')->all();
            $keys = [];

            foreach ($job as $item){
                array_push($keys, unserialize(json_decode($item->payload)->data->command)->id);
            }

            app('HandleMailModel')->whereIn('id', $keys)->update([
                'status' => 'process'
            ]);

            Artisan::call('queue:retry all');
        }
        return response('', 200);
    }

    public function delete(Request $request){
        app('FailedJobsModel')->where('id', $request->id)->delete();
        return response('', 200);
    }
}
