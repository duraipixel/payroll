<?php

use App\Models\AcademicYear;
use App\Models\Leave\StaffLeave;
use App\Models\Master\Society;
use App\Models\Staff\StaffAppointmentDetail;
use App\Models\User;
use Illuminate\Support\Facades\DB;

if (!function_exists('getStaffEmployeeCode')) {
    function getStaffEmployeeCode()
    {
        $society = Society::where('status', 'active')->first();
        $society_code = $society->code;
        $year = date('Y');
        $countNo = '0000';
        $new_emp_code = $society_code.$year.$countNo;
        $codes = DB::table('users')->where('society_emp_code', $new_emp_code)->first();
        if( $codes ) {
            $emp_code = substr($codes->society_emp_code, -4);
            $emp_code = (int)$emp_code + 1;

            if( (4 - strlen($emp_code)) > 0 ) {
                $new_no = '';
                for($i = 0; $i < (4-strlen($emp_code)); $i++) {
                    $new_no .= '0';
                }
                $order_no = $new_no . $emp_code;
                $new_emp_code = $society_code.$year.$order_no;
            }
        }   
        return $new_emp_code;
    }
}

if (!function_exists('getStaffInstitutionCode')) {
    function getStaffInstitutionCode($institute_code)
    {
        $year = date('Y');
        $countNo = '0000';
        $new_emp_code = $institute_code.$year.$countNo;
        $codes = DB::table('users')->where('institute_emp_code', $new_emp_code)->first();
        if( $codes ) {
            $emp_code = substr($codes->institute_emp_code, -4);
            $emp_code = (int)$emp_code + 1;

            if( (4 - strlen($emp_code)) > 0 ) {
                $new_no = '';
                for($i = 0; $i < (4-strlen($emp_code)); $i++) {
                    $new_no .= '0';
                }
                $order_no = $new_no . $emp_code;
                $new_emp_code = $institute_code.$year.$order_no;
            }
        }   
        return $new_emp_code;
    }
}

if (!function_exists('leaveApplicationNo')) {
    function leaveApplicationNo($staff_id, $leave_category)
    {
        $staff_info = User::find($staff_id);
        $institute_code = $staff_info->institute->code;
        $leave = StaffLeave::orderBy('id', 'desc')->first();
        $year = date('Y');
        $countNo = '00001';
        $leave_application_no = $institute_code.$year.$leave_category.$countNo;
        if( $leave ) {
            $emp_code = substr($leave->application_no, -5);
            $emp_code = (int)$emp_code + 1;

            if( (5 - strlen($emp_code)) > 0 ) {
                $new_no = '';
                for($i = 0; $i < (5-strlen($emp_code)); $i++) {
                    $new_no .= '0';
                }
                $order_no = $new_no . $emp_code;
                $leave_application_no = $institute_code.$year.$leave_category.$order_no;
            }
        }   
        return $leave_application_no;
    }
}

if (!function_exists('appointmentOrderNo')) {
    function appointmentOrderNo($staff_id)
    {
        $academy_year = AcademicYear::find(session()->get('academic_id'));
        // dd( $academy_year );
        $year = $academy_year->from_year .'-'.$academy_year->to_year;
        
        $staff_info = User::find($staff_id);
        $institute_code = $staff_info->institute->code;
        $appoint = StaffAppointmentDetail::orderBy('id', 'desc')->first();
        // $year = date('Y');
        $countNo = '00001';
        $appointment_order_no = $countNo.'/'.$institute_code.'/'.$year;
        if( $appoint ) {
            $code = explode('/', $appoint->appointment_order_no);
            $emp_code = current( $code );
            $emp_code = (int)$emp_code + 1;

            if( (5 - strlen($emp_code)) > 0 ) {
                $new_no = '';
                for($i = 0; $i < (5-strlen($emp_code)); $i++) {
                    $new_no .= '0';
                }
                $order_no = $new_no . $emp_code;
                
                $appointment_order_no = $order_no.'/'.$institute_code.'/'.$year;
            }
        }   
        return $appointment_order_no;
    }
}