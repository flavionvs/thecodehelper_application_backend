<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ProfileRequest;
use App\Models\BasicSetting;
use App\Models\User;
use App\Models\Order;
use App\Models\Category;
use App\Models\Payment;
use App\Models\SubCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\UploadedFile;


class HomeController extends Controller
{    
    protected $paymentModel;
    public function __construct(){
        $this->paymentModel = new Payment();
        $this->middleware('permission:view project',   ['only' => ['show', 'index']]);
        $this->middleware('permission:create project', ['only' => ['create','store']]);
        $this->middleware('permission:edit project', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete project',   ['only' => ['destroy']]);             
        
    }
    public function index(){ 
        return view('common.index');
    }
    public function getCategory(Request $request, $type_id){
        $category = Category::whereTypeId($type_id)->get();       
        $category_id = isset($request->category_id) && $request->category_id ? $request->category_id : '';        
        return view('common.get-category', compact('category', 'category_id'));        
    }
    public function getSubCategory(Request $request, $category_id){
        $sub_category = SubCategory::whereCategoryId($category_id)->get();       
        $sub_category_id = isset($request->sub_category_id) && $request->sub_category_id ? $request->sub_category_id : '';
        return view('common.get-sub-category', compact('sub_category', 'sub_category_id'));
    }
 
    public function updateSetting(Request $request){
        $update = BasicSetting::first();
        if(empty($update)){
            $update = new BasicSetting;        
        }
        if(!empty($request->background_color)){
            $update->background_color = $request->background_color;
        }        
        if(!empty($request->header_color)){
            $update->header_color = $request->header_color;
        }      
        if(!empty($request->logo_background_color)){
            $update->logo_background_color = $request->logo_background_color;
        }     
        if(!empty($request->footer_color)){
            $update->footer_color = $request->footer_color;
        }             
        if(!empty($request->main_content_background_color)){
            $update->main_content_background_color = $request->main_content_background_color;
        }      
        if(!empty($request->main_body_card_background_color)){
            $update->main_body_card_background_color = $request->main_body_card_background_color;
        }      
        if(!empty($request->sidebar_font_color)){
            $update->sidebar_font_color = $request->sidebar_font_color;
        }      
        if(!empty($request->sidebar_font_size)){
            $update->sidebar_font_size = $request->sidebar_font_size;
        }      
          
        $update->save();
        return back()->with('success', 'Setting updated successfully');
    }

    public function myProfile(){             
        return view('common.my-profile');
    }
    public function updateProfile(ProfileRequest $request){    
        DB::BeginTransaction();
        try{
            $user = User::find(auth()->id());            
            if(!empty($request->password)){
            
                $user->password = Hash::make($request->password);
            }            
            if($request->image){
                $path = fileSave($request->image, 'profile-pic');
                // $new_img = $this->imageC(public_path($path));
                $user->image = $path;
            }                                                         
            $user->phone = $request->phone;
            $user->first_name = $request->first_name;            
            $user->email = $request->email;
            $user->save();
            DB::commit();
            return response()->json(array('status'=>true, 'message' => 'Profile updated successfully!', 'reload' => url(guardName().'/my-profile')));
        }catch(\Exception $e){            
            DB::rollback();
            return response()->json(array('status'=>false, 'message' => showError($e)));
        }      
    }
    public function imageC($file_name, $newWidth = null, $height = null){
        $imageBlob = file_get_contents($file_name);
        $image = new \Imagick();
        $image->readImageBlob($imageBlob);
        $height = $image->getImageHeight();
        $width = $image->getImageWidth();
        
        // Resize the image
        //  if($width > 1000){            
            $newHeight = $height * ($newWidth / $width);            
            $image->resizeImage( $newWidth, $newHeight,  \Imagick::FILTER_LANCZOS, 1 );
        // }else{            
        //     $image->resizeImage($width, $height, \Imagick::FILTER_LANCZOS, 1);
        // }
        
        // Apply compression (JPEG format)
        $image->setImageCompression(\Imagick::COMPRESSION_JPEG);
        $image->setImageCompressionQuality(85); // You can adjust the quality level as needed
        
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_buffer($finfo, $image->getImageBlob());
        $mime == "image/svg" && $mime.= "+xml";
        
        // Get the base64 encoded image with compression
        $base64 = "data:$mime;base64," . base64_encode($image->getImageBlob());
        
        return $base64;
    }
  
    
    public function uploadFiles(Request $request){
        try{
            $name = $request->file_name;    
            $width = $request->width ?? null;    
            $height = $request->height ?? null;            
            $directory = $request->directory ?? null;            
            $data['html'] = '';
            $data['path'] = '';
            $data['status'] = false;  
            if(isset($request->color)){
                foreach($request->color as $index => $item){                     
                    if($index == $request->pcid){
                        $uploadedImage = $item['uploadimage'] ?? $item['image'];
                        if($uploadedImage){
                            foreach($uploadedImage as $key => $image){    
                                if ($image instanceof UploadedFile) {
                                    $directory = $directory ?? 'upload/uploaded-files';
                                    $real_path = fileSave($image, $directory);                                       
                                    $image_path = asset($real_path); 
                                    // $base64 = $this->imageC($image_path, $width, $height);                                      
                                    // $new_image = base64ToImageConverter($base64, $directory);
                                    // deleteImageFromPublic($real_path);
                                    // $image_path = $new_image;
                                    $data['path'] .= $image_path.',';
                                    $data['html'] .= view('admin.layout.partials.image-view', ['type' => $name, 'url' => $image_path, 'pcid' => $request->pcid])->render();
                                    $data['status'] = true;       
                                }
                            }
                        }            
                    }
                }       
            }
            if(isset($request->file)){
                $image = $request->file;
                if ($image instanceof UploadedFile) {
                    $directory = $directory ?? 'upload/uploaded-files';
                    $real_path = fileSave($image, $directory);                                       
                    $image_path = asset($real_path); 
                    // $base64 = $this->imageC($image_path, $width, $height);                                      
                    // $new_image = base64ToImageConverter($base64, $directory);
                    // deleteImageFromPublic($real_path);
                    // $image_path = $new_image;
                    $data['path'] = $image_path;
                    $data['html'] = view('admin.layout.partials.image-view', ['type' => $name, 'url' => $image_path, 'path' => $real_path, 'width' => $width, 'height' => $height,'single' => true])->render();
                    $data['status'] = true;       
                }
            }
            return response($data);
        }catch(\Exception $e){
            return response()->json(['status' => false, 'message' => showError($e)]);
        }
    }

    public function setting(){
        $data = BasicSetting::first();
        if(request()->method() == 'POST'){
            $data->primary_color = request()->primary_color;
            $data->secondary_color = request()->secondary_color;
            $data->description = request()->description;
            if(request()->image1){
                $data->image1 = fileSave(request()->image1, 'upload/home-images', $data->image1);
            }
            $data->description1 = request()->description1;
            if(request()->image2){
                $data->image2 = fileSave(request()->image2, 'upload/home-images', $data->image2);
            }
            $data->description2 = request()->description2;
            if(request()->image3){
                $data->image3 = fileSave(request()->image3, 'upload/home-images', $data->image3);
            }
            if(request()->banner1){
                $data->banner1 = fileSave(request()->banner1, 'upload/banner', $data->banner1);
            }
            if(request()->banner2){
                $data->banner2 = fileSave(request()->banner2, 'upload/banner', $data->banner2);
            }
            if(request()->banner3){
                $data->banner3 = fileSave(request()->banner3, 'upload/banner', $data->banner3);
            }
            if(request()->banner4){
                $data->banner4 = fileSave(request()->banner4, 'upload/banner', $data->banner4);
            }
            $data->save();
            return back()->with('success', 'Updated successfully!');
        }
        return view('common.setting', compact('data'));
    }
    public function paymentHistory(){
        if(request()->ajax()){                    
            return $this->paymentModel->datatable();
        }        
        $data['clients'] = Payment::groupBy('user_id')->get();     
        return view('common.payment.index', $data);
    }
}
