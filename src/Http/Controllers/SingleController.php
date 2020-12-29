<?php

namespace Arthedain\HandleMail\Http\Controllers;

use Illuminate\Http\Request;
use Arthedain\HandleMail\Models\HandleMail;
use Arthedain\HandleMail\Services\MailService;
use Arthedain\HandleMail\Services\ConfigService;
use Arthedain\HandleMail\Repositories\HandleMailRepository;

class SingleController
{
    protected MailService $mailService;

    protected HandleMailRepository $handleMailRepository;

    protected ConfigService $configService;

    public function __construct(MailService $mailService,
                                HandleMailRepository $handleMailRepository,
                                ConfigService $configService)
    {
        $this->mailService = $mailService;
        $this->handleMailRepository = $handleMailRepository;
        $this->configService = $configService;
    }

    public function single(Request $request)
    {
        $mail = $this->handleMailRepository->getById($request->id);

        $data = $this->mailService->prepareMail($mail);

        return response()->json([
            'mail' => $data,
        ]);
    }

//    public function view(Request $request)
//    {
//        $content = $request->all();
//
//        $view = view($this->configService->view(), ['subject' => 'Request', 'content' => $content])->render();
//
//        return response()->json([
//            'view' => $view,
//        ]);
//    }

//    public function resend(Request $request, string $id)
//    {
//        dd($request->all());
//        $mail = HandleMail::where('id', $id)->firstOrFail();
//        dd($mail);
//        $content = collect($mail)->except(['id', 'created_at', 'updated_at', 'status', 'ip', 'data.ip_info'])->toArray();
//
//        foreach ($content['data'] as $key => $item) {
//            $content[$key] = $item;
//        }
//        unset($content['data']);
//
//        $this->createJob('Request', $content, $mail->id);
//
//        $mail->status = 'process';
//        $mail->save();
//
//        return response('', 200);
//    }
}
