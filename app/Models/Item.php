<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Redemption;

class Item extends Model
{
    //
    protected $fillable = ['name', 'points'];

    public function redemptions()
    {
        return $this->hasMany(Redemption::class);
    }
}
