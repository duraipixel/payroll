<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class AttendanceScheme extends Model implements Auditable
{
    use HasFactory,SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'academic_id',	
        'name',
        'institute_id',
        'scheme_code',
        'start_time',
        'end_time',
        'totol_hours',
        'late_cutoff_time',
        'permission_cutoff_time',
        'sort_order',	
        'status'
    ];
}
