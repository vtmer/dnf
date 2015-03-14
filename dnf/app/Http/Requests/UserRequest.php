<?php namespace App\Http\Requests;

use Illuminate\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Request;
use Lang;

class UserRequest extends FormRequest {

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
            'name' => "required|between:4,50|unique:admin_users,name,".Request::get('id'),
            'realname' => 'required',
            'mobile' => 'integer|between:0,100000000000',
            'password' => 'between:6,20|confirmed',
            'group_id' => 'required|integer',
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
            'realname.required' => $rules['required']['realname'],
            'mobile.integer' => $rules['integer']['mobile'],
            'mobile.between' => $rules['between']['mobile'].':min ~ :max',
            'password.between' => $rules['between']['password'].':min ~ :max',
            'password.confirmed' => $rules['confirmed']['password'],
            'group_id.required' => $rules['required']['group-id'],
            'group_id.integer' => $rules['integer']['group-id'],
        ];
    }


}
