<?php

namespace App\Http\Requests\BadWord;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property mixed $file
 * @property mixed $language
 */
class ImportRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'file' => 'required|file|mimes:xml|max:204800',
            'language' => 'required',
        ];
    }
}
