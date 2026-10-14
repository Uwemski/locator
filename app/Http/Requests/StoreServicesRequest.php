<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreServicesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        //this is a form request to validate the service creation by parish
        //only authenticated parish can create a service
        if(auth()->guard('parish')->check()){
            return true;
        }

        return false;
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
            'name' => 'required|min:2',
            'time' => 'required|min:3',
            'day' => 'required|in:Sunday,Monday,Tuesday,Wednesday,Thursday,Friday,Saturday',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'The service name is required',
            'name.min' => 'The service name must be at least 2 characters',
            'time.required' => 'The service time is required',
            'time.min' => 'The service time must be at least 3 characters',
            'day.required' => 'The service day is required',
            'day.in' => 'The service day must be a valid day of the week',
        ];
    }
}
