<?php

namespace App\Models\AttendanceManagement;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AttendanceManualEntry extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'academic_id',
        'employment_id',
        'attendance_date',
        'reporting_manager',
        'attendance_status',
        'absent_status',
        'reason',
        'sort_order',
        'reason',
        'status',
        'from_time',
        'to_time',
        'total_time',
        'total_worked',
        'duty_duration',
        'break_out',
        'break_in',
        'break_duration',
        'actual_break',
        'mode',
        'attendance_status_id',
        'other_status',
        'clock_in',
        'clock_out',
        'total_clocked_time',
        'unscheduled',
        'api_response'
    ];

    public function reportingManager() {
        return $this->hasOne( User::class, 'reporting_manager', 'id' );
    }

    public function user() {
        return $this->belongsTo( User::class, 'employment_id', 'id' );
    }
   
}
