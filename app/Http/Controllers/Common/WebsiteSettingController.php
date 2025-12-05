<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WebsiteSetting;
use yajra\Datatables\DataTables;
use Storage;

class WebsiteSettingController extends Controller
{
    protected $model;
    public function __construct(){
        $this->model = new WebsiteSetting;
    }
  
    public function pages($page_name)
    {  
        $data = WebsiteSetting::first();
        return view('common.website-setting.index', compact('data'));
    }

    public function updateWebsiteSetting(Request $request){
        $update = $this->model->updateWebsiteSetting($request);
        if($update){
            return response()->json(['status'=>true,'message'=> 'Website setting updated successfully!']);
        }else{
            return response()->json(['status'=>false,'message'=> 'Something went wrong!']);            
        }
    }
       
}
