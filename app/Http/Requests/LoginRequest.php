<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function rules()
    {
        return [
            'grant_type' => 'required|string|max:191',
            'username' => 'email|string|max:191|required',
            'password' => 'required|string|max:191|min:8',
            'client_id' => 'required|string|max:191',
            'client_secret' => 'required|string|max:191',
            'scope' => 'max:191',
        ];
    }

    public function attributes()
    {
        return [
            'username' => 'nome de usuário',
            'password' => 'senha',
        ];
    }

}
