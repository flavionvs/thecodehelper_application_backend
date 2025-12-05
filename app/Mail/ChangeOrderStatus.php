<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ChangeOrderStatus extends Mailable
{
    use Queueable, SerializesModels;
    public $order_detail;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($order_detail)
    {
        $this->order_detail = $order_detail;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $order_detail = $this->order_detail;
        if($order_detail->status == 'Failed'){
            $subject = 'Order Failed';
            $view = 'mail.order-failed';
        }elseif($order_detail->status == 'Cancelled'){
            $subject = 'Order Cancelled';
            $view = 'mail.order-cancelled';
        }elseif($order_detail->status == 'Refund'){
            $subject = 'Order Refunded';
            $view = 'mail.order-refunded';
        }elseif($order_detail->status == 'Completed'){
            $subject = 'Order Completed';
            $view = 'mail.order-completed';
        }
        return $this->view($view, ['order_detail'=>$order_detail])->subject($subject)->from('info@gmarto.com');
    }
}
