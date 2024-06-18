<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CreateOrderRequest extends FormRequest
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
            'customer_name' => 'required',
            'customer_address' => 'required',
            'product_url' => 'required',
            'product_quantity' => 'required',
            'price' => 'required',
            'mobile' => 'required',
            'city' => 'required',
        ];
    }

    protected function getValidatorInstance()
    {
        return parent::getValidatorInstance()->after(function($validator){
            // Call the after method of the FormRequest (see below)
            $this->after($validator);
        });
    }
    /**
     * Attach callbacks to be run after validation is completed.
     *
     * @param  \Illuminate\Contracts\Validation\Validator $validator
     * @return callback
     */
    public function after($validator)
    {
        if ($this->status == 'Hold Order' || $this->status == 'Canceled' || $this->status == 'Latest'){
            $thisRemarks = $this->remarks;
            if ($thisRemarks == null){
                $validator->errors()->add('remarks','remarks are required for this actions');
            }
            if ($thisRemarks !== null && !empty($this->remarks)){
                $arr = array_filter($this->remarks);
                if (empty($arr)){
                    $validator->errors()->add('remarks','remarks are required for this actions');
                }
            }
        }
    }
}
