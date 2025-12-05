<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServiceRequest extends FormRequest
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
        $id = request()->route('service');                                   
        $array['name']='required|unique:services,name,'.$id;                                                                                                       
        $array['vertical_id'] = 'required|exists:verticals,id';
        return $array;
    }
    public function messages()
    {
        return [];
    }
}
