<?php

namespace App\Models\PayrollManagement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffSalary extends Model
{
    use HasFactory;

    protected $fillable = [
        'staff_id',
        'salary_no',
        'total_earnings',
        'total_deductions',
        'gross_salary',
        'net_salary',
        'salary_month',
        'salary_year',
        'is_salary_processed',
        'salary_approved_by',
        'salary_processed_on',
        'status'
    ];

    public function fields()
    {
        return $this->hasMany(StaffSalaryField::class, 'staff_salary_id', 'id');
    }

}
