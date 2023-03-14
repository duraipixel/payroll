<?php

namespace App\Models\Staff;

use App\Models\Master\DutyClass;
use App\Models\Master\OtherSchool;
use App\Models\Master\OtherSchoolPlace;
use App\Models\Master\TypeOfDuty;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffInvigilationDuty extends Model
{
    use HasFactory;

    protected $fillable = [
        'academic_id',
        'staff_id',
        'class_id',
        'type_of_duty_id',
        'school_id',
        'school_place_id',
        'from_date',
        'to_date',
        'facility',
        'status'
    ];

    function classes() {
        return $this->hasOne(DutyClass::class, 'id', 'class_id');
    }

    function dutyType()
    {
        return $this->hasOne(TypeOfDuty::class, 'id', 'type_of_duty_id');
    }

    public function school()
    {
        return $this->hasOne(OtherSchool::class, 'id', 'school_id');
    }

    public function place()
    {
        return $this->hasOne(OtherSchoolPlace::class, 'id', 'school_place_id');
    }

}
