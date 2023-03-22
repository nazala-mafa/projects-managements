<?php

namespace App\Http\Requests;

class UpdateTaskRequest extends BaseRequest
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
            'name' => 'required',
            'description' => 'required',
            'deadline' => 'required',
            'user_assign' => 'required',
            'image' => 'image|max:2048'
        ];
    }
}