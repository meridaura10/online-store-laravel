<?php

namespace App\Enums\Payment\Fondy;


enum FondyStatusEnum:string {
    case Created = "created";
    case Processing = "processing";
    case Declined = "declined";
    case Approved = "approved";
    case Expired = "expired";
    case Reversed = "reversed";
}
