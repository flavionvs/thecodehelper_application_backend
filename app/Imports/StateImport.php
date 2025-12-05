<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\State;
use App\Models\stateAgency\StateAgencyCategory;
use App\Models\stateAgency\StateAgencyState;
use App\Models\District;
use App\Models\SubDistrict;

class StateImport implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        foreach($collection->all() as $key => $item){
            if($key != 0 && $key != 1 && $key != 2){         
                if(!empty($item[1]) && !empty($item[2]) && !empty($item[3])){    
                    $state = State::whereName($item[1])->first();
                    if(empty($state)){                                        
                        $state = new State;
                        $state->name = $item[1];
                        $state->save();                                  
                    }                      
                    $district = District::whereStateId($state->id)->whereName($item[2])->first();
                    if(empty($district)){
                        $district = new District;
                        $district->state_id = $state->id;
                        $district->name = $item[2];
                        $district->save();                                          
                    }
                    $sub_district = SubDistrict::whereDistrictId($district->id)->whereName($item[3])->first();
                    if(empty($sub_district)){
                        $sub_district = new SubDistrict;
                        $sub_district->district_id = $district->id;
                        $sub_district->name = $item[3];
                        $sub_district->save();                                          
                    }else{
                        session()->put('diplicate', $item);
                    }   
                    
                    // Importing states in state_agency_state table
                    $state_agency_category = StateAgencyCategory::whereName('General States')->first();
                    $state_agency_category_id = 0;
                    if($state_agency_category){
                        $state_agency_category_id = $state_agency_category->id;
                    }else{
                        $state_agency_category = StateAgencyCategory::first();
                        if($state_agency_category){
                            $state_agency_category_id = $state_agency_category->id;
                        }
                    }
                    if($state_agency_category_id != 0){
                        $state_agency_state = StateAgencyState::whereStateId($state->id)->whereStateAgencyCategoryId($state_agency_category_id)->first();
                        if(empty($state_agency_state)){
                            $state_agency_state = new StateAgencyState;                        
                            $state_agency_state->state_id = $state->id;
                            $state_agency_state->state_agency_category_id = $state_agency_category_id;
                            $state_agency_state->save();                        
                        }
                    }
                }                   
            }
        }
    }
}
