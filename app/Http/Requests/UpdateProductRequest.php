<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class UpdateProductRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'description' => 'required|string',
            'prices' => 'required|array',
            'prices.*' => 'required|numeric',
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param \Illuminate\Contracts\Validation\Validator $validator
     */
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => 'Validation errors',
            'data'      => $validator->errors()
        ]));

    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages()
    {
        return [
            'name.required' => 'Name is required',
            'name.string' => 'Name is not valid',
            'description.required' => 'Description is required',
            'description.string' => 'Description is not valid',
            'prices.required' => 'Prices is required',
            'prices.array' => 'Prices is not valid',
            'prices.*.required' => 'Prices is required',
            'prices.*.numeric' => 'Prices is not valid',
        ];
    }
}
