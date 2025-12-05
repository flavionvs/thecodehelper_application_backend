<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoomRequest extends FormRequest
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
        $id = request()->route('room');                           
        $array['name'] = 'required|unique:rooms,name,'.$id;                                                                  
        $array['capacity'] = 'required';                          
        $array['description'] = 'required';       
        if(!$id){
            $array['image'] = 'required|image';                          
        }                   
        
        return $array;
    }
    public function messages(){
        return [
          
        ];
    }
}
