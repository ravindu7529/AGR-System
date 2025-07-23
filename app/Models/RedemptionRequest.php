<?php
// app/Models/RedemptionRequest.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RedemptionRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'guide_id',
        'item_ids',
        'item_details',
        'total_points',
        'status',
        'admin_notes',
        'approved_by',
        'approved_at'
    ];

    protected $casts = [
        'item_ids' => 'array',
        'item_details' => 'array',
        'approved_at' => 'datetime'
    ];

    public function guide()
    {
        return $this->belongsTo(Guide::class);
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'approved_by');
    }
}