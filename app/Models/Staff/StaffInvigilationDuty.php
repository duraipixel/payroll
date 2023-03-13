<?php

namespace App\Models\Staff;

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
}
