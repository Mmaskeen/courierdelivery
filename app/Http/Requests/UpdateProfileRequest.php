<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

class UpdateProfileRequest extends FormRequest
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
//        dd($this->request->get('old_password'));
        $rules = [];
        if($this->request->get('old_password') != null || $this->request->get('password') != null){
            $rules ['old_password'] = 'required';
            $rules ['password'] = 'required|string|min:6|confirmed';
        }
        return $rules;
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator){
            if ( $this->old_password != null && !Hash::check($this->old_password, $this->user()->password) ) {
                $validator->errors()->add('old_password', 'Your old password is incorrect.');
            }
        });

        return;
    }
}
