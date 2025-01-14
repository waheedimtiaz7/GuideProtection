<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;
    protected $fillable=[
        'display_name',
        'store_name',
        'company_name',
        'store_processing',
        'url',
        'alex_rank',
        'shopify_name',
        'category_id',
        'sales_rep',
        'paypal_account',
        'variant_id_link_base',
        'ups_acc_no',
        'fedex_acc_no',
        'usps_acc_no',
        'dhl_acc_no',
        'other_acc_no',
        'primary_poc_firstname',
        'primary_poc_lastname',
        'primary_poc_phone',
        'primary_poc_email',
        'primary_poc_title',
        'support_issue',
        'notes',
        'setup_status',
        'date_installed',
        'date_uninstalled',
    ];
    public function categories(){
        return $this->belongsToMany(Category::class);
    }
    public function rep(){
        return $this->belongsTo(User::class,'sales_rep');
    }
}
