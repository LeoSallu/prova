<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProjectRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name'=>'required|string',
            'description'=>'nullable|string',
            'owner'=>'required|max:30',
            'contributors'=>'nullable|string|max:30',
            'languages'=>'nullable|string|max:20',
            'image'=>'nullable|image',
            'set_image' => 'nullable'
        ];
    }
}