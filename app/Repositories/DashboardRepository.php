<?php

namespace App\Repositories;

use App\Http\Controllers\Controller;
use App\Models\AttendanceManagement\AttendanceManualEntry;
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
            ->when(!empty( $start_date ) && !empty( $end_date ), function($query) use($start_date, $end_date) {
                return $query->whereRaw("attendance_date BETWEEN '" . $start_date . "' and '" . $end_date . "'");
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

    public function getTotalStaffCountByInstitutions( $start_date = '', $end_date = '' )
    {
        $results = User::join('institutions', 'institutions.id', '=', 'users.institute_id')
            ->whereNull('is_super_admin')
            ->selectRaw('COUNT(*) as total, institutions.name')
            ->groupBy('institutions.name')
            ->get();

        return $results;
    }

    public function monthlyGraphUser( $start_date = '', $end_date = '' ) {

        if( empty( $start_date ) && empty( $end_date ) ) {
            $start_date = date('Y-m-d', strtotime('-1 month'));
            $end_date = date('Y-m-d');
        }

        $new_addition = User::whereRaw("CAST(created_at AS DATE) BETWEEN '" . $start_date . "' and '" . $end_date . "'")->count();

        $resigned = StaffRetiredResignedDetail::where('types', 'resigned')
                ->whereRaw("CAST(last_working_date AS DATE) BETWEEN '" . $start_date . "' and '" . $end_date . "'")->count();

        $retired = StaffRetiredResignedDetail::where('types', 'retired')
                ->whereRaw("CAST(last_working_date AS DATE) BETWEEN '" . $start_date . "' and '" . $end_date . "'")->count();

        $response = [
                        'addition' => $new_addition,
                        'resigned' => $resigned,
                        'retired' => $retired
        ];
        return $response;
    }

    public function getStaffResingedRetiredList($type, $start_date = '', $end_date = '' ) {

        if( empty( $start_date ) && empty( $end_date ) ) {
            $start_date = date('Y-m-d', strtotime('-1 month'));
            $end_date = date('Y-m-d');
        }

        $details = StaffRetiredResignedDetail::with('staff')->where('types', $type)
                        ->whereRaw("CAST(last_working_date AS DATE) BETWEEN '" . $start_date . "' and '" . $end_date . "'")->get();

        return $details;
    }
    
}
