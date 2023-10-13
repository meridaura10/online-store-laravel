<?php

namespace App\Enums\Payment;

enum PaymentSystemEnum: string
{
    case Fondy = 'fondy';
    case LiqPay = 'liqPay';
}