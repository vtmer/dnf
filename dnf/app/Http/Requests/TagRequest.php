<?php namespace App\Http\Requests;

use Illuminate\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Request;
use Lang;

class TagRequest extends FormRequest {

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
                  'tag' => "required|between:0,20|unique:blog_tag,tag,".Request::get('id'),
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
             'tag.unique' => $rules['unique']['tag'],
             'tag.between' => $rules['between']['tag'].':min ~ :max',
         ];
    }

}
