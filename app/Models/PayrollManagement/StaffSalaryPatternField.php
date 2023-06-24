<?php

namespace App\Models\PayrollManagement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StaffSalaryPatternField extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'staff_id',
        'staff_salary_pattern_id',
        'field_id',
        'field_name',
        'amount',
        'percentage',
        'reference_type',
        'reference_id'
    ];

}
