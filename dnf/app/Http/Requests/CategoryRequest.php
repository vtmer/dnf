<?php namespace App\Http\Requests;

use Illuminate\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Request;
use Lang;

class CategoryRequest extends FormRequest {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }


    /*
     * 验证规则
     *
     * @return array
     */
    public function rules()
    {
        return [
                  'category' => "required|between:0,50|unique:blog_categories,category,".Request::get('id'),
               ];
    }


    /**
     * 错误消息
     *
     * @return array
     */
    public function messages()
    {
        $rules = Lang::get('backend.rules');
            return [
             'category.unique' => $rules['unique']['category'],
             'category.between' => $rules['between']['category'].':min ~ :max',
         ];
    }

}
