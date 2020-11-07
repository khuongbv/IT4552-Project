<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidateProfile extends FormRequest
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
            'mssv'  =>  'required|numeric',
            'sdt' =>  'required|numeric',
            'qq' =>  'required|string',
            'image' =>  'required|image|max:2048',
            'khoa_id' => 'required',
            'gt_id' => 'required',
            'vien_id' => 'required',
        ];
    }
}
