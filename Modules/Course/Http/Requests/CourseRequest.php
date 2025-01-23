<?php

namespace Modules\Course\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CourseRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function onCreate()
    {

        $rules['course_name'] = ['required', 'string'];
        $rules['price'] = ['required', 'numeric', 'min:0'];
        $rules['university_id'] = ['required', 'not_in:0'];
        $rules['type_id'] = ['required', 'not_in:0'];
        $rules['link_title'] = ['array', 'min:1'];
        $rules['link_title.*'] = ['string', 'distinct', 'max:255'];

        $rules['link'] = ['required', 'array', 'min:1'];
        $rules['link.*'] = ['required', 'string', 'distinct'];

        $rules['user_id'] = ['required', 'array', 'min:1'];

        return $rules;
    }

    public function onUpdate()
    {
        $rules['course_name'] = ['required', 'string'];
        $rules['price'] = ['required', 'numeric', 'min:0'];
        $rules['university_id'] = ['required', 'not_in:0'];
        $rules['type_id'] = ['required', 'not_in:0'];
        $rules['link_title'] = ['array', 'min:1'];
        $rules['link_title.*'] = ['string', 'distinct', 'max:255'];

        $rules['link'] = ['required', 'array', 'min:1'];
        $rules['link.*'] = ['required', 'string', 'distinct'];

        $rules['user_id'] = ['required', 'array', 'min:1'];

        return $rules;
    }

    public function rules()
    {
        return $this->isMethod('put') ? $this->onUpdate() : $this->onCreate();
    }

    public function messages()
    {
        $messages = [];
        if ($this->isMethod('post')) {
            foreach ($this->get('link') as $key => $value) {

                $messages['link.required'] = 'link number ' . $key + 1 . 'is required';
            }
        }
        return $messages;
    }

    public function attributes()
    {
        $attributes = [
            'course_name' => 'Course Name',
            'price' => 'Course Price',
            'university_id' => 'University',
            'type_id' => 'Course Class',
            'link_title' => 'Video Title',
            'link' => 'Link',
            'user_id' => 'Users',
        ];

        return $attributes;
    }
}
