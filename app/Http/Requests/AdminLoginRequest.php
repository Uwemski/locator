<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminLoginRequest extends FormRequest
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
            //
            'email' => 'required|min:3|email',
            'password' => 'required|min:3',
        ];
    }

    public function prepareForValidation()
    {
        $input = $this->all();

        foreach($input as $key => $value){
            if(is_string($value)){
                $input[$key] = strip_tags($value);
            }
        }

        $this->replace($input);
    }
}
