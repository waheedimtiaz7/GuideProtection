<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportQuery extends Model
{
    protected $table = 'report_queries';
    public $timestamps = false;

    protected $fillable = [
        'ReportName',
        'Query',
        'param1type',
        'param2type',
        'param3type',
        'param4type',
        'param5type',
        'param1data',
        'param2data',
        'param3data',
        'param4data',
        'param5data',
        'param1name',
        'param2name',
        'param3name',
        'param4name',
        'param5name',
        'filename',
        'description',
        'QueryForExport',
        'param1default',
        'param2default',
        'param3default',
        'param4default',
        'param5default',
    ];
}
