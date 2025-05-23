<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classification extends Model
{
    protected $fillable = ['name', 'type'];

    public function bids()
    {
        return $this->belongsToMany(Bid::class)->withTimestamps();
    }
}
