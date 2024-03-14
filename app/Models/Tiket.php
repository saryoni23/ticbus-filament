<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Filament\Models\FilamentModel;
use Illuminate\Support\Str;

class Tiket extends Model
{
    use HasFactory;
    protected static function booted()
        {
            static::creating(function ($model) {
                $model->kode = Str::random(8); // Menggunakan fungsi Str::random() untuk membuat kode acak
            });
        } 

    protected $fillable = 
        [
            'name',
            'kode',
            'jumlah_tiket',
            'images',
            'tipebus_id',
            'is_active'
        ];

    protected $casts = [
        'images' => 'array',
    ];


    public function tipebus(){
        return $this->belongsTo(Tipebus::class);
    }
    public function rute()
    {
        return $this->belongsTo(Rute::class);
    }
    public function orderItems(){
        return $this->hasMany(OrderItem::class);
    }
    public function order(){
        return $this->hasMany(OrderItem::class);
    }
}
