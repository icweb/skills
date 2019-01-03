<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class EditsCourses extends FormRequest
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
            'title'             => ['required', 'string'],
            'slug'              => ['required', 'unique:courses,slug,' . $this->route('course')->id],
            'recertify_interval'=> ['required', 'integer'],
            'short_description' => ['required', 'string'],
            'long_description'  => ['required', 'string'],
        ];
    }
}
