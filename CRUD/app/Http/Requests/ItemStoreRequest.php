<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ItemStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'product' => ['required', 'string', 'min:3', 'max:25'],
            'category' => ['required', 'string', 'min:3', 'max:25'],
            'quantity' => ['required', 'integer', 'between:1,1000'],
            'price' => ['required', 'integer', 'between:1,500'],
        ];
    }
}
