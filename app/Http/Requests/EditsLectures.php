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
            'title'                     => ['required', 'string'],
            'slug'                      => ['required', 'unique:lectures,slug,' . $this->route('lecture')->id],
            'type'                      => ['required', 'string'],
            'completion_time'           => ['required', 'integer'],
            'article_body'              => ['required', 'string'],
            'associated_skills_*'       => ['nullable', 'in:on'],
            'show_in_search'            => ['required', 'boolean'],
            'allow_print'               => ['required', 'boolean'],
            'show_certified_users'      => ['required', 'boolean'],
            'show_completion_history'   => ['required', 'boolean'],
            'quiz_show_answers'         => ['required_if:type,Quiz', 'boolean'],
            'quiz_show_score'           => ['required_if:type,Quiz', 'boolean'],
            'quiz_pass_to_complete'     => ['required_if:type,Quiz', 'boolean'],
            'quiz_required_score'       => ['required_if:type,Quiz'],
        ];
    }
}
