<?php

namespace App\Http\Requests;

use App\Rules\ImageValidationRule;
use Illuminate\Validation\Rule;

class RegisterRequest extends BaseRequest
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
            'name'=>'required|string',
            'user_name'=>[
                'required',
                'min:4',
                'max:20',
                Rule::unique('users','user_name')->ignore(request('id'))
            ],
            'email'=>[
                'required',
                'email',
                Rule::unique('users','email')->ignore(request('id'))
            ],
            'user_role'=>[
                'required',
                'integer',
                'in:1,2'
            ],
            'avatar'=>[
                'mimes:jpg,jpeg,png',
                new ImageValidationRule(256,256)
            ],
            'password'=>'required|max:30'


        ];
    }
}
