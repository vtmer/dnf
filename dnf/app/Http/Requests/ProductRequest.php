<?php namespace App\Http\Requests;

use Request;
use Lang;
use Illuminate\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;


class ProductRequest extends FormRequest {

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
           'name'=> "required|between:1,20",
           'holder'=> "required|between:1,20",
            'description' => 'required',
            'url'=> 'required',
           	];
	}

        /**
         *错误信息
         *
         *@return array
         */
	public function messages()
        {
	    $rules = Lang::get('backend.rules');
	    return [

            'name.between'=>$rules['between']['name'].':min ~ :max',
            'name.required'=>$rules['required']['name'],
            'holder.between'=>$rules['between']['holder'].':min ~ :max',
            'holder.required'=>$rules['required']['holder'],
       
            'description.required'=>$rules['required']['description'],
            'url.required'=> $rules['required']['url'],
        ];
	}

}
