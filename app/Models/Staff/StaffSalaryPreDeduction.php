<?php

namespace App\Models\Staff;

use App\Models\User;
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
        'deduction_type', //'loan', 'insurance', 'contribution', 'arrear', 'other'
        'status', //'active', 'inactive', 'paid'
        'added_by',
        'is_verified' //'yes', 'no'
    ];

    public function staff() {
        return $this->hasOne(User::class, 'id', 'staff_id');
    }

}
