<?php

namespace App\Models\Staff;

use App\Models\AttendanceManagement\LeaveMapping;
use App\Models\Master\AppointmentOrderModel;
use App\Models\Master\Designation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use App\Models\Master\NatureOfEmployment;
use App\Models\Master\PlaceOfWork;
use App\Models\Master\StaffCategory;
use App\Models\Master\TeachingType;
use App\Models\User;
use Illuminate\Database\Eloquent\SoftDeletes;

class StaffAppointmentDetail extends Model implements Auditable
{
    use HasFactory, SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'academic_id',	
        'staff_id',	
        'category_id',	
        'nature_of_employment_id',	
        'teaching_type_id',	
        'place_of_work_id',	
        'joining_date',	
        'salary_scale',	
        'from_appointment',	
        'to_appointment',	
        'appointment_order_model_id',	
        'has_probation',
        'probation_period',
        'probation_order_no',
        'probation_order_date',
        'appointment_doc',
        'appointment_order_no',
        'status',
        'is_till_active',
        'institution_id',
        'designation_id',
        'department_id',
        'attendance_scheme_id',
        'previous_appointment_number',
        'previous_appointment_date',
        'previous_designation'
    ];

    public function designation() {
        return $this->hasOne(Designation::class, 'id','designation_id');
    }

    public function employment_nature()
    {
        return $this->hasOne(NatureOfEmployment::class, 'id','nature_of_employment_id');
    }

    public function staff_det()
    {
        return $this->hasOne(User::class, 'id', 'staff_id');
    }


    public function work_place()
    {
        return $this->hasOne(PlaceOfWork::class, 'id', 'place_of_work_id');
    }

    public function staffCategory()
    {
        return $this->hasOne(StaffCategory::class, 'id', 'category_id');
    }

    public function teachingType()
    {
        return $this->hasOne(TeachingType::class, 'id', 'teaching_type_id');
    }

    public function appointmentOrderModel()
    {
        return $this->hasOne(AppointmentOrderModel::class, 'id', 'appointment_order_model_id');
    }

    public function leaveAllocated()
    {
        return $this->hasMany(LeaveMapping::class, 'nature_of_employment_id', 'nature_of_employment_id');
    }

    public function leaveAllocatedYear()
    {
        return $this->hasMany(LeaveMapping::class, 'nature_of_employment_id', 'nature_of_employment_id')
                ->groupBy('nature_of_employment_id', 'academic_id')
                ->selectRaw('sum(CAST(leave_mappings.leave_days AS DECIMAL(10, 2))) as total_leave, nature_of_employment_id, academic_id');
    }
}
