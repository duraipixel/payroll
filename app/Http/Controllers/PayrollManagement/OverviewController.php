<?php

namespace App\Http\Controllers\PayrollManagement;

use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use App\Models\AttendanceManagement\AttendanceManualEntry;
use App\Models\PayrollManagement\Payroll;
use App\Models\PayrollManagement\PayrollPermission;
use App\Repositories\PayrollChecklistRepository;
use Illuminate\Http\Request;

class OverviewController extends Controller
{

    private $checklistRepository;

    public function __construct(PayrollChecklistRepository $checklistRepository) {
        $this->checklistRepository = $checklistRepository;
    }

    public function index() {

        $breadcrums = array(
            'title' => 'Payroll Overview',
            'breadcrums' => array(
                array(
                    'link' => '', 'title' => 'Payroll Overview'
                ),
            )
        );
        $acYear = AcademicYear::find(academicYearId());
        $from_year = $acYear->from_year;
        $start_year = '01-' . $acYear->from_month . '-' . $acYear->from_year;
        $end_year = '01-' . $acYear->to_month . '-' . $acYear->to_year;

        $date = $start_year;
        $from_date = date('Y-m-01', strtotime($date));
        $to_date = date('Y-m-t', strtotime($date));
        $working_days = date('t', strtotime($date));
        
        $payroll = Payroll::where('from_date', $from_date)->where('to_date', $to_date)->first();
        $previous_month_start = date('Y-m-01', strtotime($date.' - 1 month'));
        $previous_month_end = date('Y-m-t', strtotime($date.' - 1 month'));

        $previous_payroll = Payroll::where('from_date', $previous_month_start)->where('to_date', $previous_month_end)->first();
        
        return view('pages.payroll_management.overview.index', compact('breadcrums', 'date', 'payroll', 'working_days', 'previous_payroll', 'from_year'));

    }

    public function getMonthData(Request $request)
    {
        $academic_id = session()->get('academic_id');

        $acYear = AcademicYear::find(academicYearId());
        $from_year = $acYear->from_year;
        $start_year = '01-' . $acYear->from_month . '-' . $acYear->from_year;
        $end_year = '01-' . $acYear->to_month . '-' . $acYear->to_year;

        
        $dates = $request->dates;
        $month_no = $request->month_no;
        $start_year = date('Y-m-01', strtotime($start_year));
        $payout_date = date('Y-m-01', strtotime($dates));

        $from_date = date('Y-m-01', strtotime($dates));
        $to_date = date('Y-m-t', strtotime($dates));
        $working_days = date('t', strtotime($to_date));
        $payroll = Payroll::where('from_date', $from_date)->where('to_date', $to_date)->first();

        $previous_month_start = date('Y-m-01', strtotime($dates.' - 1 month'));
        $previous_month_end = date('Y-m-t', strtotime($dates.' - 1 month'));

        $previous_payroll = Payroll::where('from_date', $previous_month_start)->where('to_date', $previous_month_end)->first();
        if( $start_year == $payout_date ) {
            $previous_payroll = 'yes';
        }
        $lock_info = PayrollPermission::where(['academic_id' => academicYearId(), 'payout_month' => $payout_date])->first();
        /** 
         * check previous month payroll created
         */
        $params = array(
            'date' => $dates,
            'lock_info' => $lock_info,
            'payroll' => $payroll,
            'working_days' => $working_days,
            'previous_payroll' => $previous_payroll
        );
        
        return view('pages.payroll_management.overview._ajax_month_view', $params );
    }
    
    public function setPermission(Request $request) {

        $status = $request->status;
        $mode = $request->mode;
        $payout_date = $request->payout_date;
        $payout_date = date('Y-m-01', strtotime($payout_date));
        $payout_id = $request->payout_id;

        $ins['academic_id'] = academicYearId();
        $ins['payout_month'] = $payout_date;
        $ins['payroll_id'] = $payout_id;
        if( $mode == 'payroll_inputs' ) {
            $ins['payroll_inputs'] = $status;
            $message = 'Payroll Input Permission set Successfully';
        }
       
        if( $mode == 'emp_view_release' ) {
            $message = 'Employee View Release Permission set Successfully';
            $ins['emp_view_release'] = $status;
        }
        if( $mode == 'it_statement_view' ) {
            $message = 'IT Statement Employee View set Successfully';
            $ins['it_statement_view'] = $status;
        }
        if( $mode == 'payroll' ) {
            $message = 'Payroll process '.$status.' Successfully';
            $ins['payroll'] = $status;
        }
        // dd( $ins );
        PayrollPermission::updateOrCreate(['payout_month' => $payout_date, 'academic_id' => academicYearId()], $ins);
        $error = 0;
        return array( 'error' => $error, 'message' => $message );

    }

    public function openPermissionModal(Request $request) {

        $status = $request->status;
        $mode = $request->mode;
        $payout_date = $request->payout_date;
        $payout_id = $request->payout_id;
        $title = ucfirst( str_replace('_', ' ', $mode ) );
        $params = array(
                    'status' => $status,
                    'title' => $title,
                    'payout_date' => $payout_date,
                    'mode' => $mode,
                    'payout_id' => $payout_id
                    
                );

        $content = view('pages.payroll_management.overview._payroll_input_form', $params);
        return view('layouts.modal.dynamic_modal', compact('content', 'title'));

    }

    public function createPayroll(Request $request) {
        
        $payroll_date = $request->payroll_date;
        $from_date = date('Y-m-01', strtotime($payroll_date));
        $to_date = date('Y-m-t', strtotime($payroll_date));

        $ins['from_date'] = $from_date;
        $ins['to_date'] = $to_date;
        $ins['name'] = date('F Y', strtotime($from_date));
        $ins['locked'] = 'no';
        $ins['added_by'] = auth()->id();

        Payroll::create($ins);

        $error = 0;
        $date = $request->payroll_date;
        $month_no = date('m', strtotime($request->payroll_date));
        return array( 'date' => $date, 'month_no' => $month_no,'error' => $error, 'message' =>   date('F Y', strtotime($from_date)) .'  payroll created successfully');
        
    }

    public function processPayrollModal(Request $request) {

        $date = $request->date;
        $payout_id = $request->payout_id;

        /**
         * 1. Employee it declaration Pending
         * 2. New Employee added with pending verification and salary creation
         * 3. Leave Day Finalized
         * 4. Resigned Staff
         * 5. Salary Hold Finalized
         * 6. Hold due Discipline Action
         */

         /**
          * select * from users where verification_status = 'approved';
          */
       
        $leave_data = $this->checklistRepository->getPendingRequestLeave($date);
        $employee_data = $this->checklistRepository->getEmployeePendingPayroll();
        

        $title = 'Payroll Process Confirmation';
        $params = array(
            'date' => $date,
            'payout_id' => $payout_id,
            'leave_data' => $leave_data,
            'title' => $title,
            'employee_data' => $employee_data
        );
        
        return view('pages.payroll_management.overview._payroll_form', $params);
        // return view('layouts.modal.dynamic_modal', compact('content', 'title'));

    }
}
