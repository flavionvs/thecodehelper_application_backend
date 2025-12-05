<?php

use App\Models\Booking;
use App\Models\Property;
use App\Models\Service;
use App\Models\PropertyLayout;
use App\Models\RoleHasPermission;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Role;

if (!function_exists('guardName')) {
    function guardName()
    {
        return request()->segment(1) == 'admin' || request()->segment(1) == 'superadmin' ? request()->segment(1) : 'web';
    }
}
if (!function_exists('all')) {
    function all()
    {
        dd(request()->all());
    }
}
if (!function_exists('image')) {
    function image()
    {
        return str_replace('admin/', '', url('/'));
    }
}
if (!function_exists('get_client_ip')) {
    function get_client_ip()
    {
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } elseif (isset($_SERVER['HTTP_X_FORWARDED'])) {
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        } elseif (isset($_SERVER['HTTP_FORWARDED_FOR'])) {
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        } elseif (isset($_SERVER['HTTP_FORWARDED'])) {
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        } elseif (isset($_SERVER['REMOTE_ADDR'])) {
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        } else {
            $ipaddress = 'UNKNOWN';
        }
        return $ipaddress;
    }
}
if (!function_exists('currentTime')) {
    function currentTime()
    {
        $PublicIP = get_client_ip();
        $res = file_get_contents("https://www.iplocate.io/api/lookup/$PublicIP");
        $res = json_decode($res);
        $tz = $res->time_zone; // your required location time zone.
        $timestamp = time();
        $dt = new DateTime('now', new DateTimeZone($tz)); //first argument "must" be a string
        $dt->setTimestamp($timestamp); //adjust the object to correct timestamp
        return $dt->format('Y-m-d H:i:s');
    }
}
if (!function_exists('AmountFormat')) {
    function AmountFormat($number)
    {
        return round($number, 2);
    }
}

if (!function_exists('dateFormat')) {
    function dateFormat($date)
    {
        return date('d/m/Y', strtotime($date));
    }
}
if (!function_exists('timeFormat')) {
    function timeFormat($time)
    {
        return date('d-m-Y h:i:s A', strtotime($time));
    }
}
// if (!function_exists('deleteImageFromStorage')) {
//     function deleteImageFromStorage($file){
//         $check = Storage::disk('public')->has($file);
//         if(!empty($check)){
//             unlink(storage_path('app/public/'.$file));
//         }
//     }
// }
if (!function_exists('showError')) {
    function showError($error)
    {        
        return $error->getMessage();
        if ($error->getCode() === '23000') {
            return 'You can not delete this because this is currently in use!';
        } else {
            return 'Something went wrong!';
        }
    }
}
function validationError($validate)
{
    // dd($validate->errors()->messages());
    $array = [];
    if ($validate->errors()) {
        foreach ($validate->errors()->messages() as $key => $item) {
            if($key == 'about'){
                $array['description'] = $item[0];
            }else{
                $array[$key] = $item[0];
            }
        }
    }
    return $array;
}

if (!function_exists('deleteImageFromPublic')) {
    function deleteImageFromPublic($file)
    {
        $url = url('/');
        $remove = public_path(str_replace($url, '', $file));
        if (File::exists($remove)) {
            File::delete($remove);
        }
    }
}
if (!function_exists('fileSave')) {
    function fileSave($image, $directory, $old_file = null)
    {
        if($old_file){
            deleteImageFromPublic($old_file);        
        }        
        $imageLink = '';
        if (!empty($image)) {
            $imageName = '/' . $directory . '/' . time() . rand(10000, 99999) . '.' . $image->extension();
            $image->move(public_path($directory), $imageName);
            $imageLink = $imageName;
        }
        return $imageLink;
    }
}
function deleteUnUsedImagesFromPubliFolder(){
    $allDirectories = File::allFiles(public_path('upload/uploaded-files'));
    foreach($allDirectories as $item){        
        $exist = ProductImage::where('image', str_replace(public_path(), '', $item->getPathname()))->first();
        if(!$exist){
            File::delete($item->getPathname());
        }
    }        
}
if (!function_exists('fetchImage')) {
    function fetchImage($image, $width = null, $height = null, $shape = null, $style = null)
    {
        if ($shape == 'round') {
            $shape = 'border-radius:100%';
        }
        $link = $image && file_exists(public_path($image)) ? asset($image) : asset(config('constant.dummy_image'));
        return '<img src="' . $link . '" width="' . $width . '" height="' . $height . '" style="' . $shape . ';' . $style . '">';
    }
}
if (!function_exists('img')) {
    function img($image)
    {
        $link = $image && file_exists(public_path($image)) ? asset($image) : asset(config('constant.dummy_image'));
        return $link;
    }
}
if (!function_exists('proprietor')) {
    function proprietor()
    {
        $proprietor = false;
        if (session()->get('service') && isset(session()->get('service')['Company Registration']) && in_array('Proprietorship Firm', session()->get('service')['Company Registration'])) {
            $proprietor = true;
        }
        return $proprietor;
    }
}
if (!function_exists('status')) {
    function status($status)
    {
        $output = '';
        if ($status == 'Pending') {
            $output = '<span class="badge bg-yellow text-white wd-100 py-2">Pending</span>';
        } elseif ($status == 'Ended') {
            $output = '<span class="badge bg-green text-white wd-100 py-2">Ended</span>';
        } elseif ($status == 'Running') {
            $output = '<span class="badge bg-red text-white wd-100 py-2">Running</span>';
        } elseif ($status == 'Cancelled') {
            $output = '<span class="badge bg-orange text-white wd-100 py-2">Cancelled</span>';
        } elseif ($status == 'Active') {
            $output = '<span class="badge bg-success text-white wd-100 py-2">Active</span>';
        } elseif ($status == 'Inactive') {
            $output = '<span class="badge bg-danger text-white wd-100 py-2">Inactive</span>';
        }
        return $output;
    }
}

// if (!function_exists('roleHasPermission')) {
//     function roleHasPermission($role_id, $permission){
//         $permission_id = 0;
//         $permission = Permission::whereName($permission)->first();
//         if($permission){
//             $permission_id = $permission->id;
//         }
//         $role = RoleHasPermission::whereRoleId($role_id)->wherePermissionId($permission_id)->first();
//         if($role){
//             return 'checked';
//         }
//     }
// }

if (!function_exists('property')) {
    function property($property_id)
    {
        $property = Property::find($property_id);

        $data = [];
        return $data;
    }
}

if (!function_exists('calculation')) {
    function calculation($layout_id, $investment, $installment)
    {
        $layout = PropertyLayout::find($layout_id);
        $property = Property::find($layout->property_id);

        $data['total_investment'] = ($layout->area ? $layout->area : 0) * ($layout->price ? $layout->price : 0);

        if ($property->fixed_or_customisable == 'fixed') {
            $data['down_payment'] = $data['total_investment'] * ($property->rate / 100);
        } else {
            $data['down_payment'] = 0;
        }
        $data['total_payment_without_downpayment'] = $data['total_investment'] - $data['down_payment'];
        $data['single_month_payment'] = $data['total_payment_without_downpayment'] / $investment;
        $data['selected_month_payment'] = $data['single_month_payment'] * $installment;
        $data['amount'] = $data['single_month_payment'] * $installment + $data['down_payment'];
        $data['remaining_payment'] = $data['total_investment'] - $data['amount'];

        $data['total_investment'] = round($data['total_investment'], 2);
        $data['down_payment'] = round($data['down_payment'], 2);
        $data['total_payment_without_downpayment'] = round($data['total_payment_without_downpayment'], 2);
        $data['single_month_payment'] = round($data['single_month_payment'], 2);
        $data['selected_month_payment'] = round($data['selected_month_payment'], 2);
        $data['amount'] = round($data['amount'], 2);
        $data['remaining_payment'] = round($data['remaining_payment'], 2);
        return $data;
    }
}
if (!function_exists('authUser')) {
    function authUser()
    {
        return auth()
            ->guard(guardName())
            ->user();
    }
}
if (!function_exists('authCheck')) {
    function authCheck()
    {
        return auth()
            ->guard(guardName())
            ->check();
    }
}
if (!function_exists('authId')) {
    function authId()
    {
        return auth()
            ->guard(guardName())
            ->id();
    }
}
if (!function_exists('myRoleId')) {
    function myRoleId()
    {
        return auth()
            ->guard(guardName())
            ->user()->myRole->role_id;
    }
}
if (!function_exists('service')) {
    function service($type, $name)
    {
        $service = Service::whereType($type)
            ->whereName($name)
            ->first();
        $price = 1000;
        if ($service) {
            $price = $service->price;
        }
        return $price;
    }
}

if (!function_exists('captcha')) {
    function captcha($captcha)
    {
        $secretKey = '6LesO30kAAAAAES97TuiYiDwG3WAK3M8NPXqi0oJ';
        $response = $captcha;
        $userIp = $_SERVER['REMOTE_ADDR'];
        $url = "https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$response&remoteip=$userIp";
        $response = \file_get_contents($url);
        $response = json_decode($response);
        return $response->success;
    }
}
if (!function_exists('generateRandomString')) {
    function generateRandomString($length = 15)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}

if (!function_exists('cutString')) {
    function cutString($string, $length = 30)
    {
        if (strlen($string) > $length) {
            return substr($string, 0, $length) . '...';
        } else {
            return $string;
        }
    }
}
if (!function_exists('checkRoomAvailablity')) {
    function checkRoomAvailablity($room_id, $from_time, $to_time, $date, $booking_id = null)
    {
        $from_time = date('Y-m-d H:i', strtotime($date . ' ' . $from_time));
        $to_time = date('Y-m-d H:i', strtotime($date . ' ' . $to_time));
        
        $range1_from = Carbon::createFromFormat('Y-m-d H:i', $from_time);

        $range1_to = Carbon::createFromFormat('Y-m-d H:i', $to_time);
        $room = Booking::whereRoomId($room_id)
            ->whereDate('date', '=', date('Y-m-d', strtotime($date)))
            ->where('id', '!=', $booking_id)
            ->get();
        $error = '';

        if ($room) {
            foreach ($room as $item) {
                $range2_from = Carbon::createFromFormat('Y-m-d H:i:s', $item->date . ' ' . $item->from_time);
                $range2_to = Carbon::createFromFormat('Y-m-d H:i:s', $item->date . ' ' . $item->to_time);
                // dd($range1_from.' '.$range1_to.' '.$range2_from.' '.$range2_to);
                if ($range2_from->between($range1_from, $range1_to) || $range2_to->between($range1_from, $range1_to) || $range1_from->between($range2_from, $range2_to) || $range1_to->between($range2_from, $range2_to)) {
                    $error .= 'Room is already booked from ' . date('h:i A', strtotime($range2_from)) . ' To ' . date('h:i A', strtotime($range2_to)) . ' on ' . dateFormat($item->date);
                }
            }
        }
        if ($error) {
            return ['status' => false, 'message' => $error];
        } else {
            return ['status' => true];
        }
    }
}
if (!function_exists('checkRoomRunningStatus')) {
    function checkRoomRunningStatus($from_time, $to_time, $date)
    {
        $now = Carbon::now();
        $from_time = date('Y-m-d H:i', strtotime($date . ' ' . $from_time));
        $to_time = date('Y-m-d H:i', strtotime($date . ' ' . $to_time));
        $range1_from = Carbon::createFromFormat('Y-m-d H:i', $from_time);
        $range1_to = Carbon::createFromFormat('Y-m-d H:i', $to_time);
        if ($now >= $from_time && $now <= $range1_to) {
            return ['status' => true];
        } else {
            return ['status' => false, 'message' => 'Timing is not matching with current time.'];
        }
    }
}

if (!function_exists('sendMail')) {
    function sendMail($array, $type)    
    {        
        $booking_id = $array['booking_id'];
        $booking = Booking::find($booking_id);
        $user = User::find($booking->user_id);
        try{
            if($type == 'user-booking'){
                // Mail::send('emails.meeting-booked', ['user' => $user, 'booking' => $booking], function($q) use($user){
                //     $q->to($user->email)->subject('Meeting Room Booked');
                // });       
            }   
        }catch(\Exception $e){
        }
    }
}

if (!function_exists('encryptDecryptAsset')) {
    function encryptDecryptAsset() {
        $data['ciphering'] = "AES-128-CTR";
        $data['iv_length'] = openssl_cipher_iv_length($data['ciphering']);
        $data['options'] = 0;
        $data['iv'] = openssl_random_pseudo_bytes($data['iv_length']); // Generate a random IV
        $data['key'] = "CPHRACADEMY";
        return $data;
    }
}

if (!function_exists('encryption')) {
    function encryption($string, $url = null) {
        $encryptionData = encryptDecryptAsset(); // Get encryption data
        $ciphering = $encryptionData["ciphering"];
        $options = $encryptionData["options"];
        $iv = $encryptionData["iv"];
        $key = $encryptionData["key"];
        
        $encryption = openssl_encrypt($string, $ciphering, $key, $options, $iv);
        $encryption = $url ? urlencode($encryption) : $encryption;
        
        // Adding a flag to prevent repeated decryption
        $encryption .= '|encrypted';
        
        return $encryption;
    }
}

if (!function_exists('decryption')) {
    function decryption($encrypted_string) {
        // Check if the string is already decrypted
        if (strpos($encrypted_string, '|encrypted') !== false) {
            return substr($encrypted_string, 0, -10); // Remove the flag
        }
        
        $encryptionData = encryptDecryptAsset(); // Get encryption data
        $ciphering = $encryptionData["ciphering"];
        $options = $encryptionData["options"];
        $iv = $encryptionData["iv"];
        $key = $encryptionData["key"];
        
        $decryption = openssl_decrypt($encrypted_string, $ciphering, $key, $options, $iv);
        $decryption = mb_convert_encoding($decryption, 'UTF-8', 'UTF-8');
        return $decryption;
    }
}

if (!function_exists('roleHasPermission')) {
    function roleHasPermission($role_id, $permission){
        $role = Role::find($role_id);
        $guard_name = $role->guard_name;
        $permission_id = 0;
        $permission = Permission::whereName($permission)->where('guard_name', $guard_name)->first();
        if($permission){
            $permission_id = $permission->id;
        }
        $role = RoleHasPermission::whereRoleId($role_id)->wherePermissionId($permission_id)->first();
        if($role){
            return 'checked';
        }
    }
}
function viewImage($image_url){
    if(file_exists(public_path($image_url))){
        return $image_url;
    }else{
        return config('constant.dummy_image');
    }
}
function roundOff($number, $upto = 2){
    setlocale(LC_NUMERIC, 'en_US.UTF-8'); // Adjust the locale accordingly
    return rtrim(rtrim(number_format($number, 2, '.', ''), '0'), '.'); // 9322
}

function page($data){
    $total = $data->total();
    $last_page = $data->lastPage();
    $current_page = $data->currentPage();
    $per_page = $data->perPage();  
    $second_last_page = 1;
    $from = 1;
    $to = $current_page*$per_page;
    $p = $last_page*$per_page;
    $extra_number = $p - $total;          
    if($current_page > 1){
        $second_last_page = $current_page-1;
        $from = $second_last_page*$per_page; 
    }
    if($current_page == $last_page){
        $to = $to - $extra_number;
    }
    return ['total' => $total, 'from' => $from, 'to' => $to, 'current_page' => $current_page, 'last_page' => $last_page];
}