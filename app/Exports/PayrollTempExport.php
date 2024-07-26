<?php

namespace App\Exports;

use App\Models\PayrollManagement\SalaryField;
use App\Models\PayrollManagement\StaffSalary;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class PayrollTempExport implements FromView
{
    public $payout_data,$date,$payout_id,$payroll_date,$month_start,$month_end;

    public function __construct( $payout_data,$date,$payout_id,$payroll_date,$month_start,$month_end)
    {
        $this->payout_data = $payout_data;
        $this->date = $date;
        $this->payout_id = $payout_id;
        $this->payroll_date = $payroll_date;
        $this->month_start = $month_start;
        $this->month_end = $month_end;
    }

     public function view(): View
    {
        $earings_field = SalaryField::where('salary_head_id', 1)
        ->where(function ($query) {
            $query->where('is_static', 'yes');
            $query->orWhere(function ($q) {
                $q->where('nature_id', 3);
                $q->where('short_name', '!=', 'ARR');
            });
        })
        ->orderBy('order_in_salary_slip')
        ->get();
      $deductions_field = SalaryField::where('salary_head_id', 2)
        ->where(function ($query) {
            $query->where('is_static', 'yes');
            $query->orWhere(function ($q) {
                $q->where('nature_id', 3);
                $q->where('short_name', '!=', 'CONTRIBUTION');
                $q->where('short_name', '!=', 'OTHER');
            });
        })->get();
           $payroll_points=["leave_days","employees","income_tax","hold_salary"];
            $params = array(
                'date' => $this->date,
                'payout_id' => $this->payout_id,
                'payroll_points' => $payroll_points,
                'process_it' => 1,
                'payout_data' => $this->payout_data,
                'earings_field' => $earings_field,
                'deductions_field' => $deductions_field,
                'working_day' => date('d', strtotime($this->month_end)),
                'payroll_date' => $this->payroll_date
            );
        return view('pages.payroll_management.overview.payroll_export',$params);
    }
}
