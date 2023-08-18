<?php

use App\Models\AttendanceManagement\LeaveMapping;
use App\Models\PayrollManagement\StaffSalaryPattern;

function getLeaveHeadsSeperation($nature_of_employment_id) {
    $data = LeaveMapping::where('nature_of_employment_id', $nature_of_employment_id)->get();

    $html = '';
    if( isset( $data ) && !empty( $data ) ) {
        foreach ($data as $item ) {
            
            $html .= '<div>'.$item->leave_head->name.' ('.$item->leave_days.')</div>';

        }
    }
    return $html;
}

function pendingRevisionCount() {
    return StaffSalaryPattern::where(['status' => 'active', 'verification_status' => 'pending'])->count();
}

function getAcademicLeaveAllocated( $academic_id, $nature_of_employment_id, $leave_head ) {

    $info = LeaveMapping::select('leave_days')
                        ->join('leave_heads', 'leave_heads.id', '=', 'leave_mappings.leave_head_id')
                        ->where(['leave_mappings.academic_id' => $academic_id, 'leave_mappings.nature_of_employment_id' => $nature_of_employment_id])
                        ->where('leave_heads.name', $leave_head)
                        ->first();
    return $info->leave_days ?? 0;

}

function getLeaveAccumulated($nature_of_employment_id, $leave_head, $staff_info ) {
    return 0;
}