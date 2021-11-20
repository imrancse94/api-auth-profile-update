<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class InvitationRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "email"=>[
                "required",
                "email",
                Rule::unique('users','email')->ignore(request('id'))
            ]
        ];
    }
}
