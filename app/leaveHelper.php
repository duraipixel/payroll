<?php

use App\Models\AttendanceManagement\LeaveMapping;

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