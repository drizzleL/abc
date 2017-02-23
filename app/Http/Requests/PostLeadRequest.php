<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostLeadRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'contact_mobile' => 'required',
            'company_name' => 'required',
            'contact_title' => 'required',
            'contact_email' => 'required',
            'contact_name' => 'required',
            'is_secret' => 'required',
        ];
    }
}
