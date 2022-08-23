<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voyages extends Model
{
    use HasFactory;

    protected $fillable = [
      'vessel_id',
      'departure_city',
      'arrival_city',
      'departure_date',
      'departure_time',
      'arrival_date',
      'arrival_time',
    ];
}
