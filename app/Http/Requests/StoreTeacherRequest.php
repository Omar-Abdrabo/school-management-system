<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTeacherRequest extends FormRequest
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
            'email' => 'required|email|unique:teachers,email',
            'password' => 'required|min:8',
            'name_ar' => 'required|string',
            'name_en' => 'required|string',
            'specialization_id' => 'required|exists:specializations,id',
            'gender_id' => 'required|exists:genders,id',
            'joining_date' => 'required|date',
            'address' => 'required|string',
        ];
    }
}
