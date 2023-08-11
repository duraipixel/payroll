<?php

namespace App\Models\PayrollManagement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffSalaryField extends Model
{
    use HasFactory;

    protected $fillable = [
        'staff_id',
        'staff_salary_id',
        'field_id',
        'field_name',
        'amount',
        'percentage',
        'reference_type',
        'reference_id',
        'short_name'
    ];

}
