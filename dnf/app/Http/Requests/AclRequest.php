<?php namespace App\Http\Requests;

use Illuminate\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Request;
use Lang;

class AclRequest extends FormRequest {

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
            'name' => "required|max:50|unique:admin_permission,name",
            'module' => 'max:20',
            'class' => 'required',
            'function' => 'required',
            'pid' => 'integer',
            'mark' => 'max:100',
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
            'name.max' => $rules['max']['name'].'50',
            'module.max' => $rules['max']['module'].'20',
            'class.required' => $rules['required']['class'],
            'function.required' => $rules['required']['function'],
            'pid.integer' => $rules['integer']['pid'],
            'mark.max' => $rules['max']['mark'].'100',
        ];
    }


}
