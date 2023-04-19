<?php

namespace App\Models\AttendanceManagement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LeaveMapping extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'academic_id',
        'nature_of_employment_id',
        'leave_head_id',
        'leave_days',
        'carry_forward',
        'sort_order',
        'status'
    ];
}
