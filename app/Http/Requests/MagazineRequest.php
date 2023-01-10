<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class MagazineRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'summary' => 'required',
            'pdf' => ['nullable', 'mimes:pdf', Rule::requiredIf($this->method() == 'POST')],
            'thumbnail' => ['nullable', 'mimes:jpg,jpeg,png', Rule::requiredIf($this->method() == 'POST')],
        ];
    }
}
