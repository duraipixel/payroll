<?php

namespace App\Models\PayrollManagement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Database\Eloquent\SoftDeletes;

class StaffSalary extends Model
{
    use HasFactory;
    use SoftDeletes;

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
        'status',
        'salary_pattern_id',
        'document',
        'payroll_id',
        'working_days',
        'worked_days',
        'leave_days',
        'other_description',
        'employee_description',
        'salary_date'
    ];

    public function fields()
    {
        return $this->hasMany(StaffSalaryField::class, 'staff_salary_id', 'id');
    }

    public function earnings()
    {
        return $this->hasMany(StaffSalaryField::class, 'staff_salary_id', 'id')->where('reference_type', 'EARNINGS');
    }

    public function deductions()
    {
        return $this->hasMany(StaffSalaryField::class, 'staff_salary_id', 'id')->where('reference_type', 'DEDUCTIONS');
    }
    public function salaryApprovedBy()
    {
        return $this->hasOne(User::class, 'id', 'salary_approved_by');
    }

    public function staff() {
        return $this->hasOne(User::class, 'id', 'staff_id' );
    }
}
