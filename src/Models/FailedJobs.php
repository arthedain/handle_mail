<?php

namespace Arthedain\HandleMail\Models;

use Illuminate\Database\Eloquent\Model;

class FailedJobs extends Model
{
    protected $table = 'failed_jobs';
    protected $casts = [
        'failed_at' => 'datetime:Y-m-d'
    ];
}
