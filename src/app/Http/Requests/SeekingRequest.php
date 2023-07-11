<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SeekingRequest extends FormRequest
{
    public function authorize()
    {
        return true; // 必要に応じて認証のポリシーを定義します
    }

    public function rules()
    {
        return [
            'title' => 'required|max:30',
            'content' => 'required|max:200',
            'seeking_thumbnail' => 'file|max:10240', // 10MB制限の例
        ];
    }
}
