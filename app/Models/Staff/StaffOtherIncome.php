<?php

namespace App\Models\Staff;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StaffOtherIncome extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'academic_id',	
        'financial_start',	
        'financial_end',	
        'other_income_id',	
        'remarks',	
        'amount',	
        'status',	
        'added_by',	
        'updated_by',
        'staff_id'
    ];

}
