<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trackings extends Model
{
    use HasFactory;

    protected $fillable = [
      'voyage_id',
      'city',
      'arrival_date',
      'arrival_time'
    ];
}
