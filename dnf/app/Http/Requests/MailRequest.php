<?php namespace App\Http\Requests;

use Illuminate\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Request;
use Lang;

class MailRequest extends FormRequest {

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
            'receiver_id' => 'required',
            'content' => 'required|max:1000',
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
            'receiver_id.required' => $rules['required']['receiver-id'],
            'content.required' => $rules['required']['content'],
            'content.max' => $rules['max']['content'] . ':max',
        ];
    }


}
