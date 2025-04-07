<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusinessCustomer extends Model
{
    protected $table = 'business_customers';

    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    public function relationManager()
    {
        return $this->belongsTo(RelationManager::class, 'rm_id', 'id');
    }
}
