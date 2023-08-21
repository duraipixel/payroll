<?php

namespace App\Models\Staff;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffSalaryPreEarning extends Model
{
    use HasFactory;

    protected $fillable = [
        'academic_id',
        'staff_id',
        'salary_month',
        'amount',
        'remarks',
        'earnings_type',
        'status',
        'added_by',
        'is_verified'
    ];

}
