<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        $id = request()->route('user');                           
        $array['first_name'] = 'required';                          
        $array['country'] = 'required';                          
        $array['role'] = 'required|in:Freelancer,Client';                          
        $array['email'] = 'email|required|unique:users,email,'.$id;                                                          
        $array['phone'] = 'numeric|digits:10|required|unique:users,phone,'.$id;                                
        if(!$id || ($id && !empty(request()->password))){      
            $array['password'] = 'required|min:6';
        }           
        return $array;
    }
    public function messages(){
        return [
            'first_name.required' => 'Name field is required!',
            'user_type.required' => 'User type field is required!',
        ];
    }
}
