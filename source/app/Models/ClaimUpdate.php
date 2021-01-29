<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClaimUpdate extends Model
{
    use HasFactory;
    protected $fillable=[
        'claim_id',
        'updated_by',
        'column_name',
        'original_value',
        'updated_value',
        'detail',
        'date_updated',
    ];
}
