<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PatientRequest extends FormRequest
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
            'firstName' => ['required', 'string', 'max:100'],
            'lastName' => ['required', 'string', 'max:100'],
            'birthdate' => ['required', 'date', 'before:today'],
            'dni' => ['required', 'string', 'max:100', 'unique:patients,dni'],
        ];
    }

    // public function all($keys = null)
    // {
    //     $data = parent::all();

    //     $data['first_name'] = $data['firstName'];
    //     $data['last_name'] = $data['lastName'];
    //     $data['birthdate'] = $data['birthdate'];
    //     $data['dni'] = $data['dni'];

    //     return $data;
    // }
}
