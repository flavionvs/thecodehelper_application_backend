<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiChatController extends Controller
{
    public function getMessage($user_id){        
        $messages = Message::where(function($q) use($user_id){
                        $q->where('from', $user_id)->where('to', authId());
                    })->orWhere(function($q) use($user_id){
                        $q->where('from', authId())->where('to', $user_id);
                    })->orderByDESC('id')->paginate(20);            
        $data = [];
        foreach($messages as $message){           
            $arr = $message->toArray();
            $arr['created_at'] = timeFormat($message->created_at);
            $arr['file'] = $message->file ? img($message->file) : null;
            $data[] = $arr;
        
        }        
        return response()->json([
                    'status' => true, 
                    'message' => 'Messages fetched successfully.', 
                    'data' => array_reverse($data),
                    'next_page_url' => $messages->nextPageUrl(),
                    'has_more' => $messages->hasMorePages()
                ]);
    }

    public function sendMessage(Request $request){
        $from = authId();
        $to = $request->to;        
        $message = $request->message;
        
        // Handle file upload
        $file = null;
        if ($request->hasFile('file')) {
            $file = fileSave($request->file('file'), 'upload/chat');
        }
        
        $insertId = DB::table('messages')->insertGetId([
            'from' => $from,
            'to' => $to,
            'message' => $message,
            'file' => $file,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        $fileUrl = $file ? img($file) : null;
        
        return response()->json([
            'status' => true,
            'message' => 'Messages sent successfully.',
            'data' => [
                'id' => $insertId,
                'from' => $from,
                'to' => $to,
                'message' => $message,
                'created_at' => now()->format('Y-m-d H:i:s'),
                'file' => $fileUrl
            ],
        ]);
    }

    public function getChatUsers(){
        $authId = authId();
        if(request()->freelancer_id){
            $chatUsers = User::where('id', request()->freelancer_id)->get();
        }else{
            $messages = Message::where('from', $authId)
                ->orWhere('to', $authId)
                ->selectRaw('
                    CASE 
                        WHEN `from` = ? THEN `to` 
                        ELSE `from` 
                    END as user_id', [$authId])
                ->groupBy('user_id')
                ->pluck('user_id');
            
            // Now fetch users
            $chatUsers = User::whereIn('id', $messages)->get();
        }
        $data = [];        
        foreach($chatUsers as $item){
            $count = Message::where('from', $item->id)
                            ->where('to', authId())
                            ->where('is_read', 0)
                            ->count();
            
           if(authUser()->role == 'Client'){
            $application = DB::table('applications')
                            ->join('projects','projects.id','applications.project_id')
                            ->where('projects.user_id', authId())
                            ->where('applications.user_id', $item->id)
                            ->where('applications.status','Approved')
                            ->select('projects.title')
                            ->get();  
            $username = authUser()->first_name;         
            }elseif(authUser()->role == 'Freelancer'){
               $application = DB::table('applications')
                               ->join('projects','projects.id','applications.project_id')
                               ->where('projects.user_id', $item->id)
                               ->where('applications.user_id', authId())
                               ->where('applications.status','Approved')
                               ->select('projects.title')
                               ->get();           
            $username = DB::table('users')->where('id', $item->id)->value('first_name') ?? null;
           }
           
            $project_names = '';
            foreach($application as $key => $app){
                if($key == 0){
                    $project_names .= $app->title;
                }else{
                    $project_names .= ', '.$app->title;
                }
            }

            $data[] = [
                'id' => $item->id,
                'first_name' => $item->first_name,
                'project_names' => $project_names,
                'count' => $count,
                'image' => img($item->image),
            ];
        }
        
        return response()->json([
            'status' => true,
            'data' => $data
        ]);
        
    }

    public function updateCount(){
        Message::where('from', request()->user_id)
        ->where('to', authId())
        ->where('is_read', 0)
        ->update(['is_read' => 1]);
    }
    
}