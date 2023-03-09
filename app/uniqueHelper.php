<?php

use App\Models\Master\Society;
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