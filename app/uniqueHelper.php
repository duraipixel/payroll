<?php

use App\Models\AcademicYear;
use App\Models\Leave\StaffLeave;
use App\Models\Master\Institution;
use App\Models\Master\Society;
use App\Models\PayrollManagement\StaffSalary;
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
        $new_emp_code = $society_code . '/' . $year . $countNo;
        // $codes = DB::table('users')->where('society_emp_code', $new_emp_code)->orderBY('society_emp_code','desc')->first();
        $codes = DB::table('users')->orderBY('society_emp_code', 'desc')->first();
        if ($codes) {
            $emp_code = explode('/', $codes->society_emp_code);
            $society_code = $emp_code[0];
            $emp_code = $emp_code[1];
            $emp_code = substr($emp_code, -4);
            $emp_code = $emp_code + 1;

            if ((4 - strlen($emp_code)) > 0) {
                $new_no = '';
                for ($i = 0; $i < (4 - strlen($emp_code)); $i++) {
                    $new_no .= '0';
                }
                $order_no = $new_no . $emp_code;
                $new_emp_code = $society_code . '/' . $year . $order_no;
            } else {
                $new_emp_code = $society_code . '/' . $year . $emp_code;
            }
        }

        return $new_emp_code;
    }
}

if (!function_exists('getStaffInstitutionCode')) {
    function getStaffInstitutionCode($institute_id,$type='new')
    {  
        if($type=='old'){
        
            $institute_code = Institution::find($institute_id);
            $year = date('Y');
            $countNo = '00001';
            $new_emp_code = $institute_code->code . $countNo;
            $codes = DB::table('staff_transfers')->where('to_institution_id', $institute_id)->orderBy('new_institution_code', 'desc')->whereNotNull('new_institution_code')->where('status','pending')->first();
            $code_no=$codes->new_institution_code ?? NUll;
            if(!$codes){
             $codes = DB::table('users')->where('institute_id', $institute_id)->orderBy('institute_emp_code', 'desc')->whereNotNull('institute_emp_code')->first();
             $code_no=$codes->institute_emp_code;
            }
           
            if ( isset($code_no) && !empty($code_no)) {
                $emp_code = substr($code_no, -4);
                $new_no = '0';
                    for ($i = 0; $i < (4 - strlen($emp_code)); $i++) {
                        $new_no .= '0';
                    }
                   
                $code = $institute_code->code.($new_no.($emp_code + 1));
                $data=DB::table('users')->where('institute_id',$institute_id)->where('institute_emp_code',$code)->first();
                if($data){
                $code= $institute_code->code.($new_no.($emp_code + 2));
                
                $data1=DB::table('users')->where('institute_id',$institute_id)->where('institute_emp_code',$code)->first();
                if($data1){
                    $code = $institute_code->code.($new_no.($emp_code + 3));
                $data2=DB::table('users')->where('institute_id',$institute_id)->where('institute_emp_code',$code)->first();
                if($data2){
                    $code = $institute_code->code.($new_no.($emp_code + 4));
                    $data3=DB::table('users')->where('institute_id',$institute_id)->where('institute_emp_code',$code)->first();
                    if($data3){
                        $code = $institute_code->code.($new_no.($emp_code + 5));
                    }
                }

                }
                }
                // dd($code);
                $emp_code=substr($code, -4);
             
                if ((4 - strlen($emp_code)) > 0) {
                    $new_no = '';
                    for ($i = 0; $i < (4 - strlen($emp_code)); $i++) {
                        $new_no .= '0';
                    }
                    $order_no = $new_no . $emp_code;
                    $new_emp_code = $institute_code->code . $order_no;
                } else {
                    $new_emp_code = $institute_code->code . $emp_code;
                }
            }

        }else{
        $institute_code = Institution::find($institute_id);
        $year = date('Y');
        $countNo = '00001';
        $new_emp_code = $institute_code->code . $countNo;
        $codes = DB::table('users')->where('institute_id', $institute_id)->orderBy('institute_emp_code', 'desc')->whereNotNull('institute_emp_code')->first();
        
        if ( isset($codes->institute_emp_code) && !empty($codes->institute_emp_code)) {
            $emp_code = substr($codes->institute_emp_code, -4);
          

            $emp_code = $emp_code + 1;
       


            if ((4 - strlen($emp_code)) > 0) {
                $new_no = '';
                for ($i = 0; $i < (4 - strlen($emp_code)); $i++) {
                    $new_no .= '0';
                }
                $order_no = $new_no . $emp_code;
                $new_emp_code = $institute_code->code . $order_no;
            } else {
                $new_emp_code = $institute_code->code . $emp_code;
            }
        }
        }
       
        
        /**
         * check exist
         */
        
        // $exists = DB::table('users')->where('institute_emp_code', $new_emp_code)->first();
        // if( $exists ) {
        //     getStaffInstitutionCode($institute_id);
        // }
        // dd($new_emp_code);
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
        $leave_application_no = $institute_code . $year . $leave_category . $countNo;
        if ($leave) {
            $emp_code = substr($leave->application_no, -5);
            $emp_code = (int)$emp_code + 1;

            if ((5 - strlen($emp_code)) > 0) {
                $new_no = '';
                for ($i = 0; $i < (5 - strlen($emp_code)); $i++) {
                    $new_no .= '0';
                }
                $order_no = $new_no . $emp_code;
                $leave_application_no = $institute_code . $year . $leave_category . $order_no;
            }
        }
        return $leave_application_no;
    }
}

if (!function_exists('appointmentOrderNo')) {
    function appointmentOrderNo($staff_id, $academic_id )
    {
        $academy_year = AcademicYear::find($academic_id);
        // dd( $academy_year );
        $year = $academy_year->from_year . '-' . $academy_year->to_year;

        $staff_info = User::with('institute')->find($staff_id);
        $institute_code = $staff_info->institute->code ?? '';
        // dump( $staff_info );
        if( $institute_code ) {

            $appoint = StaffAppointmentDetail::select('appointment_order_no')->whereNotNull('appointment_order_no')
                        ->where('academic_id', $academic_id)
                        ->where('appointment_order_no','like',"%{$institute_code}%")
                        ->orderBy('appointment_order_no', 'desc')
                        ->first();
            // $year = date('Y');
            $countNo = '00001';
            $appointment_order_no = $countNo . '/AEWS/' . $institute_code . '/' . $year;
            if ($appoint) {
                $code = explode('/', $appoint->appointment_order_no);
                $emp_code = current($code);
                $emp_code = (int)$emp_code + 1;
    
                if ((5 - strlen($emp_code)) > 0) {
                    $new_no = '';
                    for ($i = 0; $i < (5 - strlen($emp_code)); $i++) {
                        $new_no .= '0';
                    }
                    $order_no = $new_no . $emp_code;
    
                    $appointment_order_no = $order_no . '/AEWS/' . $institute_code . '/' . $year;
                }
            }
        }
        return $appointment_order_no ?? null;
    }
}

if (!function_exists('salaryNo')) {
    function salaryNo()
    {
        $info = StaffSalary::orderBy('salary_no','desc')->whereNotNull('salary_no')->first();
        $number = '0000000001';
        if( $info ) {
            $salary_no = (int)$info->salary_no + 1;

            if ((10 - strlen($salary_no)) > 0) {
                $new_no = '';
                for ($i = 0; $i < (10 - strlen($salary_no)); $i++) {
                    $new_no .= '0';
                }
                $number = $new_no . $salary_no;
            }
        } 
        return $number;
    }
}

if (!function_exists('generateEmpCode')) {
    function generateEmpCode()
    {
        return date('ymdhis');
    }
}
