<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreatesLectures extends FormRequest
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
            'creation_type'             => ['required', 'in:new,existing'],
            'existing_lecture'          => ['required_if:creation_type,existing'],
            'title'                     => ['required_if:creation_type,new'],
            'slug'                      => ['required_if:creation_type,new', 'unique:lectures,slug'],
            'type'                      => ['required_if:creation_type,new'],
            'completion_time'           => ['required_if:creation_type,new'],
            'associated_skills_*'       => ['nullable', 'in:on'],
            'show_in_search'            => ['required', 'boolean'],
            'allow_print'               => ['required', 'boolean'],
            'show_certified_users'      => ['required', 'boolean'],
            'show_completion_history'   => ['required', 'boolean'],
            'quiz_show_answers'         => ['required_if:type,Quiz', 'boolean'],
            'quiz_show_score'           => ['required_if:type,Quiz', 'boolean'],
        ];
    }
}
