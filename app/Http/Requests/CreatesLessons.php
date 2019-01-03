<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreatesLessons extends FormRequest
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
            'creation'              => ['required', 'in:new,existing'],
            'existing_lesson'       => ['required_if:creation,existing', 'string'],
            'title'                 => ['required_if:creation,new'],
            'slug'                  => ['required_if:creation,new', 'unique:lessons,slug'],
            'associated_skills_*'   => ['nullable', 'in:on'],
        ];
    }
}
