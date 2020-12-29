<?php

namespace Arthedain\HandleMail\Senders;

use Arthedain\HandleMail\Classes\DTO;
use Arthedain\HandleMail\Classes\FormDTO;
use Illuminate\Foundation\Http\FormRequest;

class HandleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'page' => 'required',
        ];
    }

    public function getDTO(): DTO
    {
        return (new FormDTO())
            ->setPage($this->get('page'))
            ->setIp($this->ip())
            ->setName($this->get('name'))
            ->setEmail($this->get('email'))
            ->setPhone($this->get('phone'))
            ->setText($this->get('text'))
            ->setData(array_filter($this->except(['_token', 'phone', 'name', 'email', 'text', 'page', 'valid_from', '/my_name_.*/'])));
    }
}
