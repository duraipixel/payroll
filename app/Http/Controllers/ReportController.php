<?php

namespace App\Http\Controllers;

use App\Exports\Reports\AttendanceReport;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
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
        $month         = $request->month ?? date('m');
        $date          = getStartAndEndDateOfMonth($month);
        $month_days    = monthDays($month);
        $attendance    = $this->attendance_collection($request,$date)->get();
        return Excel::download(new AttendanceReport($attendance, $month_days),'attendance.xlsx');
    }
}