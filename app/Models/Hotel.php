<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    use HasFactory;

    // Bu satırı ekleyerek Laravel'e bu alanların doldurulabilir olduğunu söylüyoruz
    protected $fillable = [
        'name',
        'city',
        'price',
        'image',
        'description',
        'stars'
    ];
}