<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CellDownLog extends Model
{
    use HasFactory;
    protected $table = 'cell_down_log';

    protected $fillable = [
        'code',
        'vender',
        'remark',
        'type',
        'time_down_cell',
        'date_down_cell',
        'reported_to',
        'reported_by',
        'site_name',
        'l_1escalation',
        'l_2escalation',
        'l_3escalation',
        'down_cell_name',
        'region',
        'status',
        'cell_status',
        'fault_type',
        'date_of_clear',
        'fault_clear_action',
        'inoc_tl_name',
        'remark_clear',
        'cell_up_reported_by',
        'created_at',
        'updated_at'
    ];
}
