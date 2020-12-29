<?php

namespace Arthedain\HandleMail\Senders\Interfaces;


use Arthedain\HandleMail\Senders\HandleRequest;

interface Sender
{
    public function send(HandleRequest $request);
}
