<?php

namespace Arthedain\HandleMail\Senders;

use Arthedain\HandleMail\Services\JobService;
use Arthedain\HandleMail\Services\MailService;
use Arthedain\HandleMail\Services\ConfigService;
use Arthedain\HandleMail\Services\TelegramService;
use Arthedain\HandleMail\Senders\Interfaces\Sender;

class MailSender implements Sender
{
    protected MailService $mailService;

    protected JobService $jobService;

    protected TelegramService $telegramService;

    protected ConfigService $configService;


    public function __construct(MailService $mailService,
                                JobService $jobService,
                                TelegramService $telegramService,
                                ConfigService $configService
    ) {
        $this->mailService = $mailService;
        $this->jobService = $jobService;
        $this->telegramService = $telegramService;
        $this->configService = $configService;
    }

    public function send(HandleRequest $request, string $subject = 'Request')
    {
        $content = array_filter($request->except('_token', 'valid_from', '/my_name_.*/'));

        $formDTO = $request->getDTO();

        if ($this->configService->history()) {
            $formDTO = $formDTO->setHistory($this->configService->historyClass()->get());
            $this->configService->historyClass()->clear();
        }

        $model = $this->mailService->create($formDTO);

        if ($this->configService->geoInEmail() && isset($model->ip_info)) {
            $content['geo_country'] = $model->getCountryName();
            $content['geo_city'] = $model->getCityName();
            $formDTO->setGeo($model->getGeo());
        }

        $this->jobService->create($subject, $content, $model->id);

        if ($this->configService->telegram()) {
            $this->telegramService->sendMessage($formDTO);
        }

        return response('', 200);
    }
}
