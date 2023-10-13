<?php

namespace App\Enums\Payment;

enum PaymentTypeEnum: string
{
    case Cash = 'cash';
    case Card  = 'card';
}