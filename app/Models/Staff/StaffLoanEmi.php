<?php

namespace App\Models\Staff;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
class StaffLoanEmi extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'staff_loan_emi';

    protected $fillable = [
        'staff_id',
        'staff_loan_id',
        'emi_date',
        'emi_month',
        'amount',
        'loan_mode', //fixed, variable
        'loan_type', //school, bank loan
        'status'   //'active','inactive', 'paid'
    ];
    public function staff() {
        return $this->hasOne(User::class, 'id', 'staff_id');
    }
    public function StaffLoan() {
        return $this->hasOne(StaffBankLoan::class, 'id', 'staff_loan_id');
    }

}
