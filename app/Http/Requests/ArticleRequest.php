<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest
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
            'product_name' => 'required|max:255',
            'company_id' => 'required|exists:companies,id',
            'price' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'comment' => 'nullable|string',
            'img_path' => 'nullable|image|max:2048',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'product_name.required' => '商品名は必須入力です。',
            'product_name.max' => '商品名は255文字以内で入力してください。',
            'company_id.required' => 'メーカーを選択してください。',
            'company_id.exists' => '存在しないメーカーが選択されています。',
            'price.required' => '価格は必須入力です。',
            'price.integer' => '価格は整数で入力してください。',
            'price.min' => '価格は0以上の値で入力してください。',
            'stock.required' => '在庫数は必須入力です。',
            'stock.integer' => '在庫数は整数で入力してください。',
            'stock.min' => '在庫数は0以上の値で入力してください。',
            'comment.string' => 'コメントは文字列で入力してください。',
            'img_path.image' => '有効な画像ファイルをアップロードしてください。',
            'img_path.max' => '画像ファイルのサイズが大きすぎます。',
        ];
    }
}