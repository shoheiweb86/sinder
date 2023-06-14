<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['string', 'max:20'],
            'age' => ['nullable', 'integer'],
            'grade' => ['nullable', Rule::in(['学部1年生', '学部2年生', '学部3年生', '学部4年生', '学部5年生', '学部6年生', '大学院1年生', '大学院2年生'])],
            'faculty' => ['nullable', Rule::in(['人文学部', '教育学部', '法学部', '経済科学部', '理学部', '医学部医学科', '医学部保健学科', '歯学部', '工学部', '農学部', '創生学部', '教育実践学研究科', '現代社会文化研究科', '自然科学研究科', '保健学研究科', '医歯学総合研究科'])],
            'sex' => ['nullable', Rule::in(['男子', '女子', '秘密'])],
            'self_introduction' => ['nullable', 'string', 'max:200'],
            'user_icon_path' => ['nullable', 'string'],
            'line_link' => ['nullable', 'string'],
            'twitter_link' => ['nullable', 'string'],
            'instagram_link' => ['nullable', 'string'],
            'email' => ['email', 'max:255', Rule::unique(User::class)->ignore($this->user()->id)],
            //'password' => ['required', 'string'],
        ];
    }
}