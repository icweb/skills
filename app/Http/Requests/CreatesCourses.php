<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreatesCourses extends FormRequest
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
            'demo-data'         => ['nullable'],
            'color'             => ['required', 'string'],
            'title'             => ['required', 'string'],
            'slug'              => ['required', 'unique:courses,slug'],
            'recertify_interval'=> ['required', 'integer'],
            'short_description' => ['required', 'string'],
            'long_description'  => ['required', 'string'],
        ];
    }
}
