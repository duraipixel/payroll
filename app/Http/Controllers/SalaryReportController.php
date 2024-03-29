<?php

namespace App\Http\Controllers;

use App\Exports\Reports\SalaryRegisterExport;
use App\Http\Controllers\Controller;
use App\ReportHelper;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\PayrollManagement\Payroll;
use App\Models\PayrollManagement\SalaryField;
use App\Models\PayrollManagement\StaffSalary;
use Carbon\Carbon;
use App\Models\AcademicYear;
class SalaryReportController extends Controller
{
    use ReportHelper;
    function salary_register(Request $request) {
        $perPage = (!empty($request->limit) && $request->limit === 'all') ? 100000000000000000000 : $request->limit;
        $users = $this->collection($request)->paginate($perPage);
        $month = $request->month ?? date('m');
        return view('pages.reports.staff.salary-register.index', ['users' =>  $users, "month" => $month]);
    }
    function salary_register_export(Request $request) {
    $academic=AcademicYear::find(academicYearId());
        $month_no = $request->month;
        $year = $academic->from_year;
        $dates =  Carbon::now()->month($month_no)->year($year)->day(1)->format("Y-m-d");
        $staff_id = $request->staff_id;
        $earings_field = SalaryField::where('salary_head_id', 1)->where('nature_id', 3)->get();
        $deductions_field = SalaryField::where('salary_head_id', 2)
            ->where(function ($query) {
                $query->where('is_static', 'yes');
                $query->orWhere('nature_id', 3);
            })->get();
        
        $payroll_id = $request->payroll_id;
        
        // $nature_id = $request->nature_id;
        
        
        $from_date = date('Y-m-01', strtotime($dates));
        $to_date = date('Y-m-t', strtotime($dates));
        $working_days = date('t', strtotime($dates));
        // $payroll_date = date('Y-m-d', strtotime( $dates.'-1 month') );
        
        $payroll = Payroll::where('from_date', $from_date)->where('to_date', $to_date)->first();
        $payroll_id = $payroll->id ?? '';
        if( $payroll ) {

            $salary_info = StaffSalary::when(!empty($payroll_id), function($query) use($payroll_id){
                                $query->where('payroll_id', $payroll_id);
                            })
                            ->when( !empty( $staff_id ), function( $query ) use($staff_id) {
                                $query->where('staff_id', $staff_id);
                            } )
                            ->get();
        }
       
        return Excel::download(new SalaryRegisterExport($earings_field??'',$deductions_field??'',$salary_info?? [],$payroll??''),'salary_register_export.xlsx');
    }
}