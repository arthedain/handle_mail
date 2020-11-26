<?php

namespace Arthedain\HandleMail\Http\Controllers;

use Illuminate\Http\Request;
use Arthedain\HandleMail\Models\FailedJobs;
use Arthedain\HandleMail\Services\JobService;

class FailedController
{
    protected JobService $jobService;

    public function __construct(JobService $jobService)
    {
        $this->jobService = $jobService;
    }

    public function get()
    {
        $data = FailedJobs::orderBy('id', 'desc')->where('queue', 'handle-mail')->paginate(20);

        return response()->json($data);
    }

    public function single(string $id)
    {
        $mail = FailedJobs::where('id', $id)->firstOrFail();

        $content = $mail->getCommandAttribute();

        $view = $content->view ?? config('handle-mail.view', 'vendor.handle-mail.mail');

        $view = view($view, ['subject' => $content->subject, 'content' => $content->content])->render();

        return response()->json(['mail' => $mail, 'content' => $content, 'view' => $view]);
    }

    public function retry(Request $request)
    {
        if ($request->get('id')) {
            $this->jobService->retryJob($request->get('id'));
        } else {
            $this->jobService->retryAllJob();
        }

        return response('', 200);
    }

    public function delete(string $id)
    {
        if ($this->jobService->delete($id)) {
            return response('', 200);
        }

        return response('', 500);
    }
}
