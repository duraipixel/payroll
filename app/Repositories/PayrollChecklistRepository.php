<?php

namespace App\Repositories;

use App\Http\Controllers\Controller;
use App\Models\AttendanceManagement\AttendanceManualEntry;
use App\Models\PayrollManagement\HoldSalary;
use App\Models\PayrollManagement\ItStaffStatement;
use App\Models\PayrollManagement\SalaryField;
use App\Models\User;

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
        })
            ->where('attendance_status', 'Absence')
            ->get();

        if (isset($attendance) && !empty($attendance)) {
            $not_requested = $approval_pending = $approved_leave = 0;
            foreach ($attendance as $item) {

                $status =  getStaffLeaveRequestStatus($item->employment_id, $item->attendance_date);
                if ($status == 'Leave Approval Pending') {
                    $approval_pending += 1;
                } else if ($status == 'Leave Approved') {
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

    public function getEmployeePendingPayroll()
    {

        $response['pending_approval'] = User::where('verification_status', 'pending')
            ->whereNull('is_super_admin')->count();

        $response['approved'] = User::where('verification_status', 'approved')
            ->whereNull('is_super_admin')->count();
        return $response;
    }

    public function getPendingITEntry()
    {

        $response['verified_user'] = User::where('verification_status', 'approved')
            ->whereNull('is_super_admin')->count();
        $response['pending_it'] = User::join('it_staff_statements', 'it_staff_statements.staff_id', '=', 'users.id')
            ->where('verification_status', 'approved')
            ->where('it_staff_statements.academic_id', session()->get('academic_id'))
            ->whereNull('is_super_admin')->count();
        $process = false;
        if ($response['verified_user'] == $response['pending_it']) {
            $process = true;
        }
        $response['process_it'] = $process;
        return $response;
    }

    public function getToPayEmployee($date)
    {
        $hold_month =  date('Y-m-01', strtotime($date));
        $date = date('Y-m-d', strtotime($date. '-1 month'));
        $month_start = date('Y-m-01', strtotime($date));
        $month_end = date('Y-m-t', strtotime($date));
        
        /**
         *  1. Get payable staff & Join Date;
         *  2. Month working days
         *  3. Month worked days
         *  4. Get salary pattern for staff
         *  5. Finalize Their Salary and show
         */
        
        $users = User::select('users.*')->
            with(['workedDays' => function ($query) use ($month_start, $month_end) {
                $query->whereDate('attendance_date', '>=', $month_start);
                $query->whereDate('attendance_date', '<=', $month_end);
            }, 'currentSalaryPattern', 'firstAppointment'])
            ->join('it_staff_statements', 'it_staff_statements.staff_id', '=', 'users.id')
            ->leftJoin('hold_salaries', function($join) use ( $hold_month ){
                $join->on('hold_salaries.staff_id', '=', 'users.id')
                ->where('hold_salaries.hold_month', '=', $hold_month);
            })
            ->where('verification_status', 'approved')
            ->where('it_staff_statements.academic_id', session()->get('academic_id'))
            ->whereNull('is_super_admin')
            ->whereNull('hold_salaries.hold_month')
            ->get();
        
        return $users;

    }

    public function getHoldSalaryEmployee($date) {

        // $date = date('Y-m-d', strtotime($date . ' -1 month'));
        $start_date = date('Y-m-01', strtotime($date));
        $details = HoldSalary::whereDate('hold_month', $start_date)->get();
        return $details;

    }

  
}
