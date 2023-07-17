<?php

namespace App\Models\Leave;

use App\Models\AttendanceManagement\LeaveMapping;
use App\Models\Scopes\AcademicScope;
use App\Models\Scopes\InstitutionScope;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StaffLeave extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'academic_id',
        'staff_id',
        'application_no',
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
        'approved_date',
        'rejected_date',
        'granted_designation',
        'reporting_id',
        'document',
        'status',
        'addedBy',
        'approved_document'
    ];

    public function scopeAcademic($query)
    {
        if( session()->get('academic_id') && !empty( session()->get('academic_id') ) ){

            return $query->where('staff_leaves.academic_id', session()->get('academic_id'));
        }
    }

    public function staff_info()
    {
        return $this->hasOne(User::class, 'id', 'staff_id');
    }

    public function granted_info()
    {
        return $this->hasOne(User::class, 'id', 'granted_by');
    }

    public function reporting_info()
    {
        return $this->hasOne(User::class, 'id', 'reporting_id');
    }

    public function leaveMapping() {
        return $this->hasOne(LeaveMapping::class, 'id', 'leave_category_id');
    }
    
}
