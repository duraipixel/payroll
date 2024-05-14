<?php

namespace App\Models\Staff;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
class StaffInsuranceEmi extends Model
{
    use HasFactory;

    protected $table = 'staff_insurance_emi';
    protected $fillable = [
        'staff_id', 
        'staff_insurance_id',
        'emi_date',
        'emi_month',
        'amount',
        'insurance_mode', //fixed, variable
        'insurance_type', //lic,hdfc,medical,health
        'status'  //'active','inactive', 'paid'
    ];
    public function staff() {
        return $this->hasOne(User::class, 'id', 'staff_id');
    }
    public function StaffInsurance() {
        return $this->hasOne(StaffInsurance::class, 'id', 'staff_insurance_id');
    }

}
