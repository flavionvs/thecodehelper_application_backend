<?php

namespace App\Console\Commands;

use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MeetingAlert extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:meeting-alert';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'It will send an alert to the user that the meeting is about to start.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        DB::BeginTransaction();
        try{
            $bookings = Booking::whereStatus('Pending')->get();
            if($bookings){
                foreach($bookings as $item){                
                    $now = Carbon::now();
                    $start_time = Carbon::parse(date('Y-m-d H:i:s', strtotime($item->date.' '.$item->from_time)));
                    $end_time = Carbon::parse(date('Y-m-d H:i:s', strtotime($item->date.' '.$item->to_time)));
                    $diffInMinutes = $now->diffInMinutes($start_time);                    
                    if($now < $start_time && $now < $end_time && $diffInMinutes < 45 && $item->alert == '0'){                        
                        $item->alert = '1';                    
                        $item->save();    
                        $array = ['booking_id' => $item->id];  
                        sendMail($array, 'meeting-alert');                             
                    }
                }
            }
            DB::commit();            
        }catch(\Exception $e){

        }
    }
}
