<?php

namespace App\Models\Staff;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffTaxSeperation extends Model
{
    use HasFactory;

    protected $fillable = [
        'academic_id',	
        'staff_id',	
        'income_tax_id',	
        'april',	
        'may',	
        'june',	
        'july',	
        'august',	
        'september',	
        'october',	
        'november',	
        'december',	
        'january',	
        'february',	
        'march',	
        'total_tax',	
        'balance',	
        'status',	
        'verification_status',	
        'approved_at',	
        'rejected_at',	
        'approved_by',	
        'rejected_by'
    ];

}
