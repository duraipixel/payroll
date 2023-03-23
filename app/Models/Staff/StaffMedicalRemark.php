<?php

namespace App\Models\Staff;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffMedicalRemark extends Model
{
    use HasFactory;

    protected $fillable = [
        'academic_id',	
        'staff_id',	
        'medic_date',	
        'reason',	
        'medic_documents'
    ];
}
