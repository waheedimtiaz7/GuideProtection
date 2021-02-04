<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    public function order_detail(){
        return $this->hasMany(OrderDetail::class);
    }
    public function shop(){
        return $this->belongsTo(Shop::class);
    }
}
