<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ParishUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth('parish')->check();
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
            "address" => 'required|min:5',
            "pastor_name" => "required|min:5",
            "contact_no" => "required|min:10",
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
