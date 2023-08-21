<?php

namespace App\Models\Staff;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffSalaryPreDeduction extends Model
{
    use HasFactory;

    protected $fillable = [
        'academic_id',
        'staff_id',
        'salary_month',
        'amount',
        'remarks',
        'deduction_type',
        'status',
        'added_by',
        'is_verified'
    ];

}
