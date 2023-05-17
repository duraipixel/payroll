<?php

namespace App\Models\AttendanceManagement;

use App\Models\AcademicYear;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\AttendanceManagement\LeaveHead;
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

    public function leave_head()
    {
        return $this->hasOne(LeaveHead::class, 'id','leave_head_id');
    }

    public function academy()
    {
        return $this->hasOne(AcademicYear::class, 'id', 'academic_id');
    }
}
