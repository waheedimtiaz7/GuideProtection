<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShopPrice extends Model
{
    use HasFactory;
    protected $fillable=[
        'title',
        'range_from',
        'range_to',
        'shop_id',
        'price',
        'guide_price'
    ];
}
