<?php

namespace App\Http\Requests\Api;

class UserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch($this->method()) {
        case 'POST':
            return [
                'name' => 'required|between:3,25|regex:/^[A-Za-z0-9\-\_]+$/|unique:users,name',
                'password' => 'required|string|min:6',
                'verification_key' => 'required|string',
                'verification_code' => 'required|string',
            ];
            break;
        case 'PUT':
        case 'PATCH':
            $userId = \Auth::guard('api')->id();

            return [
                'name' => 'between:3,25|regex:/^[A-Za-z0-9\-\_]+$/|unique:users,name,' .$userId,
                'email'=>'email|unique:users,email,'.$userId,
                'introduction' => 'max:80',
                'avatar_image_id' => 'exists:images,id,type,avatar,user_id,'.$userId,
            ];
            break;
        }
    }

    public function attributes()
    {
        return [
            'verification_key' => 'SMS verification code key',
            'verification_code' => 'SMS verification code',
            'introduction' => 'Personal profile',
        ];
    }

    public function messages()
    {
        return [
            'name.unique' => 'Username is already taken, please re-fill.',
            'name.regex' => 'Usernames only support English, numbers, crossbars, and undersocres.',
            'name.between' => 'Username must be between 3~25 characters.',
            'name.required' => 'Username can not be empty.',
        ];
    }
}
