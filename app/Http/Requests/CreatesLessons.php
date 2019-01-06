<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'creation_type'         => ['required', 'in:new,existing'],
            'existing_lesson'       => ['required_if:creation_type,existing', 'string', Rule::notIn(
                $this->route('course')->assignedLessons()->get()->pluck('lesson_id')->toArray())
            ],
            'title'                 => ['required_if:creation_type,new'],
            'slug'                  => ['required_if:creation_type,new', 'unique:lessons,slug']
        ];
    }
}
