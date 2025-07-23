<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use App\Models\Visit;
use App\Models\Redemption;

class Guide extends Model
{
    use HasFactory;
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'full_name',
        'mobile_number',
        'date_of_birth',
        'email',
        'profile_photo',
        'whatsapp_number',
    ];

    // One guide has many visits
    public function visits()
    {
        return $this->hasMany(Visit::class);
    }

    // One guide has many redemptions
    public function redemptions()
    {
        return $this->hasMany(Redemption::class);
    }

    // Calculate total visits
    public function totalVisits()
    {
        return $this->visits()->count();
    }

    // Calculate total tourists (sum of pax)
    public function totalTourists()
    {
        return $this->visits()->sum('pax_count');
    }

    // Calculate total points earned
    public function totalPoints()
    {
        return ($this->totalVisits() * 10) + ($this->totalTourists() * 5);
    }

    // Calculate points redeemed
    public function pointsRedeemed()
    {
        return $this->redemptions()->sum('points');
    }

    // Points left = earned - redeemed
    public function pointsRemaining()
    {
        $redemption = $this->redemptions()->first();
        return $redemption ? $redemption->points : 0;
    }
}
