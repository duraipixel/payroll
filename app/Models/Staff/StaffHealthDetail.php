<?php

namespace App\Models\Staff;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffHealthDetail extends Model
{
    use HasFactory;

    protected $table = 'staff_health_details';

    protected $fillable = [
        'academic_id',	
        'staff_id',	
        'bloodgroup_id',	
        'height',	
        'weight',	
        'identification_mark',	
        'identification_mark1',	
        'identification_mark2',	
        'disease_allergy',	
        'differently_abled',	
        'family_doctor_name',	
        'family_doctor_contact_no'
    ];
}
