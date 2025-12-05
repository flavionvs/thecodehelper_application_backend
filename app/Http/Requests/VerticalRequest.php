<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VerticalRequest extends FormRequest
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
        $id = request()->route('vertical');                                   
        $array['name']='required|unique:verticals,name,'.$id;                                                                                                       
        return $array;
    }
    public function messages()
    {
        return [];
    }
}
