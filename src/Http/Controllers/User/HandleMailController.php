<?php

namespace Arthedain\HandleMail\Http\Controllers\User;

use Arthedain\HandleMail\Jobs\HandleMailJob;
use Illuminate\Http\Request;

class HandleMailController
{
    /**
     * @param Request $request
     * @param string $subject
     * @param null $callback
     * @return \Illuminate\Http\Response
     */
    public function post(Request $request, string $subject = 'Request', $callback = null){
        $content = array_filter($request->except('_token'));

        $model = $this->saveToDB($request);

        $job = config('handle_mail.job', HandleMailJob::class);

        (new $job($subject, $content, $model->id))->dispatch($subject, $content, $model->id)->onQueue('handle-mail');

        if($callback){
            $callback();
        }

        return response('', 200);
    }


    /**
     * @param Request $request
     * @return mixed
     */
    public function saveToDB(Request $request){
        $inputs = array_filter($request->only(['phone', 'name', 'email', 'text', 'page']));
        $data = array_filter($request->except(['_token', 'phone', 'name', 'email', 'text', 'page']));

        if(empty($data)){
            $data = null;
        }

        $inputs['data'] = $data;
        $inputs['ip'] = $request->ip();
        $inputs['status'] = 'process';

        $model = app('HandleMailModel')->create($inputs);

        return $model;
    }
}
