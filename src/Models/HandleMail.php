<?php

namespace Arthedain\HandleMail\Models;

use Illuminate\Database\Eloquent\Model;

class HandleMail extends Model
{
    protected $table = 'handle_mails';

    protected $fillable = ['page', 'name', 'email', 'phone', 'text', 'data', 'ip', 'status', 'created_at', 'updated_at'];

    protected $casts = [
        'data' => 'array',
    ];

    public function getCountryName()
    {
        return $this->data['ip_info']['countryName'];
    }

    public function getCityName()
    {
        return $this->data['ip_info']['cityName'];
    }

    public function getGeo()
    {
        return $this->data['ip_info'];
    }

    public function scopeFrom($query, $value)
    {
        return $query->where('created_at', '>=', $value);
    }

    public function scopeTo($query, $value)
    {
        return $query->where('created_at', '<=', $value);
    }

    public function scopeSearch($query, $value)
    {
        return $query->where('name', 'LIKE', '%'.$value.'%')
            ->orWhere('email', 'LIKE', '%'.$value.'%')
            ->orWhere('phone', 'LIKE', '%'.$value.'%')
            ->orWhere('page', 'LIKE', '%'.$value.'%');
    }

}
