<?php

namespace App\Repositories;

use App\Http\Controllers\Controller;
use App\Models\AttendanceManagement\AttendanceManualEntry;
use Carbon\Carbon;
use DataTables;

class DashboardRepository extends Controller
{

    public function getTopTenLeaveTaker()
    {

        $academic_id = academicYearId();
        $absenceEntries = AttendanceManualEntry::with('user')->selectRaw('COUNT(*) as total, employment_id')
            ->where('attendance_status', '=', 'Absence')
            ->where('academic_id', $academic_id)
            ->groupBy('employment_id')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        return $absenceEntries;

    }
}
