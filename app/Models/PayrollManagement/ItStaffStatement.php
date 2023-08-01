<?php

namespace App\Models\PayrollManagement;

use App\Models\AcademicYear;
use App\Models\Master\Designation;
use App\Models\Staff\StaffTaxSeperation;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class ItStaffStatement extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'academic_id',	
        'staff_id',	
        'designation_id',	
        'pan_no',	
        'no_of_months',	
        'gross_salary_anum',	
        'standard_deduction',	
        'hra',	
        'total_year_salary_income',	
        'housing_loan_interest',	
        'professional_tax',	
        'total_extract_from_housing_loan_interest',	
        'total_extract_from_professional_tax',	
        'other_income',	
        'gross_income',	
        'deduction_80c_amount',	
        'national_pension_amount',	
        'medical_policy_amount',	
        'bank_interest_deduction_amount',	
        'total_deduction_amount',	
        'taxable_gross_income',	
        'round_off_taxable_gross_income',	
        'tax_on_taxable_gross_income',	
        'tax_after_rebate_amount',	
        'educational_cess_tax_payable',	
        'total_income_tax_payable',	
        'document',
        'status',	
        'added_by',
        'is_staff_calculation_done',
        'lock_calculation',
        'tax_scheme_id'
    ];

    public function scopeHasAcademic($query)
    {
        if( session()->get('academic_id') && !empty( session()->get('academic_id') ) ){

            return $query->where('it_staff_statements.academic_id', session()->get('academic_id'));
        }
    }

    public function staff() {
        return $this->hasOne(User::class, 'id', 'staff_id' );
    }

    public function academic() {
        return $this->hasOne(AcademicYear::class, 'id', 'academic_id');
    }

    public function designation() {
        return $this->hasOne(Designation::class, 'id', 'designation_id' );
    }

    public function staffTaxSeparation() {
        return $this->hasOne(StaffTaxSeperation::class, 'income_tax_id', 'id');
    }

}
