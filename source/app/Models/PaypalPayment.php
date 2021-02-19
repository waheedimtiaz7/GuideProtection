<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaypalPayment extends Model
{
    use HasFactory;
    protected $fillable=[
        'payout_batch_id',
        'batch_status',
        'sender_batch_header',
        'link',
        'claim_id',
        'shop_id'
    ];
}
