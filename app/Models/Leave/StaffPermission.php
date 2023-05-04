<?php

namespace App\Models\Leave;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffPermission extends Model
{
    use HasFactory;

    protected $fillable = [
        'academic_id',
        'staff_id',
        'designation',
        'permission_date',
        'from_time',
        'to_time',
        'no_of_minutes',
        'reason',
        'granted_at',
        'granted_by',
        'reporting_id',
        'document',
        'status',
        'addedBy'
    ];
}
