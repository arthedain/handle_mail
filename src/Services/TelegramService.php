<?php

namespace Arthedain\HandleMail\Services;

use Telegram\Bot\Api;
use Arthedain\HandleMail\Classes\DTO;

class TelegramService
{
    private Api $telegram;
    private string $chat_id;
    protected ConfigService $configService;

    public function __construct(ConfigService $configService)
    {
        $this->configService = $configService;
        $this->telegram = new Api(env('TELEGRAM_BOT_TOKEN'));
        $this->chat_id = env('TELEGRAM_CHAT_ID');
    }

    public function sendMessage(DTO $formDTO)
    {
        $data = [];

        $data['page'] = $formDTO->getPage();
        $data['name'] = $formDTO->getName();
        $data['email'] = $formDTO->getEmail();
        $data['phone'] = $formDTO->getPhone();
        $data['text'] = $formDTO->getText();
        $data['data'] = $formDTO->getData();

        if ($this->configService->geoInEmail() && $formDTO->getGeo()) {
            $data['city'] = $formDTO->getGeo()['cityName'];
            $data['country'] = $formDTO->getGeo()['countryName'];
        }

        $view = $this->getView($data);

        $this->telegram
            ->setAsyncRequest(true)
            ->sendMessage(['chat_id' => $this->chat_id, 'text' => $view]);
    }

    public function getView(array $data)
    {
        return view('vendor.handle-mail.telegram.message', ['data' => $data])->render();
    }
}
