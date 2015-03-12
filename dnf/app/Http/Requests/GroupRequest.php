<?php namespace App\Http\Requests;

use Illuminate\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Request;
use Lang;

class GroupRequest extends FormRequest {

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
            'level' => 'integer|between:0,1000',
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
            'level.integer' => $rules['integer']['level'],
            'level.between' => $rules['between']['level'].':min ~ :max',
            'mark.max' => $rules['max']['mark'].'100',
        ];
    }


}
