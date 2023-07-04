<?php

namespace App\Http\Controllers\PayrollManagement;

use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use App\Models\PayrollManagement\PayrollPermission;
use Illuminate\Http\Request;

class OverviewController extends Controller
{
    public function index() {
        $breadcrums = array(
            'title' => 'Payroll Overview',
            'breadcrums' => array(
                array(
                    'link' => '', 'title' => 'Payroll Overview'
                ),
            )
        );
        $date = date('Y-m-d');
        return view('pages.payroll_management.overview.index', compact('breadcrums', 'date'));
    }

    public function getMonthData(Request $request)
    {
        $academic_id = session()->get('academic_id');
        $academic_info = AcademicYear::find($academic_id);
        
        $dates = $request->dates;
        $month_no = $request->month_no;
        $payout_date = date('Y-m-01', strtotime($dates));
        
        $lock_info = PayrollPermission::where(['academic_id' => academicYearId(), 'payout_month' => $payout_date])->first();
        /** 
         * check previous month payroll created
         */
        
        $params = array(
            'date' => $dates,
            'lock_info' => $lock_info
        );
        
        return view('pages.payroll_management.overview._ajax_month_view', $params );
    }
    
    public function setPermission(Request $request) {

        $status = $request->status;
        $mode = $request->mode;
        $payout_date = $request->payout_date;
        $payout_date = date('Y-m-01', strtotime($payout_date));

        $ins['academic_id'] = academicYearId();
        $ins['payout_month'] = $payout_date;

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
        $title = ucfirst( str_replace('_', ' ', $mode ) );
        $params = array(
                    'status' => $status,
                    'title' => $title,
                    'payout_date' => $payout_date,
                    'mode' => $mode,
                    
                );

        $content = view('pages.payroll_management.overview._payroll_input_form', $params);
        return view('layouts.modal.dynamic_modal', compact('content', 'title'));

    }
}
