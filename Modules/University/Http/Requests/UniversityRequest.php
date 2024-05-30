<?php

namespace Modules\University\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UniversityRequest extends FormRequest
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
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws HttpResponseException
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors()->first(), 400));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        $rules['logo'] = $this->isMethod('post') ? ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'] : ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'];
        $rules['name'] = ['required', 'string', 'max:255'];

        return $rules;
    }

    public function attributes()
    {
        $attributes = [
            'name' => 'University Name',
            'logo' => 'University Logo',
        ];

        return $attributes;
    }
}