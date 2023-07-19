<?php

namespace App\Repositories;

use App\Http\Controllers\Controller;
use App\Models\AttendanceManagement\AttendanceManualEntry;

class PayrollChecklistRepository extends Controller
{

    public function getPendingRequestLeave($date) {
 
        $date = date('Y-m-d', strtotime( $date. ' -1 month'));
        
        $start_date = date('Y-m-01', strtotime($date));
        $end_date = date('Y-m-t', strtotime($date));
        
        $attendance = AttendanceManualEntry::where(function($query) use($start_date, $end_date){
                            $query->whereDate('attendance_date', '>=', $start_date)
                            ->whereDate('attendance_date', '<=', $end_date);
                        })
                        ->where('attendance_status', 'Absence')
                        ->get();

        if( isset( $attendance ) && !empty( $attendance ) ) {
            $not_requested = $approval_pending = $approved_leave = 0;
            foreach ($attendance as $item) {
                
                $status =  getStaffLeaveRequestStatus($item->employment_id, $item->attendance_date);
                if( $status == 'Leave Approval Pending' ) {
                    $approval_pending += 1;
                } else if( $status == 'Leave Approved') {
                    $approved_leave += 1;
                } else {
                    $not_requested += 1;
                }
            }
        }

        $response['total_taken_leaves'] = count($attendance);
        $response['leave_request_pending'] = $not_requested;
        $response['leave_approval_pending'] = $approval_pending;
        $response['approved_leave'] = $approved_leave;

        return $response;
        
    }

}