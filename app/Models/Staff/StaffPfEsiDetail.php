<?php

namespace App\Models\Staff;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class StaffPfEsiDetail extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'academic_id',	
        'staff_id',
        'ac_number',	
        'type',	
        'start_date',	
        'end_date',	
        'location',	
        'description',	
        'status',
        'name',
        'document'
    ];
}
