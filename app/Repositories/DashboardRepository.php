<?php

namespace App\Repositories;

use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use App\Models\AttendanceManagement\AttendanceManualEntry;
use App\Models\Leave\StaffLeave;
use App\Models\Staff\StaffRetiredResignedDetail;
use App\Models\User;
use Carbon\Carbon;
use DataTables;
use Illuminate\Support\Facades\DB;

class DashboardRepository extends Controller
{

    public function getTopTenLeaveTaker($start_date = '', $end_date = '')
    {

        $academic_id = academicYearId();
        $absenceEntries = AttendanceManualEntry::with('user')->selectRaw('COUNT(*) as total, employment_id')
            ->where('attendance_status', '=', 'Absence')
            ->where('academic_id', $academic_id)
            ->when(!empty($start_date) && !empty($end_date), function ($query) use ($start_date, $end_date) {
                return $query->whereRaw("attendance_date BETWEEN '" . $start_date . "' and '" . $end_date . "'");
            })
            ->whereHas('user', function ($query) {
                $query->where('institute_id', session()->get('staff_institute_id'));
            })
            ->groupBy('employment_id')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        return $absenceEntries;
    }

    public function getInstituteAgeWiseData($start_date = '', $end_date = '')
    {
        $result = DB::table('users as u')
            ->join('staff_personal_info as p', 'u.id', '=', 'p.staff_id')
            ->join('institutions as i', 'u.institute_id', '=', 'i.id')
            ->select('i.name')
            ->selectRaw("COUNT(CASE WHEN DATEDIFF(YEAR, p.dob, GETDATE()) >= 1 AND DATEDIFF(YEAR, p.dob, GETDATE()) <= 25 THEN 1 END) AS age_1_25")
            ->selectRaw("COUNT(CASE WHEN DATEDIFF(YEAR, p.dob, GETDATE()) > 25 AND DATEDIFF(YEAR, p.dob, GETDATE()) <= 35 THEN 1 END) AS age_25_35")
            ->selectRaw("COUNT(CASE WHEN DATEDIFF(YEAR, p.dob, GETDATE()) > 35 AND DATEDIFF(YEAR, p.dob, GETDATE()) <= 45 THEN 1 END) AS age_35_45")
            ->selectRaw("COUNT(CASE WHEN DATEDIFF(YEAR, p.dob, GETDATE()) > 45 AND DATEDIFF(YEAR, p.dob, GETDATE()) <= 55 THEN 1 END) AS age_45_55")
            ->selectRaw("COUNT(CASE WHEN DATEDIFF(YEAR, p.dob, GETDATE()) > 55 AND DATEDIFF(YEAR, p.dob, GETDATE()) <= 80 THEN 1 END) AS age_55_80")
            ->groupBy('i.name')
            ->get();
        $javascriptData = [];

        foreach ($result as $row) {
            $javascriptData[] = [
                'name' => $row->name,
                'data' => [
                    $row->age_1_25,
                    $row->age_25_35,
                    $row->age_35_45,
                    $row->age_45_55,
                    $row->age_55_80,
                ],
            ];
        }
        // Now you can convert $javascriptData to JSON and pass it to your JavaScript code
        $javascriptDataJson = json_encode($javascriptData);

        return $javascriptDataJson;
    }

    public function getTotalStaffCountByInstitutions($start_date = '', $end_date = '')
    {
        $results = User::join('institutions', 'institutions.id', '=', 'users.institute_id')
            ->whereNull('is_super_admin')
            ->selectRaw('COUNT(*) as total, institutions.name')
            ->groupBy('institutions.name')
            ->get();

        return $results;
    }

    public function monthlyGraphUser($start_date = '', $end_date = '')
    {

        if (empty($start_date) && empty($end_date)) {
            $start_date = date('Y-m-d', strtotime('-1 month'));
            $end_date = date('Y-m-d');
        }

        $new_addition = User::whereRaw("CAST(created_at AS DATE) BETWEEN '" . $start_date . "' and '" . $end_date . "'")
            ->InstituteBased()
            ->count();

        $resigned = StaffRetiredResignedDetail::with('staff')->where('types', 'resigned')
            ->whereRaw("CAST(last_working_date AS DATE) BETWEEN '" . $start_date . "' and '" . $end_date . "'")
            ->whereHas('staff', function ($query) {
                $query->where('institute_id', session()->get('staff_institute_id'));
            })
            ->count();

        $retired = StaffRetiredResignedDetail::with('staff')->where('types', 'retired')
            ->whereRaw("CAST(last_working_date AS DATE) BETWEEN '" . $start_date . "' and '" . $end_date . "'")
            ->whereHas('staff', function ($query) {
                $query->where('institute_id', session()->get('staff_institute_id'));
            })
            ->count();

        $response = [
            'addition' => $new_addition,
            'resigned' => $resigned,
            'retired' => $retired
        ];
        return $response;
    }

    public function getStaffResingedRetiredList($type, $start_date = '', $end_date = '')
    {

        if (empty($start_date) && empty($end_date)) {
            $start_date = date('Y-m-d', strtotime('-1 month'));
            $end_date = date('Y-m-d');
        }

        $details = StaffRetiredResignedDetail::with('staff')->where('types', $type)
            ->whereRaw("CAST(last_working_date AS DATE) BETWEEN '" . $start_date . "' and '" . $end_date . "'")
            ->whereHas('staff', function ($query) {
                $query->where('institute_id', session()->get('staff_institute_id'));
            })
            ->get();

        return $details;
    }

    public function leaveChartCount($start_date = '', $end_date = '')
    {

        if (empty($start_date) && empty($end_date)) {
            $start_date = date('Y-m-d', strtotime('-1 month'));
            $end_date = date('Y-m-d');
        }

        // $start_date = '2023-03-01';
        // $end_date = '2023-03-01';

        $present = DB::table(function ($subquery) use ($start_date, $end_date) {
            $subquery->from('attendance_manual_entries')
                ->selectRaw('COUNT(*) AS cnt')
                ->whereBetween('attendance_date', [$start_date, $end_date])
                ->where('attendance_status', 'present')
                ->groupBy('attendance_date');
        }, 'counts')
            ->selectRaw('AVG(cnt) AS average_count')
            ->first();

        $absence = DB::table(function ($subquery) use ($start_date, $end_date) {
            $subquery->from('attendance_manual_entries')
                ->selectRaw('COUNT(*) AS cnt')
                ->whereBetween('attendance_date', [$start_date, $end_date])
                ->where('attendance_status', 'absence')
                ->groupBy('attendance_date');
        }, 'counts')
            ->selectRaw('AVG(cnt) AS average_count')
            ->first();

        $el_count = StaffLeave::select('staff_leaves.*')
            ->join('leave_heads', 'leave_heads.id', '=', 'staff_leaves.leave_category_id')
            ->where('leave_heads.code', 'el')
            ->where('staff_leaves.status', 'approved')
            ->where('staff_leaves.from_date', '>=', $start_date)
            ->where('staff_leaves.to_date', '<=', $end_date)
            ->sum('no_of_days');

        $cl_count = StaffLeave::select('staff_leaves.*')
            ->join('leave_heads', 'leave_heads.id', '=', 'staff_leaves.leave_category_id')
            ->where('leave_heads.code', 'cl')
            ->where('staff_leaves.status', 'approved')
            ->where('staff_leaves.from_date', '>=', $start_date)
            ->where('staff_leaves.to_date', '<=', $end_date)
            ->sum('no_of_days');

        $ml_count = StaffLeave::select('staff_leaves.*')
            ->join('leave_heads', 'leave_heads.id', '=', 'staff_leaves.leave_category_id')
            ->where('leave_heads.code', 'ml')
            ->where('staff_leaves.status', 'approved')
            ->where('staff_leaves.from_date', '>=', $start_date)
            ->where('staff_leaves.to_date', '<=', $end_date)
            ->sum('no_of_days');

        $eol_count = StaffLeave::select('staff_leaves.*')
            ->join('leave_heads', 'leave_heads.id', '=', 'staff_leaves.leave_category_id')
            ->where('leave_heads.code', 'eol')
            ->where('staff_leaves.status', 'approved')
            ->where('staff_leaves.from_date', '>=', $start_date)
            ->where('staff_leaves.to_date', '<=', $end_date)
            ->sum('no_of_days');

        return [
            $present->average_count ?? 0,
            $absence->average_count ?? 0,
            $el_count,
            $cl_count,
            $ml_count,
            $eol_count
        ];
    }

    public function financialChart()
    {

        $academic_id = academicYearId();

        $academic_info = AcademicYear::find($academic_id);

        $from = date('Y-m-d', strtotime($academic_info->from_year . '-03-01'));
        $to = date('Y-m-d', strtotime($academic_info->to_year . '-02-28'));

        // $expenses = DB::table('staff_salaries')
        //     ->select(DB::raw('SUM(net_salary) as expense'), 'salary_date')
        //     ->selectRaw("CONCAT(DATENAME(MONTH, salary_date), ' ', DATEPART(YEAR, salary_date)) as formatted_date")
        //     ->where('salary_date', '>=', $from)
        //     ->where('salary_date', '<=', $to)
        //     ->groupByRaw('DATENAME(MONTH, salary_date), DATEPART(YEAR, salary_date), salary_date')
        //     ->get();

        $expenses = DB::table('staff_salaries')
            ->select(DB::raw('SUM(net_salary) as expense'), 'salary_date')
            ->selectRaw("DATENAME(MONTH, [salary_date]) + ' ' + CAST(DATEPART(YEAR, [salary_date]) AS VARCHAR(4)) AS formatted_date")
            ->where('salary_date', '>=', '2023-03-01')
            ->where('salary_date', '<=', '2024-02-28')
            ->groupByRaw('DATENAME(MONTH, salary_date), DATEPART(YEAR, salary_date), salary_date')
            ->get();

        return $expenses;
    }
}
