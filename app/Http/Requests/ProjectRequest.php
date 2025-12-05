<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectRequest extends FormRequest
{
    /**
     * Determine if the project is authorized to make this request.
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
        $id = request()->route('project');                           
        $array['user_id'] = 'required';                          
        $array['title'] = 'required';                          
        $array['budget'] = 'required';                          
        $array['category_id'] = 'required';                          
        $array['tags'] = 'required';                          
        $array['description'] = 'required';                                          
        return $array;
    }
    public function messages(){
        return [
            'user_id.required' => 'Please select the client.',            
            'title.required' => 'Title field is required.',            
            'budget.required' => 'Budget field is required.',            
            'category_id.required' => 'Please select category.',            
            'tags.required' => 'Tags field is required.',            
            'description.required' => 'Description field is required.',            
        ];
    }
}
