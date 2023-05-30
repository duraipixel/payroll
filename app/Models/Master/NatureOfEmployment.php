<?php

namespace App\Models\Master;

use App\Models\Staff\StaffAppointmentDetail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class NatureOfEmployment extends Model implements Auditable
{
    use HasFactory,SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'academic_id',	
        'institute_id',
        'name',
        'sort_order',	
        'status'
    ];

    public function appointments()
    {
        return $this->hasMany(StaffAppointmentDetail::class, 'nature_of_employment_id', 'id');
    }
    
}
