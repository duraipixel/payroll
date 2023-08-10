<?php

namespace App\Models\Staff;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffBankLoan extends Model
{
    use HasFactory;

    protected $fillable = [
        'staff_id',
        'bank_id',
        'bank_name',	
        'ifsc_code',	
        'loan_ac_no',	
        'loan_type_id',	
        'loan_due',	
        'every_month_amount',
        'loan_amount',
        'period_of_loans',
        'status',
        'file',
        'loan_start_date',
        'loan_end_date'
    ];

    public function emi() {
        return $this->hasMany(StaffLoanEmi::class, 'staff_loan_id', 'id')->where('status', '!=', 'inactive')->orderBy('emi_date');
    }

}
