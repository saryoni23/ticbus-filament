<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tiket extends Model
{
    use HasFactory;

    protected $fillable = 
        [
            'categori_id',
            'rute_id',
            'name',
            'slug',
            'images',
            'description',
            'price',
            'is_active'
        ];

    protected $casts = [
        'images' => 'array',
    ];

    public function categori(){
        return $this->belongsTo(Categori::class);
    }
    public function rute()
    {
        return $this->belongsTo(Rute::class);
    }
    public function orderItems(){
        return $this->hasMany(OrderItem::class);
    }
}
