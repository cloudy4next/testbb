<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Foundation\Http\FormRequest;

class PPTXRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // only allow updates if the user is logged in
        return backpack_auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|min:5',
            'image' => 'required|mimes:jpeg,jpg,png|max:5000',
            'pptx' => 'required|mimes:jpeg,jpg,png,gif,mp4,mov,avi,mpeg,3gp,pdf,xlsx|max:500000',
        ];
    }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            //
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'image' => 'Select image file Upload!',
            'pptx' => 'Select image,pdf,xlsx,video file Upload!',

        ];
    }
}
