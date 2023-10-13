<?php

namespace App\Enums\Payment;

enum PaymentStatusEnum: string{
    case Waiting = 'waiting for payment';
    case Successful = 'successful';
    case Declined = 'declined';
}