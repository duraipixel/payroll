<?php

namespace App\Models\Staff;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
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
        'status', //'active', 'inactive', 'completed'
        'start_date',
        'end_date',
        'period_of_loans',
        'insurance_due_type',
        'every_month_amount'
    ];

    public function emi() {
        return $this->hasMany(StaffInsuranceEmi::class, 'staff_insurance_id', 'id')->where('status', '!=', 'inactive')->orderBy('emi_date');
    }

    public function paid_emi() {
        return $this->hasMany(StaffInsuranceEmi::class, 'staff_insurance_id', 'id')->where('status', '=', 'paid')->orderBy('emi_date');
    }
     public function staff() {
        return $this->hasOne(User::class, 'id', 'staff_id');
    }

}
