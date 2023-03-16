<?php

namespace App\Models\Staff;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffProfessionalData extends Model
{
    use HasFactory;

    protected $table = 'staff_professional_datas';

    protected $fillable = [
        'academic_id',
        'staff_id',
        'designation_id',
        'department_id',
        'subject_id',
        'attendance_scheme_id',
        'status'
    ];
}
