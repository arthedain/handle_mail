<?php

namespace Arthedain\HandleMail\Services;

use Illuminate\Support\Facades\Artisan;

class ArtisanService
{
    public function queueRetry(string $id = null): void
    {
        if ($id) {
            Artisan::call("queue:retry {$id}");
        } else {
            Artisan::call('queue:retry all');
        }
    }
}
