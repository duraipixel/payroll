<?php

namespace App\Http\Controllers\AttendanceManagement;

use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use Illuminate\Http\Request;

class OverviewController extends Controller
{
    public function index() {

        $breadcrums = array(
            'title' => 'Attendance Overview',
            'breadcrums' => array(
                array(
                    'link' => '', 'title' => 'Attendance Overview'
                ),
            )
        );
        $acYear = AcademicYear::find(academicYearId());
        $from_year = $acYear->from_year;
        $start_year = '01-01-' . $acYear->from_year;
        $end_year = '01-12-' . $acYear->to_year;

        $date = $start_year;
        $from_date = date('Y-m-01', strtotime($date));
        $to_date = date('Y-m-t', strtotime($date));
        $working_days = date('t', strtotime($date));
        
        // $payroll = Payroll::where('from_date', $from_date)->where('to_date', $to_date)->first();
        // $previous_month_start = date('Y-m-01', strtotime($date.' - 1 month'));
        // $previous_month_end = date('Y-m-t', strtotime($date.' - 1 month'));

        // $previous_payroll = Payroll::where('from_date', $previous_month_start)->where('to_date', $previous_month_end)->first();
        $params = array(
            'breadcrums' => $breadcrums,
            'from_year' => $from_year
        );
        return view('pages.attendance_management.overview.index', $params);

    }
}
