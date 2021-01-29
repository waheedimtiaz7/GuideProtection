<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Claim extends Model
{
    use HasFactory;
    protected $fillable=[
        'incident_type',
        'incident_description',		
        'shop_id',
        'store_id',
        'store_ordernumber',
        'cart_ordernumber',
        'cart_trackingnumber',
        'order_id',
        'orderdate',
        'customer_reported_trackno',
        'customer_firstname',
        'customer_lastname',
        'customer_email',
        'customer_phone',
        'shipping_addresss_1',
        'shipping_addresss_2',
        'shipping_city',
        'shipping_state',
        'shipping_zip',
        'shipping_country',
        'shipping_carrier_method',
        'reorder_trackingnumber',
        'reorder_cartnumber',
        'reorder_storenumber',
        'reorder_status',
        'claim_status',
        'claim_rep',
        'gp_origord_shiptrackno',
        'gp_reorderno',
        'gp_reorder_trackno',
        'hold_until_date',
        'escalate',
        'notes'
    ];
    public function order(){
        return $this->belongsTo(Order::class);
    }
    public function claim_detail(){
        return $this->hasMany(ClaimOrderDetail::class);
    }
    public function claimStatus(){
        return $this->belongsTo(Status::class,'claim_status','value')->where('type','claim');
    }
    public function reorderStatus(){
        return $this->belongsTo(Status::class,'reorder_status','value')->where('type','re-order');
    }
    public function incidentType(){
        return $this->belongsTo(Status::class,'incident_type','value')->where('type','incident-type');
    }
    public function files(){
        return $this->hasMany(ClaimFile::class);
    }
    public function shop(){
        return $this->belongsTo(Shop::class);
    }
    public function representative(){
        return $this->belongsTo(User::class,'claim_rep');
    }
}
