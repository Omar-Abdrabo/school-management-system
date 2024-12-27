<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFeeRequest extends FormRequest
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
            
            'title_ar' => 'required|string',
            'title_en' => 'required|string',
            'amount' => 'required|numeric',
            'grade_id' => 'required|numeric',
            'classroom_id' => 'required|numeric',
            'year' => 'required|numeric',
            'fee_type' => 'required|string',
            // 'description' => 'required|string',
            // 'date' => 'required|date',
            // 'student_id' => 'required|numeric',
            // 'status' => 'required|string',
        ];
    }
}
