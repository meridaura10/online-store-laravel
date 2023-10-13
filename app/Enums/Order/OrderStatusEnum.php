<?php

namespace App\Enums\Order;

enum OrderStatusEnum: string
{
    
    case Finished = 'finished';
    case Approved = 'approved';
    case Sent = 'sent';
    case Arrived = 'arrived';
    case paymentWaiting = 'waiting for payment';
    case Processed  = "processed";
    case Declined = 'declined';
}
