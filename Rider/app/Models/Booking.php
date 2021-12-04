<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use HasFactory, SoftDeletes;

    public $fillable = [
        'rider_id',
        'status',
        'bus_id',
        'trip_id',
    ];

    public function rider()
    {
        return $this->belongsTo(Rider::class);
    }

    public function bus()
    {
        return $this->belongsTo(Bus::class);
    }

    // public function trip()
    // {
    //     return $this->hasOne(Trip::class, 'trip_id');
    // }
}
