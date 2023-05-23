<?php

namespace App\Models\Staff;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffInsurance extends Model
{
    use HasFactory;

    protected $fillable = [
        'staff_id',	
        'insurance_name',
        'policy_no',	
        'amount',	
        'maturity_date',	
        'completed_date',	
        'file',	
        'status'
    ];

}
