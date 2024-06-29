<?php

namespace App\Http\Requests\HR;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use App\Rules\PasswordValidator;


class UserEmployeePost extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
           
            'first_name' => 'required|string|max:150',
            'last_name' => 'required|string|max:150',
            'middle_name' => 'nullable|string|max:150',
            'code' => 'nullable|string|max:150',
            'id_number' => 'nullable|string|max:150',
            'nssf_number' => 'nullable|string|max:150',
            'tin_number' => 'nullable|string|max:150',
            'telephone' => 'required|string|max:150',
            'email' => 'required|email|max:150|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'gender' => 'required|integer|in:1,2',
            'date_of_birth' => 'required|date_format:Y-m-d',
            'personal_email' => 'nullable|string',
            'permanent_address' => 'nullable|string',
            'present_address' => 'nullable|string',
            'office_number' => 'nullable|string',
            'mobile_number' => 'nullable|string',

        ];
    }
}
