<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property int lookup_id
 * @property string description
 * @property string key
 * @property string value
 */
class LookupPost extends FormRequest
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
            'key' => ['required','string','max:150',Rule::unique('settings')->ignore($this->lookup_id)],
            'description' => 'nullable|string',
            'value' => 'required|string|max:100'
        ];
    }
}
