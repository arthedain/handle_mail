<?php

namespace Arthedain\HandleMail\Http\Requests;

use Arthedain\HandleMail\Classes\FormDTO;
use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
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

    public function getDTO()
    {
        return new FormDTO(
            $this->page,
            $this->ip(),
            $this->name,
            $this->email,
            $this->phone,
            $this->text,
            array_filter($this->except(['_token', 'phone', 'name', 'email', 'text', 'page']))
        );
    }
}
