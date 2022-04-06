<?php

namespace Modules\Addresses\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddressRequest extends FormRequest
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
            'area_id' => 'required|exists:areas,id',
            'address_name' => 'required',
            'block' => 'required',
            'street' => 'required',
            'house_number' => 'required',
        ];
    }
}
