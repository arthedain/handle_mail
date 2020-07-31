<?php

namespace Arthedain\HandleMail\Http\Controllers\User;

use Arthedain\HandleMail\Jobs\HandleMailJob;
use Illuminate\Http\Request;
use Stevebauman\Location\Location;

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

        $job = config('handle-mail.job', HandleMailJob::class);

        $emails = config('handle-mail.email', ['admin@mail.com']);

        foreach($emails as $email) {
            (new $job($subject, $content, $email, $model->id))->dispatch($subject, $content, $email, $model->id)->onQueue('handle-mail');
        }

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

        if(!isset($inputs['page'])){
            $inputs['page'] = explode('?', url()->previous())[0];
        }

        if(empty($data)){
            $data = null;
        }

        $ip = $request->ip();

        $data['ip_info'] = (new Location())->get($ip);

        $inputs['data'] = $data;
        $inputs['ip'] = $ip;
        $inputs['status'] = 'process';

        $model = app('HandleMailModel')->create($inputs);

        return $model;
    }
}
