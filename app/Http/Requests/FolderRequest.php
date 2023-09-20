<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Http\Responses\ApiResponse;
class FolderRequest extends FormRequest
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
            'name' => 'required|string|max:255|unique:folders,name',
        ];
    }
    // Message method is optional
    public function messages(): array
    {
        return [
            'name.required' => 'The field name field is required.',
            'name.max' => 'The name field should not exceed :max characters.',    
        ];
    }
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(ApiResponse::response($validator->errors(), [
            'error' => [
                'Validation failed'
            ]
        ], 422,date('Y-m-d H:i:s')));
       
    }
}
