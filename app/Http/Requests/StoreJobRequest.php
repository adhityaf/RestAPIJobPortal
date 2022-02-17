<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreJobRequest extends FormRequest
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
            "location_id" => ['required'],
            "category_id" => ['required'],
            "title" => ['required', 'string', 'max:255'],
            "slug" => ['unique:users', 'max:255'],
            "description" => ['required', 'string'],
            "type" => ['required', 'string'],
            "level" => ['required', 'string'],
        ];
    }
}
