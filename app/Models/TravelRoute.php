<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TravelRoute extends Model
{
    // Hatanın sebebi bu satırın eksik olması olabilir:
    protected $fillable = ['user_id', 'title', 'city', 'start_date', 'description'];
}