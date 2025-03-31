<?php

namespace App\Models;

use App\Enums\BookingStatus;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = ['court_id', 'player_id', 'coach_id', 'starts_at', 'ends_at', 'status'];

    protected function casts(): array
    {
        return [
            'starts_at' => 'datetime',
            'ends_at' => 'datetime',
            'status' => BookingStatus::class,
        ];
    }
}
