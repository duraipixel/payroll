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
        $place_of_work = $request->place_of_work ?? null;
        $date          = getStartAndEndDateOfMonth($month);
        $month_days    = monthDays($month);
        $attendance    = $this->attendance_collection($request,$date)->paginate(14);
        return view('pages.reports.attendance._index', compact('attendance', 'month_days','month','place_of_work'));
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
}