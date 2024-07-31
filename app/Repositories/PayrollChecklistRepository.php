<?php

namespace App\Repositories;

use App\Http\Controllers\Controller;
use App\Models\AttendanceManagement\AttendanceManualEntry;
use App\Models\PayrollManagement\HoldSalary;
use App\Models\PayrollManagement\ItStaffStatement;
use App\Models\PayrollManagement\SalaryField;
use App\Models\Staff\StaffRetiredResignedDetail;
use App\Models\User;
use App\Models\Leave\StaffLeave;

class PayrollChecklistRepository extends Controller
{

    public function getPendingRequestLeave($date)
    {

        $date = date('Y-m-d', strtotime($date . ' -1 month'));

        $start_date = date('Y-m-01', strtotime($date));
        $end_date = date('Y-m-t', strtotime($date));

        $attendance = AttendanceManualEntry::where(function ($query) use ($start_date, $end_date) {
            $query->whereDate('attendance_date', '>=', $start_date)
                ->whereDate('attendance_date', '<=', $end_date);
        })->where('institute_id',session()->get('staff_institute_id'))
            ->where('attendance_status', 'Absence')
            ->get();

        $present_attendance = AttendanceManualEntry::where(function ($query) use ($start_date, $end_date) {
            $query->whereDate('attendance_date', '>=', $start_date)
                ->whereDate('attendance_date', '<=', $end_date);
        })->where('institute_id',session()->get('staff_institute_id'))
            ->where('attendance_status', 'Present')
            ->get();
            $pending_leave=StaffLeave::selectRaw('SUM(no_of_days) as taken_leave')->where('from_date', '<=', $start_date)->where('to_date', '>=', $end_date)->where('status','pending')->first();
            $approve_leave=StaffLeave::selectRaw('SUM(granted_days) as taken_leave')->where('from_date', '<=', $start_date)->where('to_date', '>=', $end_date)->where('status','approved')->first();
            $approval_pending=$pending_leave->taken_leave ?? 0;
            $approved_leave=$approve_leave->taken_leave ?? 0;
            // if (isset($attendance) && !empty($attendance)) {
            //     $not_requested = 0;
            //     foreach ($attendance as $item) {
            //         $status=StaffLeave::where('from_date', '<=', $item->attendance_date)->where('to_date', '>=', $item->attendance_date)->where('staff_id',$item->employment_id)->first();
            //         if (!$status){
            //             $not_requested += 1;
            //         }
            //     }
            // }
            $response['total_taken_leaves'] = count($attendance);
            $response['leave_request_pending'] = (int) ((count($attendance)==0)?0 : (count($attendance) -  $approval_pending -  $approved_leave));
            $response['leave_approval_pending'] = (int) $approval_pending ?? 0;
            $response['approved_leave'] =  (int) $approved_leave ?? 0;
            $response['total_present'] = count( $present_attendance );
        return $response;
    }

    public function getEmployeePendingPayroll()
    {
         $response['pending_approval'] = User::with('lastAppointment')
            ->where('institute_id',session()->get('staff_institute_id'))->where('verification_status', 'pending')
            ->whereNotNull('society_emp_code') 
            ->where('status', 'active')
            ->where('transfer_status', 'active')
            // ->whereHas('lastAppointment', function ($query) {
            //     $query->where(function($query1) {
            //         $query1->orWhere('to_appointment', '>=', date('Y-m-d'));
                    
            //     });
            // })
            ->count();

        $response['approved'] = User::with('lastAppointment')->where('verification_status', 'approved')
                ->where('institute_id',session()->get('staff_institute_id'))
                ->where('status', 'active')
                ->where('transfer_status', 'active')
                ->whereNotNull('society_emp_code') 
            // ->whereHas('lastAppointment', function ($query) {
            //     $query->where(function($query1) {
            //         $query1->orWhere('to_appointment', '>=', date('Y-m-d'));
                  
            //     });
            // })
            ->count();
        return $response;
    }

    public function getPendingITEntry()
    {

        $response['verified_user'] = User::with('appointment')
        ->where('verification_status', 'approved')
                ->where('institute_id',session()->get('staff_institute_id'))
                ->where('status', 'active')
                ->where('transfer_status', 'active')
                ->whereNotNull('society_emp_code') 
                // ->where('verification_status', 'approved')
                //     ->whereNull('is_super_admin')
                //     ->where('status', 'active')
                //     ->where('transfer_status', 'active')
                //     ->whereHas('appointment', function ($query) {
                //         $query->where(function($query1) {
                //             $query1->orWhere('to_appointment', '>=', date('Y-m-d'));
                //             $query1->orWhere('is_till_active', 'yes');
                //         });
                    // })->where('institute_id',session()->get('staff_institute_id'))
            ->count();
        $response['pending_it'] = User::with('appointment')->join('it_staff_statements', 'it_staff_statements.staff_id', '=', 'users.id')
            ->where('verification_status', 'approved')
            ->where('users.status', 'active')
            ->where('users.transfer_status', 'active')
            ->where('it_staff_statements.academic_id', session()->get('academic_id'))
            ->where('it_staff_statements.status', 'active')
            ->where('it_staff_statements.lock_calculation', 'yes')
            // ->whereNull('is_super_admin')
            // ->whereHas('appointment', function ($query) {
            //     $query->where(function($query1) {
            //         $query1->orWhere('to_appointment', '>=', date('Y-m-d'));
            //         $query1->orWhere('is_till_active', 'yes');
            //     });
            // })
            ->where('institute_id',session()->get('staff_institute_id'))->count();

        $process = false;
        if ($response['verified_user'] == $response['pending_it']) {
            $process = true;
        }else if ($response['verified_user'] != 0){
            $process = true;
        }
        $response['process_it'] = $process;
        return $response;
    }

    public function getToPayEmployee($date, $show_resigned = true )
    {
        $hold_month =  date('Y-m-01', strtotime($date));
        $date = date('Y-m-d', strtotime($date . '-1 month'));
        $month_start = date('Y-m-01', strtotime($date));
        $month_end = date('Y-m-t', strtotime($date));

        /**
         *  1. Get payable staff & Join Date;
         *  2. Month working days
         *  3. Month worked days
         *  4. Get salary pattern for staff
         *  5. Finalize Their Salary and show
         */

        $users = User::select('users.*')->with(['workedDays' => function ($query) use ($month_start, $month_end) {
                $query->whereDate('attendance_date', '>=', $month_start);
                $query->whereDate('attendance_date', '<=', $month_end);
            }, 'currentSalaryPattern', 'firstAppointment', 'appointment'])
            ->join('it_staff_statements', 'it_staff_statements.staff_id', '=', 'users.id')
            ->leftJoin('hold_salaries', function ($join) use ($hold_month) {
                $join->on('hold_salaries.staff_id', '=', 'users.id')
                    ->where('hold_salaries.hold_month', '=', $hold_month);
            })->where('users.institute_id',session()->get('staff_institute_id'))
            ->where('verification_status', 'approved')
            ->where('it_staff_statements.academic_id', session()->get('academic_id'))
            ->where('it_staff_statements.status', 'active')
            // ->whereNull('is_super_admin')
            ->where('users.status', 'active')
            ->when($show_resigned === true, function($wquery) use($month_start, $month_end){

                $wquery->when(('users.transfer_status' != 'active'),  function($qr) use($month_start, $month_end){
                    $qr->leftJoin('staff_retired_resigned_details', function ($join1) use( $month_start, $month_end){
                        $join1->on('staff_retired_resigned_details.staff_id', '=', 'users.id')
                        ->whereBetween('last_working_date', [$month_start, $month_end]);
                    });
                });
            })
            ->when($show_resigned == false, function($query) {
                $query->where('users.transfer_status', 'active');
            })
            ->whereNull('hold_salaries.hold_month')
            // ->whereHas('appointment', function ($query) {
            //     $query->where(function($query1) {
            //         $query1->orWhere('to_appointment', '>=', date('Y-m-d'));
            //         $query1->orWhere('is_till_active', 'yes');
            //     });
            // })
            ->get();

        return $users;
    }

    public function getHoldSalaryEmployee($date)
    {

        // $date = date('Y-m-d', strtotime($date . ' -1 month'));
        $start_date = date('Y-m-01', strtotime($date));
        $details = HoldSalary::whereDate('hold_month', $start_date)->where('institute_id',session()->get('staff_institute_id'))->get();
        return $details;
    }

    public function getResignedRetired( $date ) {

        $start_date = date('Y-m-d', strtotime($date . ' -1 month'));
        $end_date = date('Y-m-t', strtotime($date . ' -1 month'));

        $info = StaffRetiredResignedDetail::where('is_completed', 'yes')->where('institute_id',session()->get('staff_institute_id'))
                ->whereBetween('last_working_date', [$start_date, $end_date])
                ->get();

        return $info;
    }
}
