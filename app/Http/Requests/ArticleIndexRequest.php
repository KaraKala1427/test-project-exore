<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleIndexRequest extends FormRequest
{
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
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_id'     => 'nullable|integer|exists:users,id',
            'title'       => 'nullable|string|max:255',
            'category_id' => 'nullable|integer|exists:categories,id',
            'page'        => 'nullable|integer',
            'per_page'    => 'nullable|integer',
            'image_id'    => 'nullable|integer|exists:images,id',
        ];
    }
}
