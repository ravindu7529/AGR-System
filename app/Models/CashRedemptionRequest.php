<?php
// app/Models/CashRedemptionRequest.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashRedemptionRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'guide_id',
        'amount',
        'status',
        'admin_notes',
        'approved_by',
        'approved_at'
    ];

    protected $casts = [
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