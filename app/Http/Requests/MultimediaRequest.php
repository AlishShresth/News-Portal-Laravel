<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MultimediaRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'file' => 'required|file|mimes:jpeg,png,mp4|max:30480',
            'alt_text' => 'nullable|string',
            'caption' => 'nullable|string',
            'article_id' => 'required|exists:news,id',
        ];
    }
}
