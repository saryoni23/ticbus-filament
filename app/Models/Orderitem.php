<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orderitem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'rute_id',
        'jumlah_tiket',
        'harga',
        'harga_total',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function rute()
    {
        return $this->belongsTo(Rute::class);
    }

}
