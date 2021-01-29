<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClaimOrderDetail extends Model
{
    use HasFactory;
    protected $fillable=[
      "claim_id",
      "order_detail_id",
      "quantity",
      "variantid",
      "product_id"
    ];
}
