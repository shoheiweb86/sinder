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
            'grade' => ['nullable', Rule::in(['1年生', '2年生', '3年生', '4年生', '5年生', '6年生', '院1年生', '院2年生'])],
            'faculty' => ['nullable', Rule::in(['人文学部', '教育学部', '法学部', '経済科学部', '理学部', '医学部医学科', '医学部保健学科', '歯学部', '工学部', '農学部', '創生学部', '教育実践学研究科', '現代社会文化研究科', '自然科学研究科', '保健学研究科', '医歯学総合研究科'])],
            'sex' => ['nullable', Rule::in(['男性', '女性'])],
            'self_introduction' => ['nullable', 'string', 'max:200'],
            'avatar' => ['nullable', 'file'],
            'line_link' => ['nullable', 'regex:/^(?:https?:\/\/)?(?:line\.me\/[A-Za-z0-9_.-]+)$/i'],
            'twitter_link' => ['nullable', 'regex:/^(?:https?:\/\/)?(?:www\.)?twitter\.com\/[A-Za-z0-9_]+\/?$/i'],
            'instagram_link' => ['nullable', 'regex:/^(?:https?:\/\/)?(?:www\.)?instagram\.com\/[A-Za-z0-9_]+\/*$/i'],
        ];
    }
}
