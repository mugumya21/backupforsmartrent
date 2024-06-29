<?php

namespace App\Http\Requests\Accounts;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property float buying
 * @property float selling
 * @property Carbon date
 * @property int currency_id
 * @property boolean is_active
 */
class CurrencyRatePost extends FormRequest
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
     * Get data to be validated from the request.
     *
     * @return array
     */
    public function validationData()
    {
        $data = $this->all();
        $data['buying'] = str_replace(',', '', $data['buying']);
        $data['selling'] = str_replace(',', '', $data['selling']);
        return $data;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'buying' => 'required|numeric',
            'selling' => 'required|numeric',
            'date' => 'required_if:id,0|date_format:Y-m-d',
            'currency_id' => 'required|integer'
        ];
    }
}
