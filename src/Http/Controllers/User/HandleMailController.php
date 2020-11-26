<?php

namespace Arthedain\HandleMail\Http\Controllers\User;

use Illuminate\Http\Request;
use Arthedain\HandleMail\Classes\FormDTO;
use Arthedain\HandleMail\Services\JobService;
use Arthedain\HandleMail\Services\MailService;
use Arthedain\HandleMail\Services\TelegramService;

class HandleMailController
{
    protected MailService $mailService;

    protected JobService $jobService;

    protected FormDTO $formDTO;

    protected TelegramService $telegramService;

    public function __construct(MailService $mailService, JobService $jobService, FormDTO $formDTO, TelegramService $telegramService)
    {
        $this->mailService = $mailService;
        $this->jobService = $jobService;
        $this->formDTO = $formDTO;
        $this->telegramService = $telegramService;
    }

    /**
     * @param Request $request
     * @param string  $subject
     *
     * @return \Illuminate\Http\Response
     */
    public function post(Request $request, string $subject = 'Request')
    {
        $content = array_filter($request->except('_token'));

        $this->formDTO
            ->setPage($request->get('page'))
            ->setIp($request->ip())
            ->setIp('42.216.163.231')
            ->setName($request->get('name'))
            ->setEmail($request->get('email'))
            ->setPhone($request->get('phone'))
            ->setText($request->get('text'))
            ->setData(array_filter($request->except(['_token', 'phone', 'name', 'email', 'text', 'page'])));

        $model = $this->mailService->create($this->formDTO);

        if (config('handle-mail.geo_in_email') && isset($model->data['ip_info'])) {
            $content['geo_country'] = $model->getCountryName();
            $content['geo_city'] = $model->getCityName();
            $this->formDTO->setGeo($model->getGeo());
        }

        $this->jobService->create($subject, $content, $model->id);

        if (config('handle-mail.telegram')) {
            $this->telegramService->sendMessage($this->formDTO);
        }

        return response('', 200);
    }
}
