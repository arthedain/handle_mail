<?php


namespace Arthedain\HandleMail\Http\Controllers;


use App\Models\FailedJobs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class FailedController
{
    public function get(){
        $data = FailedJobs::orderBy('id', 'desc')->paginate(20);
        return response()->json($data);
    }

    public function single(Request $request){
        $mail = FailedJobs::where('id', $request->id)->firstOrFail();
        $content = unserialize(json_decode($mail->payload)->data->command);
        $view = view('vendor.handle-mail.mail', ['subject' => $content->subject, 'content' => $content->content])->render();

        return response()->json(['mail' => $mail, 'content' => $content, 'view' => $view]);
    }

    public function retry(Request $request){
        if($request->id){
            Artisan::call('queue:retry '.$request->id);
        }
        else{
            Artisan::call('queue:retry all');
        }
        return response('', 200);
    }
}
