<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        $method = $this->route()->getActionMethod();
        return [
            'name' => 'required|string|max:191',
            'email' => 'required|email|unique:users,email,' . $this->id . ',id,deleted_at,NULL',
            'password' => 'string|max:191|min:8|' . ($method == 'store' ? 'required' : ''),
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'nome',
            'password' => 'senha',
        ];
    }
}
