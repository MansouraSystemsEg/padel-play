<?php

namespace App\Enums;

enum BookingStatus: string
{
    case Requested = 'requested';
    case Confirmed = 'confirmed';
    case Cancelled = 'cancelled';
}