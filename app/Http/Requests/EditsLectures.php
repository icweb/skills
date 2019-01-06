<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditsLectures extends FormRequest
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
            'title'                 => ['required', 'string'],
            'slug'                  => ['required', 'unique:lectures,slug,' . $this->route('lecture')->id],
            'type'                  => ['required', 'string'],
            'completion_time'       => ['required', 'integer'],
            'article_body'          => ['required_if:type,Article'],
            'associated_skills_*'   => ['nullable', 'in:on'],
            'show_in_search'        => ['required', 'boolean'],
        ];
    }
}
