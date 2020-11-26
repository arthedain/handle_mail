<?php

namespace Arthedain\HandleMail\Services;

use Telegram\Bot\Api;
use Arthedain\HandleMail\Classes\FormDTO;

class TelegramService
{
    private Api $telegram;

    public function __construct()
    {
        $this->telegram = new Api(env('TELEGRAM_BOT_TOKEN'));
    }

    public function sendMessage(FormDTO $formDTO)
    {
        $data = [];

        $data['page'] = $formDTO->getPage();
        $data['name'] = $formDTO->getName();
        $data['email'] = $formDTO->getEmail();
        $data['phone'] = $formDTO->getPhone();
        $data['text'] = $formDTO->getText();
        $data['data'] = $formDTO->getData();

        if (config('handle-mail.geo_in_email') && $formDTO->getGeo()) {
            $data['city'] = $formDTO->getGeo()['cityName'];
            $data['country'] = $formDTO->getGeo()['countryName'];
        }

        $view = $this->getView($data);

        $this->telegram
            ->setAsyncRequest(true)
            ->sendMessage(['chat_id' => '-1001238861789', 'text' => $view]);
    }

    public function getView(array $data)
    {
        return view('vendor.handle-mail.telegram.message', ['data' => $data])->render();
    }
}
