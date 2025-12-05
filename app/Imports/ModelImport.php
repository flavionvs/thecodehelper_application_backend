<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\VehicleModel;

class ModelImport implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {                
        foreach($collection->all() as $key => $item){
            if($key == 1){
               $model_array = explode(',', $item[0]);
               $duplicate_model = [];
               foreach($model_array as $value){
                   $check = VehicleModel::whereName($value)->first();
                   if(empty($check)){
                       $model_create = new VehicleModel;
                       $model_create->name = $value;
                       $model_create->save();
                   }else{
                    $duplicate_model[] = $value;
                   }
               }
            }
        }
        
        
    }
}
