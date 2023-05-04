<?php

namespace App\Models\Leave;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffLeave extends Model
{
    use HasFactory;

    protected $fillable = [
        'academic_id',
        'staff_id',
        'designation',
        'place_of_work',
        'salary',
        'leave_category',
        'from_date',
        'to_date',
        'no_of_days',
        'holiday_date',
        'holiday_date2',
        'holiday_date3',
        'no_of_holidays',
        'leave_category_id',
        'reason',
        'address',
        'is_granted',
        'granted_start_date',
        'granted_end_date',
        'granted_days',
        'remarks',
        'granted_by',
        'granted_designation',
        'reporting_id',
        'document',
        'status',
        'addedBy'
    ];
}
