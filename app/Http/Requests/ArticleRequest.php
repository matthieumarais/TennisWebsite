<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ArticleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'min:8', 'max:255'],
            'content' => ['required', 'string', 'min:10'],
            'slug' => ['required', 'string', 'min:8', 'regex:/^[0-9a-z\-]+$/', Rule::unique('articles')->ignore($this->route()->parameter('article'))],
            'image' => ['image', 'max:2000'] // 2mo
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation (): void
    {
        $this->merge([
            'slug' => $this->input('slug') ?: Str::slug($this->input('title'))
        ]);
    }
}
