<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Order extends Model
{
    use HasFactory;

    protected static function booted()
    {
        static::creating(function ($model) {
            $model->kode = Str::random(8); // Menggunakan fungsi Str::random() untuk membuat kode acak
        });
    } 
    protected $fillable = [
        'user_id',
        'kode',
        'kursi',
        'waktu',
        'total',
        'status',
        'notes'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items(){
        return $this->hasMany(OrderItem::class);
    }

    public function rute()
    {
        return $this->belongsTo(Rute::class);
    }
}
