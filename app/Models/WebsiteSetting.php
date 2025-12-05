<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\WebsiteSetting;
use Storage;


class WebsiteSetting extends Model
{
   public function updateWebsiteSetting($request){
       $data = WebsiteSetting::first();
       if(empty($data)){
        $data = new WebsiteSetting;       
       }       
       foreach($request->all() as $key => $item){
           if($key != '_token'){   
               if($key == 'logo'){
                deleteImageFromPublic($data->logo);        
                $data->logo = fileSave($request->logo, 'images/logo');                   
               }else{
                   $data->$key = $item;
               }            
           }        
       }
       return $data->save();
   }
}
