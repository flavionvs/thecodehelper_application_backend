<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubCategoryRequest extends FormRequest
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
        $id = request()->route('sub_category');                                   
        $array['category_id']='required';                                                                                               
        $array['name']='required|unique:sub_categories,name,'.$id;                                                                                               
        $array['slug']='required|unique:sub_categories,slug,'.$id;                                                                                               
        $array['status']='required';                                                                                                                                                                                              
        return $array;
    }
    public function messages()
    {
        $array['category_id.required']='Select category first!';                                               
        return $array;
    }
}
