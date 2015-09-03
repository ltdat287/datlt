<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Helpers\MemberHelper;

class UserAddFormRequest extends Request
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
        $valid = [
            'name' => 'required|min:1|max:16',
            'kana' => 'required|min:1|max:16',
            'email' => 'required|vp_email|confirmed|max:255|unique:users',
            'email_confirmation' => 'required',
            // 'telephone_no' => 'required|vp_telephone|min:10|max:13',
            'birthday' => 'required|date_format:' . VP_TIME_FORMAT . '|vp_date|min:10|max:10',
            'note' => 'required|min:1|max:300',
            'password' => 'required|between:8,32',
            'use_role' => 'required'
        ];
        
        if (MemberHelper::getCurrentUserRole() == 'boss') {
            unset($valid['use_role']);
        }

        return $valid;
    }
}
