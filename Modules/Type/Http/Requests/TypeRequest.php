<?php

namespace Modules\Type\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class TypeRequest extends FormRequest
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

        $rules['name'] = ['required', 'string', 'max:255'];
        $rules['faculty'] = ['nullable', 'string', 'max:255'];
        $rules['university_id'] = ['required', 'not_in:0', 'exists:universities,id'];

        return $rules;
    }

    public function attributes()
    {
        $attributes = [
            'name' => 'Level Name',
            'faculty' => 'Faculty Name',
            'university_id' => 'University',
        ];

        return $attributes;
    }
}
