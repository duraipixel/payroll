<?php

namespace App\Http\Controllers\PayrollManagement;

use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
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
        return view('pages.payroll_management.overview.index', compact('breadcrums'));
    }

    public function getMonthData(Request $request)
    {
        $academic_id = session()->get('academic_id');
        $academic_info = AcademicYear::find($academic_id);
        dd( $academic_info );
        $month_no = $request->month_no;
        return view('pages.payroll_management.overview._ajax_month_view');
    }
}
