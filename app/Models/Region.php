<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Region extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'parent_id', 'manager_id'];

    public function parent()
    {
        return $this->belongsTo(Region::class);
    }

    public function children()
    {
        return $this->hasMany(Region::class, 'parent_id');
    }

    public function manager()
    {
        return $this->belongsTo(User::class);
    }

    public function courts()
    {
        return $this->hasMany(Court::class);
    }
}
