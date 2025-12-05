<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Project;
use App\Models\User;

class CartController extends Controller
{
    public function apply(){
        $array = [101,110,112,113];
        foreach($array as $item){
            Application::create([
                'user_id' => $item,            
                'project_id' => Project::first()->id,            
                'project_data' => Project::first(),
                'user_data' => User::where('id',$item)->select('users.first_name','users.email','users.first_name','users.phone')->first(),
                'status' => 'Pending',
            ]);
        }
        return redirect('/')->with('success', 'Application sent successfully.');
    }
}