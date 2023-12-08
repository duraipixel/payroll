<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Exports\Reports\AttendanceReport;
use App\Models\AcademicYear;
use App\Models\Master\Department;
use App\Models\User;
use App\Models\PayrollManagement\StaffSalaryPattern;
use App\Models\PayrollManagement\SalaryField;
use App\Repositories\ReportRepository;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use App\Models\PayrollManagement\StaffSalary;
use App\Models\PayrollManagement\Payroll;
use DataTables;
use Carbon\Carbon;
use App\Models\Staff\StaffBankLoan;
use App\Models\Staff\StaffInsurance;
use App\Models\PayrollManagement\HoldSalary;
use App\Models\Staff\StaffRetiredResignedDetail;
use App\Models\Staff\StaffSalaryPreEarning;
use App\Models\PayrollManagement\ItStaffStatement;

##.export
use App\Exports\Reports\EpfExport;
use App\Exports\Reports\EsiExport;
use App\Exports\Reports\IncomeTaxExport;
use App\Exports\Reports\BonusExport;
use App\Exports\Reports\ArrerExport;
use App\Exports\Reports\ResignationExport;
use App\Exports\Reports\BankLoanExport;
use App\Exports\Reports\LicExport;
use App\Exports\Reports\LopExport;
use App\Exports\Reports\HoldsalaryExport;
use App\Exports\Reports\ProfessionalTaxExport;
use App\Exports\Reports\SalaryAcquitanceExport;
use App\Exports\Reports\BankDisbursement;
class ReportExportController extends Controller
{
    function epf(Request $request) {
        $datatable_search=$request->data_search;
        $academic=AcademicYear::find(academicYearId());
        $month = $request->month ?? date('m');
        $year = $academic->from_year;
        $dates =  Carbon::now()->month($month)->year($year)->day(1)->format("Y-m-d");
        $data=[];
        $from_date = date('Y-m-01', strtotime($dates));
        $to_date = date('Y-m-t', strtotime($dates));
        $payroll = Payroll::where('from_date', $from_date)->where('to_date', $to_date)->where('institute_id',session()->get('staff_institute_id'))->first();
        $payroll_id = $payroll->id ?? '';
        if($payroll){
            $data = StaffSalary::with('staff')->when(!empty($payroll_id), function($query) use($payroll_id){
                $query->where('payroll_id', $payroll_id);
            })->when(!empty($datatable_search), function ($query) use ($datatable_search) {

                return $query->where(function ($q) use ($datatable_search) {
                    $q->whereHas('staff', function($jq) use($datatable_search){
                        $jq->where('name', 'like', "%{$datatable_search}%")
                        ->orWhere('institute_emp_code', 'like', "%{$datatable_search}%");
                    });
                });
            })->orderby('created_at','desc')->get();
        }
          
         return Excel::download(new EpfExport($data??[]),'epf_export.xlsx');   

    }
    function esi(Request $request) {

        $datatable_search=$request->data_search;
        $academic=AcademicYear::find(academicYearId());
        $month = $request->month ?? date('m');
        $year = $academic->from_year;
        $dates =  Carbon::now()->month($month)->year($year)->day(1)->format("Y-m-d");
        $data=[];
        $from_date = date('Y-m-01', strtotime($dates));
        $to_date = date('Y-m-t', strtotime($dates));
        $payroll = Payroll::where('from_date', $from_date)->where('to_date', $to_date)->where('institute_id',session()->get('staff_institute_id'))->first();
        $payroll_id = $payroll->id ?? '';
        if($payroll){
            $data = StaffSalary::with('staff')->when(!empty($payroll_id), function($query) use($payroll_id){
                $query->where('payroll_id', $payroll_id);
            })->when(!empty($datatable_search), function ($query) use ($datatable_search) {

                return $query->where(function ($q) use ($datatable_search) {
                    $q->whereHas('staff', function($jq) use($datatable_search){
                        $jq->where('name', 'like', "%{$datatable_search}%")
                        ->orWhere('institute_emp_code', 'like', "%{$datatable_search}%");
                    });
                });
            })->orderby('created_at','desc')->get();
        }
    return Excel::download(new EsiExport($data??[]),'esi_export.xlsx');   
    }
    function IncomeTax(Request $request) {
        $datatable_search=$request->data_search;
        $month = $request->month ?? date('m');
        $data=ItStaffStatement::with('staff')->when(!empty($datatable_search), function ($query) use ($datatable_search) {
                   
            return $query->where(function ($q) use ($datatable_search) {
                $q->whereHas('staff', function($jq) use($datatable_search){
                $jq->where('name', 'like', "%{$datatable_search}%")
                ->orWhere('institute_emp_code', 'like', "%{$datatable_search}%");
                    });
            });
        })->where('academic_id',academicYearId())->whereMonth('created_at',$month)->orderby('created_at','desc')->get();
    return Excel::download(new IncomeTaxExport($data??[]),'incometax_export.xlsx');   
    }
    function bonus(Request $request) {

        $datatable_search=$request->data_search;
        $month = $request->month ?? date('m');
        $data=StaffSalaryPreEarning::where('earnings_type','bonus')->with('staff')->when(!empty($datatable_search), function ($query) use ($datatable_search) {
                   
            return $query->where(function ($q) use ($datatable_search) {
                $q->whereHas('staff', function($jq) use($datatable_search){
                $jq->where('name', 'like', "%{$datatable_search}%")
                ->orWhere('institute_emp_code', 'like', "%{$datatable_search}%");
                    });
            });
        })->where('academic_id',academicYearId())->whereMonth('salary_month',$month)->orderby('created_at','desc')->get();
    return Excel::download(new BonusExport($data??[]),'bonus_export.xlsx');   
    }
    function arrear(Request $request) {
     $datatable_search=$request->data_search;
        $month = $request->month ?? date('m');
        $data=StaffSalaryPreEarning::where('earnings_type','arrear')->with('staff')->whereMonth('created_at',$month)->when(!empty($datatable_search), function ($query) use ($datatable_search) {
                   
            return $query->where(function ($q) use ($datatable_search) {
                $q->whereHas('staff', function($jq) use($datatable_search){
                $jq->where('name', 'like', "%{$datatable_search}%")
                ->orWhere('institute_emp_code', 'like', "%{$datatable_search}%");
                    });
            });
        })->orderby('created_at','desc')->get();
     return Excel::download(new ArrerExport($data??[]),'bonus_export.xlsx');   
    }
    function resignation(Request $request){
        $datatable_search=$request->data_search;
        $month = $request->month ?? date('m');
        $data=StaffRetiredResignedDetail::where('types','resigned')->with('staff')->where('institute_id',session()->get('staff_institute_id'))->when(!empty($datatable_search), function ($query) use ($datatable_search) {
                   
            return $query->where(function ($q) use ($datatable_search) {
                $q->whereHas('staff', function($jq) use($datatable_search){
                $jq->where('name', 'like', "%{$datatable_search}%")
                ->orWhere('institute_emp_code', 'like', "%{$datatable_search}%");
                    });
            });
        })->where('academic_id',academicYearId())->whereMonth('last_working_date',$month)->orderby('last_working_date','desc')->get();
    return Excel::download(new ResignationExport($data??[]),'resignation_export.xlsx');   
    }
    function bankloan(Request $request){
        $academic_info = AcademicYear::find(academicYearId());
        $datatable_search=$request->datatable_search;
        $month = $request->month ?? date('m');
        $year=$academic_info->from_year;
        $dates =  Carbon::now()->month($month)->year($year)->day(1)->format("Y-m-d");
        $from_date = date('Y-m-01', strtotime($dates));
        $data=StaffBankLoan::with('staff','staff.appointment','emione')
         ->when(!empty($datatable_search), function ($query) use ($datatable_search) {
                   
            return $query->where(function ($q) use ($datatable_search) {
                $q->whereHas('staff', function($jq) use($datatable_search){
                $jq->where('name', 'like', "%{$datatable_search}%")
                ->orWhere('institute_emp_code', 'like', "%{$datatable_search}%");
                    });
            });
        })
        ->when(!empty($from_date), function ($query) use ($from_date) {
            return $query->where(function ($q) use ($from_date) {

                $q->whereHas('emione', function($jq) use($from_date){
                $jq->where('emi_month',$from_date);
                    
                    });
            });

        })->get();

         return Excel::download(new BankLoanExport($data??[]),'banloan_export.xlsx');   
    }
    function lic(Request $request){
    $datatable_search=$request->data_search;
    $month = $request->month ?? date('m');
    $data=StaffInsurance::with('staff','staff.appointment')
     ->when(!empty($datatable_search), function ($query) use ($datatable_search) {
               
        return $query->where(function ($q) use ($datatable_search) {
            $q->whereHas('staff', function($jq) use($datatable_search){
            $jq->where('name', 'like', "%{$datatable_search}%")
            ->orWhere('institute_emp_code', 'like', "%{$datatable_search}%");
                });
        });
    })->whereMonth('start_date',$month)->orderBy('start_date','desc')->get();
    return Excel::download(new LicExport($data??[]),'lic_export.xlsx');   
    }
    function lop(Request $request) {
         $datatable_search=$request->data_search;
               $academic=AcademicYear::find(academicYearId());
        $month = $request->month ?? date('m');
        $year = $academic->from_year;
        $dates =  Carbon::now()->month($month)->year($year)->day(1)->format("Y-m-d");
        $data=[];
        $from_date = date('Y-m-01', strtotime($dates));
        $to_date = date('Y-m-t', strtotime($dates));
        $payroll = Payroll::where('from_date', $from_date)->where('to_date', $to_date)->where('institute_id',session()->get('staff_institute_id'))->first();
        $payroll_id = $payroll->id ?? '';
        if($payroll){
            $data = StaffSalary::with('staff')->when(!empty($payroll_id), function($query) use($payroll_id){
                $query->where('payroll_id', $payroll_id);
            })->when(!empty($datatable_search), function ($query) use ($datatable_search) {

                return $query->where(function ($q) use ($datatable_search) {
                    $q->whereHas('staff', function($jq) use($datatable_search){
                        $jq->where('name', 'like', "%{$datatable_search}%")
                        ->orWhere('institute_emp_code', 'like', "%{$datatable_search}%");
                    });
                });
            })->orderby('created_at','desc')->get();
        }   
    return Excel::download(new LopExport($data??[]),'lop_export.xlsx');   
    }
    function holdsalary(Request $request) {
        $datatable_search=$request->data_search;
        $month = $request->month ?? date('m');
        $data=HoldSalary::with('staff','staff.appointment')->where('institute_id',session()->get('staff_institute_id'))
         ->when(!empty($datatable_search), function ($query) use ($datatable_search) {
                   
            return $query->where(function ($q) use ($datatable_search) {
                $q->whereHas('staff', function($jq) use($datatable_search){
                $jq->where('name', 'like', "%{$datatable_search}%")
                ->orWhere('institute_emp_code', 'like', "%{$datatable_search}%");
                    });
            });
        })->where('academic_id',academicYearId())->whereMonth('hold_month',$month)->orderBy('hold_month','desc')->get();
        return Excel::download(new HoldsalaryExport($data??[]),'holdsalary_export.xlsx');   
    }
    function professionaltax(Request $request) {
        $datatable_search=$request->data_search;
        $month = $request->month ?? date('m');
        $dates ='2023-08-01';
        $data=[];
        $from_date = date('Y-m-01', strtotime($dates));
        $to_date = date('Y-m-t', strtotime($dates));
        $payroll = Payroll::where('from_date', $from_date)->where('to_date', $to_date)->where('institute_id',session()->get('staff_institute_id'))->first();
            $payroll_id = $payroll->id ?? '';
            if($payroll){
                $data = StaffSalary::with('staff')->when(!empty($payroll_id), function($query) use($payroll_id){
                                    $query->where('payroll_id', $payroll_id);
                                })->when(!empty($datatable_search), function ($query) use ($datatable_search) {
                       
                return $query->where(function ($q) use ($datatable_search) {
                    $q->whereHas('staff', function($jq) use($datatable_search){
                    $jq->where('name', 'like', "%{$datatable_search}%")
                    ->orWhere('institute_emp_code', 'like', "%{$datatable_search}%");
                        });
                });
            })->orderby('created_at','desc')->whereMonth('salary_processed_on',$month)->get();
            }  
        return Excel::download(new LopExport($data??[]),'professionaltax_export.xlsx');   
    }
     function SalaryAcquitance(Request $request) {
        $datatable_search=$request->data_search;
        $academic=AcademicYear::find(academicYearId());
       $month = $request->month ?? date('m');
        $year = $academic->from_year;
        $dates =  Carbon::now()->month($month)->year($year)->day(1)->format("Y-m-d");
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
        
        $payroll = Payroll::where('from_date', $from_date)->where('to_date', $to_date)->where('institute_id',session()->get('staff_institute_id'))->first();
        $payroll_id = $payroll->id ?? '';
        if( $payroll ) {

            $salary_info = StaffSalary::when(!empty($payroll_id), function($query) use($payroll_id){
                                $query->where('payroll_id', $payroll_id);
                            })
                            ->when(!empty($datatable_search), function ($query) use ($datatable_search) {

                return $query->where(function ($q) use ($datatable_search) {
                    $q->whereHas('staff', function($jq) use($datatable_search){
                        $jq->where('name', 'like', "%{$datatable_search}%")
                        ->orWhere('institute_emp_code', 'like', "%{$datatable_search}%");
                    });
                });
            })->orderby('created_at','desc')->get();
        }
       
        return Excel::download(new SalaryAcquitanceExport($earings_field??'',$deductions_field??'',$salary_info?? [],$payroll??''),'salaryregister_export.xlsx');
        
    }
    function BankDisbursement(Request $request) {
        $datatable_search=$request->data_search;
        $month = $request->month ?? date('m');
        $academic_info = AcademicYear::find(academicYearId());
        $year=$academic_info->from_year;
        $dates =  Carbon::now()->month($month)->year($year)->day(1)->format("Y-m-d");
        $data=[];
        $from_date = date('Y-m-01', strtotime($dates));
        $to_date = date('Y-m-t', strtotime($dates));
        $payroll = Payroll::where('from_date', $from_date)->where('to_date', $to_date)->where('institute_id',session()->get('staff_institute_id'))->first();
        $payroll_id = $payroll->id ?? '';
        if($payroll_id){
            $data = StaffSalary::with('staff')->when(!empty($payroll_id), function($query) use($payroll_id){
                $query->where('payroll_id', $payroll_id);
            })->when(!empty($datatable_search), function ($query) use ($datatable_search) {

                return $query->where(function ($q) use ($datatable_search) {
                    $q->whereHas('staff', function($jq) use($datatable_search){
                        $jq->where('name', 'like', "%{$datatable_search}%")
                        ->orWhere('institute_emp_code', 'like', "%{$datatable_search}%");
                    });
                });
            })->orderby('created_at','desc')->get();
           

        }         
       
        return Excel::download(new BankDisbursement($data??[]),'bank_disbursement_export.xlsx');
        
    }

}
