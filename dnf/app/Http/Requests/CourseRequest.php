<?php namespace App\Http\Requests;

use Illuminate\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Request;
use Lang;

class CourseRequest extends FormRequest {

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
                  'name' => "required|between:0,50|unique:course,name,".Request::get('id'),
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
             'course.unique' => $rules['unique']['course'],
             'course.between' => $rules['between']['course'].':min ~ :max',
         ];
    }

}
