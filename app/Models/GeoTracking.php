<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeoTracking extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'latitude', 'longitude', 'attendence_id'];

}
