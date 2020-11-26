<?php

namespace Arthedain\HandleMail\Http\Controllers;

use Arthedain\HandleMail\Models\HandleMail;
use Arthedain\HandleMail\Services\MailService;
use Illuminate\Http\Request;

class SingleController
{
    protected MailService $mailService;

    public function __construct(MailService $mailService)
    {
        $this->mailService = $mailService;
    }

    public function single(string $id)
    {
        $mail = HandleMail::where('id', $id)->firstOrFail();

        $data = $this->mailService->prepareMail($mail);

        return response()->json($data);
    }

    public function resend(Request $request, string $id)
    {
        dd($request->all());
        $mail = HandleMail::where('id', $id)->firstOrFail();
        dd($mail);
        $content = collect($mail)->except(['id', 'created_at', 'updated_at', 'status', 'ip', 'data.ip_info'])->toArray();

        foreach ($content['data'] as $key => $item) {
            $content[$key] = $item;
        }
        unset($content['data']);

        $this->createJob('Request', $content, $mail->id);

        $mail->status = 'process';
        $mail->save();

        return response('', 200);
    }
}
