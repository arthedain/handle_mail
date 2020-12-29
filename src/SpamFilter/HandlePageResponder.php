<?php

namespace Arthedain\HandleMail\SpamFilter;

use Closure;
use Illuminate\Http\Request;
use Arthedain\HandleMail\Classes\DTO;
use Arthedain\HandleMail\Classes\FormDTO;
use Arthedain\HandleMail\Services\MailService;
use Spatie\Honeypot\SpamResponder\SpamResponder;

class HandlePageResponder implements SpamResponder
{
    private DTO $formDTO;

    private MailService $mailService;

    private array $except = ['_token', 'phone', 'name', 'email', 'text', 'page', 'valid_from', '/my_name_.*/'];

    public function __construct(FormDTO $formDTO, MailService $mailService)
    {
        $this->formDTO = $formDTO;
        $this->mailService = $mailService;
    }

    public function respond(Request $request, Closure $next)
    {
        $this->formDTO
            ->setPage($request->get('page'))
            ->setIp($request->ip())
            ->setName($request->get('name'))
            ->setEmail($request->get('email'))
            ->setPhone($request->get('phone'))
            ->setText($request->get('text'))
            ->setData(array_filter($request->except($this->except)))
            ->setSpam(1);

        $this->mailService->create($this->formDTO);

        return response('', 200);
    }
}
