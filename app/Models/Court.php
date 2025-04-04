<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Court extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'region_id', 'manager_id'];

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function manager()
    {
        return $this->belongsTo(User::class);
    }
}
