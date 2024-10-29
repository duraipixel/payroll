<?php

namespace App\Exports;

use App\Models\PayrollManagement\SalaryField;
use App\Models\PayrollManagement\StaffSalary;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class PayrollStatementExport implements FromView
{
    public $payroll_id;
    public $staff_id;

    public function __construct($payroll_id, $staff_id)
    {
        $this->payroll_id = $payroll_id;
        $this->staff_id = $staff_id;
    }

     public function view(): View
    {
        $earings_field = SalaryField::where('salary_head_id', 1)->where('nature_id', 3)->get();
        $deductions_field =SalaryField::where('salary_head_id', 2)
        ->where(function ($query) {
            $query->whereNull('nature_id')
                  ->orWhere('nature_id', 3);
        })
        ->whereNull('deleted_at')
        ->orderBy('order_in_salary_slip', 'asc')
        ->get();
        $payroll_id =  $this->payroll_id;
        $staff_id = $this->staff_id;

        $salary_info = StaffSalary::
                        where('payroll_id', $payroll_id)
                        ->when( !empty( $staff_id ), function( $query ) use($staff_id) {
                            $query->where('staff_id', $staff_id);
                        } )
                        ->get();

        $params = [
            'earings_field' => $earings_field,
            'deductions_field' => $deductions_field,
            'salary_info' => $salary_info
        ];
        
        return view('pages.payroll_management.overview.statement._export_excel', $params);
    }
}
