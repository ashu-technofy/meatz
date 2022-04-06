<?php

namespace Modules\User\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\User\Models\User;

class UserRequest extends FormRequest
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
        if (strpos(request()->url() , 'social_login') !== false) {
            return [];
        }
        if ($user = auth('api')->user()) {
            return [
                'mobile'        =>  'unique:users,mobile,' . $user->id,
                'email'         =>  'email:rfc,dns|unique:users,email,' . $user->id
            ];
        }
        $rules =  [
            'first_name'   =>  'required',
            'last_name'   =>  'required',
            'mobile'        =>  'required|unique:users,mobile|digits:8',
            'email'         =>  'email:rfc,dns|required|unique:users,email',
            'password'      =>  'required'
        ];
        return $rules;
    }
}
