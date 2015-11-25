<?php namespace App\Http\Requests;

use Request;
use Lang;
use Illuminate\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class CourseArticleRequest extends FormRequest {

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
		           'title'=> "required|between:1,20",
		           'author'=> 'required|between:1,15',
		            'course_id'=>'required',
	 	            'img_URL'=>'URL',
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
	            'course_id.required'=>$rules['required']['course_id'],
	            'img_URL.url'=> $rules['URL'],
                          'content.required' => $rules['required']['content'],
        ];
	}

}
