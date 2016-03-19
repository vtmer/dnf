<?php namespace App\Http\Requests;

use Request;
use Lang;
use Illuminate\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest {

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
		           'title'=> "required|between:1,50",
		           'author'=> 'required|between:1,15',
		            'category_id'=>'required',
		            'description' => 'required',
		            'tag_id' => 'required',
		            'source'=> 'required|between:1,60',
		            'description' => 'required',
	                'content'=>'required',
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

	            'title.between'=>$rules['between']['title'].':min ~ :max',
	            'title.required'=>$rules['required']['title'],
	            'author.required'=>$rules['required']['author'],
	            'author.between' => $rules['between']['author'].':min ~ :max',
	            'category_id.required'=>$rules['required']['category_id'],
	            'tag_id.required'=> $rules['required']['tag_id'],
	            'description.required'=>$rules['required']['description'],
	            'img_URL.url'=> $rules['required'],
	            'source.required'=> $rules['required']['source'],
	          	'source.between'=>$rules['between']['source'].':min ~ :max',
                'content.required' => $rules['required']['content'],
        ];
	}

}
