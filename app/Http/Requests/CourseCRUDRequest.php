<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Response;

class CourseCRUDRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'course_title' => 'required|min:2',
            'course_description' => 'required',
            'module.*.module_title' => 'required',
            'module.*.module_status' => 'required',
            'module.*.is_testable' => 'required',
            'module.*.module_description' => 'required',
            'module.*.material_types.*' => 'required',
            'module.*.material_links.*' => 'required',
            'module.*.course_test_title' => "required_if:module.*.is_testable,1",
            'module.*.duration' => "required_if:module.*.is_testable,1",
            'module.*.instruction' => "required_if:module.*.is_testable,1",
            'module.*.questions.*' => "required_if:module.*.is_testable,1",
            'module.*.question_statuses.*' => "required_if:module.*.is_testable,1",
            'module.*.option1.*' => "required_if:module.*.is_testable,1",
            'module.*.option2.*' => "required_if:module.*.is_testable,1",
            'module.*.option3.*' => "required_if:module.*.is_testable,1",
            'module.*.option4.*' => "required_if:module.*.is_testable,1",
            'module.*.answer.*' => "required_if:module.*.is_testable,1"
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'errors' => "You missed you some fields, please check the inputs.",
        ], 200));
    }
}
