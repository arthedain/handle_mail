<?php

namespace Arthedain\HandleMail\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class HandleMail extends Model
{
    protected $table = 'handle_mails';

    protected $fillable = [
        'page',
        'name',
        'email',
        'phone',
        'text',
        'data',
        'ip',
        'ip_info',
        'status',
        'spam',
        'history',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'data' => 'array',
        'ip_info' => 'array',
        'history' => 'array',
    ];

    public function getCountryName()
    {
        return $this->ip_info['countryName'];
    }

    public function getCityName()
    {
        return $this->ip_info['cityName'];
    }

    public function getGeo()
    {
        return $this->ip_info;
    }

    public function scopeFrom($query, $value)
    {
        if ($value) {
            return $query->where('created_at', '>=', Carbon::parse($value));
        }

        return $query;
    }

    public function scopeTo($query, $value)
    {
        if ($value) {
            return $query->where('created_at', '<=', Carbon::parse($value));
        }

        return $query;
    }

    public function scopeSearch($query, $value)
    {
        if ($value) {
            return $query->where('name', 'LIKE', '%'.$value.'%')
                ->orWhere('email', 'LIKE', '%'.$value.'%')
                ->orWhere('phone', 'LIKE', '%'.$value.'%')
                ->orWhere('page', 'LIKE', '%'.$value.'%');
        }

        return $query;
    }

    public function scopeNotSpam($query)
    {
        return $query->where('spam', 0);
    }

    public function scopeSpam($query, $value = null)
    {
        if($value) {
            return $query->where('spam', $value);
        }
        return $query;
    }
}
