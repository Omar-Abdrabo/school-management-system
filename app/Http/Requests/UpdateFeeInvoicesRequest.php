<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFeeInvoicesRequest extends FormRequest
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

            'list_fees.*.fee_id' => 'required',
            'list_fees.*.student_id' => 'required',
            'list_fees.*.amount' => 'required',
            // 'list_fees.*.grade_id' => 'required',
            // 'list_fees.*.classroom_id' => 'required',

        ];
    }
}
