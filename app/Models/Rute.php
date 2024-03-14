<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rute extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'tiket_id',
        'tujuan',
        'start',
        'end',
        'harga',
        'jam',
        'is_active',
    ];
    public function tipebus(){
        return $this->belongsTo(Tipebus::class);
    }
    public function tiket()
    {
        return $this->belongsTo(tiket::class);
    }
    public function orderItems(){
        return $this->hasMany(OrderItem::class);
    }
    public function order(){
        return $this->hasMany(OrderItem::class);
    }
}
