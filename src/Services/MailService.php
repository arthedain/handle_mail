<?php

namespace Arthedain\HandleMail\Services;

use Carbon\Carbon;
use Stevebauman\Location\Location;
use Arthedain\HandleMail\Classes\DTO;
use Arthedain\HandleMail\Models\HandleMail;

class MailService
{
    protected Location $location;

    public function __construct(Location $location)
    {
        $this->location = $location;
    }

    public function create(DTO $formDTO): HandleMail
    {
        $inputs = [];
        $ip = $formDTO->getIp();

        $inputs['page'] = $formDTO->getPage();
        $inputs['name'] = $formDTO->getName();
        $inputs['email'] = $formDTO->getEmail();
        $inputs['phone'] = $formDTO->getPhone();
        $inputs['text'] = $formDTO->getText();
        $inputs['data'] = $formDTO->getData();
        $inputs['ip'] = $ip;
        $inputs['status'] = 'process';
        $inputs['ip_info'] = $this->location->get($ip);
        $inputs['spam'] = $formDTO->getSpam();
        $inputs['history'] = $formDTO->getHistory();

        return HandleMail::create($inputs);
    }

    public function delete(string $id): bool
    {
        if (HandleMail::where('id', $id)->delete()) {
            return true;
        }

        return false;
    }

    public function prepareMail(HandleMail $collection): array
    {
        $data = collect($collection->toArray())->except(['updated_at']);

        $data['created_at'] = Carbon::parse($collection->created_at)->toDateTimeString();

        return $data->toArray();
    }

    public static function updateMailStatus($event, $status)
    {
        if ($event->job->getQueue() === 'handle-mail') {
            $mail_id = unserialize($event->job->payload()['data']['command'])->id;
            \DB::table('handle_mails')->where('id', $mail_id)->update([
                'status' => $status,
            ]);
        }
    }
}
