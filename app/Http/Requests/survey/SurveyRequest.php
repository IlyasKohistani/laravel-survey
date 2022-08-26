<?php

namespace App\Http\Requests\survey;

use Illuminate\Foundation\Http\FormRequest;

class SurveyRequest extends FormRequest
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
        return
            [
                'answers' => ['required', 'array', 'min:1'],
                'answers.*.answers' => ['required', 'array', 'min:9'],
                'answers.*.answers.*.category_id' => ['required'],
                'answers.*.answers.*.answer' => ['required']
            ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'answers.*.answers.required'    => 'You should complete all survey questions.',
            'answers.*.answers.min'    => 'You should complete all survey questions.',
            'answers.*.answers.*.category_id.required'      => 'You should complete all survey questions.',
            'answers.*.answers.*.answer.required' => 'You should complete all survey questions.',
        ];
    }
}
