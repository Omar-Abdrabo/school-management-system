<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClassroomRequest extends FormRequest
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
            'list_classes.*.name' => 'required',
            'list_classes.*.name_class_en' => 'required',
            // 'grade_id' => 'required|exists:grades,id',
        ];
    }

    public function messages():array
    {
        return [
            'name.required' => trans('validation.required'),
            'name_class_en.required' => trans('validation.required'),
        ];
    }
}
