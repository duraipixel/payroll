<?php

namespace App\Models\Staff;

use App\Models\User;
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

    public function staff() {
        return $this->hasOne(User::class, 'id', 'staff_id');
    }

}
