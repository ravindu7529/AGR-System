<?php


// app/Models/Redemption.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Guide;
use App\Models\Item;

class Redemption extends Model
{
    use HasFactory;

    protected $fillable = [
        'guide_id',
        'points',
        'reserved_points',
        'redeemed_at',
    ];

    protected $dates = ['redeemed_at'];

    // Relationships
    public function guide()
    {
        return $this->belongsTo(Guide::class);
    }
    public function item()
    {
        return $this->belongsTo(Item::class);
    }
    public function getAvailablePointsAttribute()
    {
        return $this->points - $this->reserved_points;
    }
}

