<?php

namespace App\Http\Controllers\PayrollManagement;

use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use App\Models\PayrollManagement\Payroll;
use App\Models\PayrollManagement\SalaryField;
use App\Models\PayrollManagement\StaffSalary;
use App\Models\User;
use Illuminate\Http\Request;

class PayrollController extends Controller
{

    public function __construct()
    {
    }

    public function index(Request $request)
    {
        $breadcrums = array(
            'title' => 'Payroll Overview',
            'breadcrums' => array(
                array(
                    'link' => '', 'title' => 'Payroll Overview'
                ),
            )
        );

        $month = $request->month ?? '';
        $acYear = AcademicYear::find(academicYearId());
        $from_year = $acYear->from_year;
        $start_year = '01-' . $acYear->from_month . '-' . $acYear->from_year;
        $end_year = '01-' . $acYear->to_month . '-' . $acYear->to_year;

        $date = $start_year;
        $from_date = date('Y-m-01', strtotime($date));
        $to_date = date('Y-m-t', strtotime($date));
        $working_days = date('t', strtotime($date));

        $payroll = Payroll::where('from_date', $from_date)->where('to_date', $to_date)->where('institute_id',session()->get('staff_institute_id'))->first();
        $previous_month_start = date('Y-m-01', strtotime($date . ' - 1 month'));
        $previous_month_end = date('Y-m-t', strtotime($date . ' - 1 month'));

        $previous_payroll = Payroll::where('from_date', $previous_month_start)->where('to_date', $previous_month_end)->where('institute_id',session()->get('staff_institute_id'))->first();
        //dd($breadcrums);

        return view('pages.payroll_management.payroll.index', compact('breadcrums', 'date', 'payroll', 'working_days', 'previous_payroll', 'from_year', 'month'));
    }

    public function processedList(Request $request) {

        $month_no = $request->month_no;
        $dates = $request->dates;
        $from_date = date('Y-m-01', strtotime($dates));
        $to_date = date('Y-m-t', strtotime($dates));
        $working_days = date('t', strtotime($dates));
        // $payroll_date = date('Y-m-d', strtotime( $dates.'-1 month') );
        
        $payroll = Payroll::where('from_date', $from_date)->where('to_date', $to_date)->where('institute_id',session()->get('staff_institute_id'))->first();
        $payroll_id = $payroll->id ?? '';

        $employees = User::where('status', 'active')->orderBy('name', 'asc')->whereNull('is_super_admin')->where('institute_id',session()->get('staff_institute_id'))->get();
        $param = [
            'employees' => $employees,
            'month_no' => $month_no,
            'dates' => $dates,
            'payroll_id' => $payroll_id
        ];
        return view('pages.payroll_management.payroll.table_list', $param );

    }

    public function getAjaxProcessedList(Request $request) {

        $month_no = $request->month_no;
        $dates = $request->dates;
        $staff_id = $request->staff_id;
        
        $earings_field = SalaryField::where('salary_head_id', 1)->where('nature_id', 3)->get();
        $deductions_field = SalaryField::where('salary_head_id', 2)
            ->where(function ($query) {
                $query->where('is_static', 'yes');
                $query->orWhere('nature_id', 3);
            })->get();
        
        $payroll_id = $request->payroll_id;
        $institute_id=session()->get('staff_institute_id');
        // $nature_id = $request->nature_id;
        
        
        $from_date = date('Y-m-01', strtotime($dates));
        $to_date = date('Y-m-t', strtotime($dates));
        $working_days = date('t', strtotime($dates));
        // $payroll_date = date('Y-m-d', strtotime( $dates.'-1 month') );
        
        $payroll = Payroll::where('from_date', $from_date)->where('to_date', $to_date)->where('institute_id',session()->get('staff_institute_id'))->first();
        $payroll_id = $payroll->id ?? '';
        if( $payroll ) {

            $salary_info = StaffSalary::when(!empty($payroll_id), function($query) use($payroll_id){
                                $query->where('payroll_id', $payroll_id);
                            })
                            ->when( !empty( $staff_id ), function( $query ) use($staff_id) {
                                $query->where('staff_id', $staff_id);
                            } )
                            ->when($institute_id, function ($q) use($institute_id) {
             $q->whereHas('staff', function ($query) use ($institute_id) {
            $query->Where('institute_id', $institute_id);
                 });
              })->get();
        }

        $params = [
            'earings_field' => $earings_field,
            'deductions_field' => $deductions_field,
            'salary_info' => $salary_info ?? [],
            'payroll' => $payroll ?? ''
        ];

        return view('pages.payroll_management.payroll._ajax_list', $params);
        
    }
}
