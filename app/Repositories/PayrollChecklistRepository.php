<?php

namespace App\Repositories;

use App\Http\Controllers\Controller;
use App\Models\AttendanceManagement\AttendanceManualEntry;

class PayrollChecklistRepository extends Controller
{

    public function getPendingRequestLeave($date) {
        
        // dd( $date );
        $date = date('Y-m-d', strtotime( $date. ' -1 month'));
        
        $start_date = date('Y-m-01', strtotime($date));
        $end_date = date('Y-m-t', strtotime($date));

        $attendance = AttendanceManualEntry::whereDate('attendance_date', '>=', $start_date)
                        ->whereDate('attendance_date', '<=', $end_date)->get();

        dd( $attendance );
    }


}