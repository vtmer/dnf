<?php namespace App\Http\Requests;

use Illuminate\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Request;
use Lang;

class VtmerRequest extends FormRequest {

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
     * 验证规则
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => "required|between:0,10|unique:aboutus,name,".Request::get('id'),
            'time' => 'required|Date',
            'introduction' => 'required|between:0,300',
            'blog' => 'required',
            'email' => 'required|email',

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
            'name.required' => $rules['required']['name'],
            'name.unique' => $rules['unique']['name'],
            'name.between' => $rules['between']['name'].':min ~ :max',
            'time.required' => $rules['required']['time'],
            'time.Date' => $rules['Date']['time'],
            'introduction.between' => $rules['between']['introduction'].':min ~ :max',
            'introduction.required' => $rules['required']['introduction'],
            'email.email' => $rules['email']['email'],
            'email.required' => $rules['required']['email'],
            'img_URL.required' => $rules['required']['img_URL'],
            'blog.required' => $rules['required']['blog'],


        ];
    }


}
