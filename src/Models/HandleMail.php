<?php

namespace Arthedain\HandleMail\Models;

use Illuminate\Database\Eloquent\Model;

class HandleMail extends Model
{
    protected $table = 'handle_mails';
    protected $fillable = ['page', 'name', 'email', 'phone', 'text', 'data', 'ip', 'status', 'created_at', 'updated_at'];
    protected $casts = [
        'data' => 'array'
    ];
}
