<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterParishRequest extends FormRequest
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
            "name" => "required|min:4",
            "email" => "required|min:4|max:255|email|unique:parish,email",
            "password" => "required|min:5|max:255",
            "address"=> "required|min:4|max:255",
            "city" => "required|min:3|max:255",
            "state" => "required|min:2|max:255",
            "photo" => "nullable|image|mimes:png,jpeg,jpg,webp|max:10024",
            "longitude" => "required|numeric",
            "latitude" => "required|numeric"
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
