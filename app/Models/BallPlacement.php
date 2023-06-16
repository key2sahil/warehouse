<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BallPlacement extends Model
{
    use HasFactory;

    protected $fillable = [
        'ball_id',
        'total_balls',
    ];
}
