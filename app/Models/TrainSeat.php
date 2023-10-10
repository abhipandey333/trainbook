<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainSeat extends Model
{
    use HasFactory;

    public $fillable = [
        'seats_count'
    ];

    public $timestamps = false;
}
