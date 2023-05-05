<?php

namespace App\Models\Staff;

use App\Models\Master\Designation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class StaffProfessionalData extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'staff_professional_datas';

    protected $fillable = [
        'academic_id',
        'staff_id',
        'designation_id',
        'department_id',
        'division_id',
        'subject_id',
        'attendance_scheme_id',
        'status',
        'is_teaching_staff'
    ];

    public function designation()
    {
        return $this->hasOne(Designation::class, 'id', 'designation_id');
    }
}
