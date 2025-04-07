<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendence extends Model
{
    protected $fillable = ['user_id', 'date', 'check_in', 'check_out', 'status'];
}
