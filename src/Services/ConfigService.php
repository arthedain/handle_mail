<?php

namespace Arthedain\HandleMail\Services;

use Arthedain\HandleMail\HistoryHandle\Interfaces\History;

class ConfigService
{
    public function telegram(): bool
    {
        return config('handle-mail.telegram', false);
    }

    public function history(): bool
    {
        return config('handle-mail.history', false);
    }

    public function geoInEmail(): bool
    {
        return config('handle-mail.geo_in_email', false);
    }

    public function view(): string
    {
        return config('handle-mail.view', 'vendor.handle-mail.mail');
    }

    public function email(): array
    {
        return config('handle-mail.email', []);
    }

    public function historyClass(): History
    {
        $class = config('handle-mail.history_class', '\Arthedain\HandleMail\HistoryHandle\HandleMailHistory');

        return new $class;
    }
}
