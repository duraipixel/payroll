<?php

namespace App\Models\Staff;

use App\Models\Master\Designation;
use App\Models\Master\OtherSchool;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class StaffWorkExperience extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'academic_id', 
        'staff_id',
        'status',
        'institue_id', 
        'designation_id',
        'from',
        'to',
        'period',
        'address_id',
        'address',
        'salary_drawn',
        'experience_year',
        'experience_month',
        'remarks',
        'doc_file'
    ];

    public function institute()
    {
        return $this->hasOne(OtherSchool::class, 'id', 'institue_id');
    }

    public function designation()
    {
        return $this->hasOne(Designation::class, 'id', 'designation_id');
    }
}
