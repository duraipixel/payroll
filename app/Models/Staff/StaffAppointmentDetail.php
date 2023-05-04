<?php

namespace App\Models\Staff;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use App\Models\Master\NatureOfEmployment;

class StaffAppointmentDetail extends Model implements Auditable
{
    use HasFactory;
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
        'appointment_doc',
        'status'
    ];
    public function employment_nature()
    {
        return $this->hasOne(NatureOfEmployment::class, 'id','nature_of_employment_id');
    }
}
