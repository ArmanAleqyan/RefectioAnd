<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ManufacturerRequest extends FormRequest
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
            'company_name' => 'required|max:250',
//            'phone_code' => 'required|max:250',
            'phone' => 'required|max:250',
            'role_id' => 'required|max:250',
            'individual_number' => 'required|max:250',
            'watsap_phone' => 'required|max:250',
            'made_in' => 'required|max:250',
            'price_of_metr' => 'required|max:250',
            'logo' => 'required',
            'product_category' => 'required',
            'sales_city' => 'required',
            'percent_bonus' => 'required',
            'password' => 'required|min:6',
            'password_confirmation' => 'required_with:password|same:password|min:6',
            'i_agree' => 'required',
            'saite' => 'url'
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Validation errors',
            'data' => $validator->errors()
        ]));
    }
}
