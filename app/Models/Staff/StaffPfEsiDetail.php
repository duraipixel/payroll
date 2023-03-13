<?php

namespace App\Models\Staff;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffPfEsiDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'academic_id',	
        'staff_id',
        'ac_number',	
        'type',	
        'start_date',	
        'end_date',	
        'location',	
        'description',	
        'status'
    ];
}
