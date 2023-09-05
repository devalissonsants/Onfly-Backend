<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OutlayRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        return [
            'description' => 'required|string|max:191',
            'outlay_date' => ['required', 'before_or_equal:' .  date('Y-m-d')],
            'user_id' => 'required|integer|exists:users,id',
            'amount' => 'required|numeric|gt:0',
        ];
    }

    public function attributes()
    {
        return [
            'user_id' => 'usuário',
            'outlay_date' => 'data da despesa',
            'description' => 'descrição',
            'amount' => 'valor',
        ];
    }
}
