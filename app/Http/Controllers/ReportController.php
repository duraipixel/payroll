<?php

namespace App\Http\Controllers;

use App\Exports\Reports\AttendanceReport;
use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use App\Models\Master\Department;
use App\Models\User;
use App\Repositories\ReportRepository;
use Illuminate\Http\Request;
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
class ReportController extends Controller
{
    public $repository;

    public function __construct(ReportRepository $repository) {
        $this->repository = $repository;
    }

    function index()
    {
        return view('pages.reports.index');
    }

    public function profileReports(Request $request)
    {

        if ($request->ajax()) {
            $details = User::with(['personal', 'position'])->whereNull('is_super_admin')->orderBy('society_emp_code', 'desc')->get();
            $params = ['details' => $details];
            return view('pages.reports.profile._table_content', $params);
        }
        return view('pages.reports.profile._index');
    } 
    public function commonExport(Request $request)
    {
    }

    function attendance_collection($request, $date) {
        return User::with(['AttendancePresent', 'Attendance' => function ($query) use ($date) {
            $query->whereBetween('attendance_date', [$date['start_date'], $date['end_date']]);
        }])
        ->leftJoin('staff_appointment_details', function($join){
            $join->on('staff_appointment_details.staff_id', '=','users.id')
                    ->where('staff_appointment_details.academic_id', academicYearId());
        })
        ->select('users.*','staff_appointment_details.place_of_work_id')
        ->when(!is_null($request->place_of_work),function($q) use ($request){
            $q->where('place_of_work_id', $request->place_of_work);
        });
    }

    function attendance_index(Request $request)
    {
        $month         = $request->month ?? date('m');
        $academic_info = AcademicYear::find( academicYearId());
        if( $academic_info ) {
            $from_year = $academic_info->from_year.'-'.$month.'-01';
            $start_date = date('Y-m-d', strtotime($from_year) );
            $no_of_days = date('t', strtotime($start_date) );
        }
        $place_of_work = $request->place_of_work ?? null;
        $date          = getStartAndEndDateOfMonth($month);
        $month_days    = monthDays($month);

        $perPage = (!empty($request->limit) && $request->limit === 'all') ? 100000000000000000000 : $request->limit;
        $attendance    = $this->attendance_collection($request,$date)->paginate($perPage);
        return view('pages.reports.attendance._index', compact('attendance', 'month_days','month','place_of_work', 'start_date', 'no_of_days'));
    }

    function attendance_export(Request $request) {
        $month       = $request->month ?? date('m');
        $date        = getStartAndEndDateOfMonth($month);
        $month_days  = monthDays($month);
        $attendance  = $this->attendance_collection($request,$date)->get();
        return Excel::download(new AttendanceReport($attendance, $month_days),'attendance.xlsx');
    }

    public function serviceHistoryIndex(Request $request) {
        $employee_id    = $request->employee ?? '';
        $department_id  = $request->department ?? '';
        $history_Data   = $this->repository->getServiceHistory($employee_id, $department_id );
        $history        = current( $history_Data );
        $paginate_link  = end( $history_Data );
        $employees      = User::whereNull('is_super_admin')->where('verification_status', 'approved')->get();
        $departments    = Department::all();
        $academic_info  = AcademicYear::find(academicYearId());
        $academic_title = 'HISTORY OF SERVICE ( '.$academic_info->from_year.' - '.$academic_info->to_year.' )';
        
        return view('pages.reports.service_history.index', compact('employee_id', 'department_id','history', 'paginate_link', 'employees','departments', 'academic_title' ));
    }

    public function serviceHistoryExport(Request $request) {

        $employee_id = $request->employee ?? '';
        $department_id = $request->department ?? '';

        $history_Data = $this->repository->getServiceHistory($employee_id, $department_id, 'export' );

        $history = current( $history_Data );
        $paginate_link = end( $history_Data );

        $academic_info = AcademicYear::find(academicYearId());
        $academic_title = 'HISTORY OF SERVICE ( '.$academic_info->from_year.' - '.$academic_info->to_year.' )';

        $data = [
            'history' => $history,
            'academic_title' => $academic_title
        ];
        $pdf = PDF::loadView('pages.reports.service_history._pdf_view',$data)->setPaper('a4', 'portrait');
        
        return $pdf->stream('service_history.pdf');

    }
    public function BankLoanReport(Request $request)
    {
        $breadcrums = array(
            'title' => 'Bank Loan Report',
            'breadcrums' => array(
                array(
                    'link' => '', 'title' => 'Bank Loan Report'
                ),
            )
        );
        $datatable_search=$request->datatable_search;
        $month = $request->month ?? date('m');
        $data=StaffBankLoan::with('staff','staff.appointment','emione')
         ->when(!empty($datatable_search), function ($query) use ($datatable_search) {
                   
            return $query->where(function ($q) use ($datatable_search) {
                $q->whereHas('staff', function($jq) use($datatable_search){
                $jq->where('name', 'like', "%{$datatable_search}%")
                ->orWhere('institute_emp_code', 'like', "%{$datatable_search}%");
                    });
            });
        })
        ->when(!empty($month), function ($query) use ($month) {
            return $query->where(function ($q) use ($month) {
                $q->whereHas('emione', function($jq) use($month){
                $jq->whereMonth('emi_month',$month);
                    
                    });
            });

        })->get();
        if($request->ajax()){
        $datatables =  Datatables::of($data)
        ->addIndexColumn()
        ->editColumn('name', function ($row) { 
          
                    return $row['staff']->name ?? '';
        })->editColumn('emp_id', function ($row) {
                    return $row['staff']->institute_emp_code ?? '';
        })->editColumn('place', function ($row) {
                    return $row['staff']->appointment->work_place->name ?? '';
        })->editColumn('doj', function ($row) {
                    return $row['staff']->appointment->joining_date ?? '';
        })->editColumn('designation', function ($row) {
                    return $row['staff']->appointment->designation->name?? '';
        })->editColumn('instalment_no', function ($row) {
                    return $row->emione->staff_loan_id?? '';
        })->editColumn('balance_due', function ($row) {
                   return $row->emione->amount?? '';
        });
        return $datatables->make(true);
             }
        return view('pages.reports.bank_loan', compact('breadcrums','month'));
    }
    public function InsuranceReport(Request $request)
    {
        $breadcrums = array(
            'title' => ' Insurance Report',
            'breadcrums' => array(
                array(
                    'link' => '', 'title' => 'Insurance Report'
                ),
            )
        );
        $datatable_search=$request->datatable_search;
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
        if($request->ajax()){
        $datatables =  Datatables::of($data)
        ->addIndexColumn()
        ->editColumn('name', function ($row) { 
          
                    return $row['staff']->name ?? '';
        })->editColumn('emp_id', function ($row) {
                    return $row['staff']->institute_emp_code ?? '';
        })->editColumn('place', function ($row) {
                    return $row['staff']->appointment->work_place->name ?? '';
        })->editColumn('doj', function ($row) {
                    return $row['staff']->appointment->joining_date ?? '';
        });
        return $datatables->make(true);
             }
        return view('pages.reports.lic', compact('breadcrums','month'));
    }
    public function SalaryHold(Request $request)
    {
        $breadcrums = array(
            'title' => ' Salary Hold Report',
            'breadcrums' => array(
                array(
                    'link' => '', 'title' => 'Salary Hold Report'
                ),
            )
        );
        $datatable_search=$request->datatable_search;
        $month = $request->month ?? date('m');
        $data=HoldSalary::with('staff','staff.appointment')
         ->when(!empty($datatable_search), function ($query) use ($datatable_search) {
                   
            return $query->where(function ($q) use ($datatable_search) {
                $q->whereHas('staff', function($jq) use($datatable_search){
                $jq->where('name', 'like', "%{$datatable_search}%")
                ->orWhere('institute_emp_code', 'like', "%{$datatable_search}%");
                    });
            });
        })->where('academic_id',academicYearId())->whereMonth('hold_month',$month)->orderBy('hold_month','desc')->get();
        if($request->ajax()){
        $datatables =  Datatables::of($data)
        ->addIndexColumn()
        ->editColumn('name', function ($row) { 
          
                    return $row['staff']->name ?? '';
        })->editColumn('emp_id', function ($row) {
                    return $row['staff']->institute_emp_code ?? '';
        })->editColumn('place', function ($row) {
                    return $row['staff']->appointment->work_place->name ?? '';
        })->editColumn('doj', function ($row) {
                    return $row['staff']->appointment->joining_date ?? '';
        })->editColumn('designation', function ($row) {
                    return $row['staff']->appointment->designation->name?? '';
        })->editColumn('net_salary', function ($row) {
                    return 0;
        });
        return $datatables->make(true);
             }
        return view('pages.reports.hold_salary', compact('breadcrums','month'));
    }
    public function LOP(Request $request)
    {
        $breadcrums = array(
            'title' => ' LOP Report',
            'breadcrums' => array(
                array(
                    'link' => '', 'title' => 'LOP Report'
                ),
            )
        );
        $datatable_search=$request->datatable_search;
        $month = $request->month ?? date('m');
        $data=HoldSalary::with('staff','staff.appointment')
         ->when(!empty($datatable_search), function ($query) use ($datatable_search) {
                   
            return $query->where(function ($q) use ($datatable_search) {
                $q->whereHas('staff', function($jq) use($datatable_search){
                $jq->where('name', 'like', "%{$datatable_search}%")
                ->orWhere('institute_emp_code', 'like', "%{$datatable_search}%");
                    });
            });
        })->where('academic_id',academicYearId())->whereMonth('hold_month',$month)->orderBy('hold_month','desc')->get();
        if($request->ajax()){
        $datatables =  Datatables::of($data)
        ->addIndexColumn()
        ->editColumn('name', function ($row) { 
          
                    return $row['staff']->name ?? '';
        })->editColumn('emp_id', function ($row) {
                    return $row['staff']->institute_emp_code ?? '';
        })->editColumn('place', function ($row) {
                    return $row['staff']->appointment->work_place->name ?? '';
        })->editColumn('doj', function ($row) {
                    return $row['staff']->appointment->joining_date ?? '';
        })->editColumn('designation', function ($row) {
                    return $row['staff']->appointment->designation->name?? '';
        })->editColumn('gross_salary', function ($row) {
                    return 0;
        })->editColumn('no_of_days', function ($row) {
                    return 31;
        })->editColumn('lop', function ($row) {
                    return 0;
        });
        return $datatables->make(true);
             }
        return view('pages.reports.hold_salary', compact('breadcrums','month'));
    }
    public function ESI(Request $request)
    {
        $breadcrums = array(
            'title' => 'ESI Report',
            'breadcrums' => array(
                array(
                    'link' => '', 'title' => 'ESI Report'
                ),
            )
        );
        $datatable_search=$request->datatable_search;
        $month = $request->month ?? date('m');
        $data=StaffSalary::get();

        if($request->ajax()){
        $datatables =  Datatables::of($data)
        ->addIndexColumn()
        ->editColumn('name', function ($row) { 
          
                    return $row['staff']->name ?? '';
        })->editColumn('emp_id', function ($row) {
                    return $row['staff']->institute_emp_code ?? '';
        })->editColumn('place', function ($row) {
                    return $row['staff']->appointment->work_place->name ?? '';
        })->editColumn('doj', function ($row) {
                    return $row['staff']->appointment->joining_date ?? '';
        })->editColumn('designation', function ($row) {
                    return $row['staff']->appointment->designation->name?? '';
        })->editColumn('gross_salary', function ($row) {
                    return 0;
        })->editColumn('no_of_days', function ($row) {
                    return 31;
        })->editColumn('lop', function ($row) {
                    return 0;
        });
        return $datatables->make(true);
             }
        return view('pages.reports.hold_salary', compact('breadcrums','month'));
    }
    public function Resigned(Request $request)
    {
        $breadcrums = array(
            'title' => 'Resigned Report',
            'breadcrums' => array(
                array(
                    'link' => '', 'title' => 'Resigned Report'
                ),
            )
        );
        $datatable_search=$request->datatable_search;
        $month = $request->month ?? date('m');
        $data=StaffRetiredResignedDetail::where('types','resigned')->with('staff')->when(!empty($datatable_search), function ($query) use ($datatable_search) {
                   
            return $query->where(function ($q) use ($datatable_search) {
                $q->whereHas('staff', function($jq) use($datatable_search){
                $jq->where('name', 'like', "%{$datatable_search}%")
                ->orWhere('institute_emp_code', 'like', "%{$datatable_search}%");
                    });
            });
        })->where('academic_id',academicYearId())->whereMonth('last_working_date',$month)->orderby('last_working_date','desc')->get();
        if($request->ajax()){
        $datatables =  Datatables::of($data)
        ->addIndexColumn()
        ->editColumn('name', function ($row) { 
          
                    return $row['staff']->name ?? '';
        })->editColumn('emp_id', function ($row) {
                    return $row['staff']->institute_emp_code ?? '';
        })->editColumn('place', function ($row) {
                    return $row['staff']->appointment->work_place->name ?? '';
        })->editColumn('doj', function ($row) {
                    return $row['staff']->appointment->joining_date ?? '';
        })->editColumn('designation', function ($row) {
                    return $row['staff']->appointment->designation->name?? '';
        });
        return $datatables->make(true);
             }
        return view('pages.reports.resigned', compact('breadcrums','month'));
    }
    public function Bonus(Request $request)
    {
        $breadcrums = array(
            'title' => 'Bonus Report',
            'breadcrums' => array(
                array(
                    'link' => '', 'title' => 'Bonus Report'
                ),
            )
        );
        $datatable_search=$request->datatable_search;
        $month = $request->month ?? date('m');
        $data=StaffSalaryPreEarning::where('earnings_type','bonus')->with('staff')->when(!empty($datatable_search), function ($query) use ($datatable_search) {
                   
            return $query->where(function ($q) use ($datatable_search) {
                $q->whereHas('staff', function($jq) use($datatable_search){
                $jq->where('name', 'like', "%{$datatable_search}%")
                ->orWhere('institute_emp_code', 'like', "%{$datatable_search}%");
                    });
            });
        })->where('academic_id',academicYearId())->whereMonth('salary_month',$month)->orderby('created_at','desc')->get();
        if($request->ajax()){
        $datatables =  Datatables::of($data)
        ->addIndexColumn()
        ->editColumn('name', function ($row) { 
          
                    return $row['staff']->name ?? '';
        })->editColumn('emp_id', function ($row) {
                    return $row['staff']->institute_emp_code ?? '';
        })->editColumn('place', function ($row) {
                    return $row['staff']->appointment->work_place->name ?? '';
        })->editColumn('doj', function ($row) {
                    return $row['staff']->appointment->joining_date ?? '';
        })->editColumn('designation', function ($row) {
                    return $row['staff']->appointment->designation->name?? '';
        });
        return $datatables->make(true);
             }
        
        return view('pages.reports.bonus', compact('breadcrums','month'));
    }
    public function Arrers(Request $request)
    {
        $breadcrums = array(
            'title' => 'Arrers Report',
            'breadcrums' => array(
                array(
                    'link' => '', 'title' => 'Arrers Report'
                ),
            )
        );
        $datatable_search=$request->datatable_search;
        $month = $request->month ?? date('m');
        $data=StaffSalaryPreEarning::where('earnings_type','arrear')->with('staff')->when(!empty($datatable_search), function ($query) use ($datatable_search) {
                   
            return $query->where(function ($q) use ($datatable_search) {
                $q->whereHas('staff', function($jq) use($datatable_search){
                $jq->where('name', 'like', "%{$datatable_search}%")
                ->orWhere('institute_emp_code', 'like', "%{$datatable_search}%");
                    });
            });
        })->orderby('created_at','desc')->get();
        if($request->ajax()){
        $datatables =  Datatables::of($data)
        ->addIndexColumn()
        ->editColumn('name', function ($row) { 
          
                    return $row['staff']->name ?? '';
        })->editColumn('emp_id', function ($row) {
                    return $row['staff']->institute_emp_code ?? '';
        })->editColumn('place', function ($row) {
                    return $row['staff']->appointment->work_place->name ?? '';
        })->editColumn('doj', function ($row) {
                    return $row['staff']->appointment->joining_date ?? '';
        })->editColumn('designation', function ($row) {
                    return $row['staff']->appointment->designation->name?? '';
        });
        return $datatables->make(true);
             }
        return view('pages.reports.arrers', compact('breadcrums','month'));
    }

}