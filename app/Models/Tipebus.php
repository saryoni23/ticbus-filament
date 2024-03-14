<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tipebus extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'slug', 'image', 'is_active'];


    public function tiket()
    {
        return $this->hasMany(Tiket::class);
    }
    public function tipebus()
    {
        return $this->hasMany(Tipebus::class);
    }
}
