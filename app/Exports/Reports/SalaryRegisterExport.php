<?php

namespace App\Exports\Reports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class SalaryRegisterExport implements FromView
{
    public $earings_field,$deductions_field,$salary_info,$payroll;
    function __construct($earings_field,$deductions_field,$salary_info,$payroll)
    {
        $this->earings_field = $earings_field;
        $this->deductions_field = $deductions_field;
        $this->salary_info = $salary_info;
        $this->payroll = $payroll;
       
    }
    public function view() : View
    {
        return view('pages.reports.staff.salary-register.export', ['earings_field' =>  $this->earings_field,'deductions_field' =>  $this->deductions_field,'salary_info' =>  $this->salary_info,'payroll' =>  $this->payroll]);
    }
}