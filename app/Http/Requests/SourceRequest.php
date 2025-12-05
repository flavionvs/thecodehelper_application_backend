<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SourceRequest extends FormRequest
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
        $id = request()->route('source');                                   
        $array['name']='required|unique:sources,name,'.$id;                                                                                                       
        $array['service_id'] = 'required|exists:services,id';
        return $array;
    }
    public function messages()
    {
        return [];
    }
}
