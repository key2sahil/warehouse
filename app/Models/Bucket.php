<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bucket extends Model
{
    use HasFactory;
    protected $fillable = ['bucket_name', 'bucket_total_volume', 'bucket_filled_volume'];

}
