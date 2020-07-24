<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use LangleyFoxall\LaravelNISTPasswordRules\PasswordRules;

class UserFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->can('create-users');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $data = [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => [PasswordRules::register(request()->email)]
        ];


        if (Request::isMethod('patch') || Request::isMethod('put')) {
            $data['email'] = 'required|email';
            $data['password'] = '';
        }

        // if (Request::METHOD_PATCH && filled(request()->password)) {
        //     $data['password'] = PasswordRules::changePassword(request()->email);
        // }

        return $data;
    }
}
