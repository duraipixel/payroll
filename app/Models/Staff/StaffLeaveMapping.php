<?php

namespace App\Models\Staff;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\AttendanceManagement\LeaveHead;
use App\Models\User;
use App\Models\AcademicYear;
use App\Models\CalenderYear;
class StaffLeaveMapping extends Model
{
    use HasFactory;

    protected $fillable = ['staff_id','leave_head_id','no_of_leave_actual','carry_forward_count','no_of_leave','acadamic_id','calender_id','accumulated','availed'];

    public function leave_head()
    {
        return $this->hasOne(LeaveHead::class, 'id','leave_head_id');
    }
    public function staff_info()
    {
        return $this->hasOne(User::class, 'id', 'staff_id');
    }
    public function academicYaer()
    {
        return $this->hasOne(AcademicYear::class, 'id', 'acadamic_id');
    }
     public function calanderYear()
    {
        return $this->hasOne(CalenderYear::class, 'id', 'calender_id');
    }
     public function elentries()
    {
        return $this->hasMany(StaffELEntry::class, 'leave_mapping_id', 'id');
    }
    

}
