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
        $date = date('Y-m-d');
        return view('pages.payroll_management.overview.index', compact('breadcrums', 'date'));
    }

    public function getMonthData(Request $request)
    {
        $academic_id = session()->get('academic_id');
        $academic_info = AcademicYear::find($academic_id);
        
        $dates = $request->dates;
        $month_no = $request->month_no;
        $params = array(
            'date' => $dates
        );
        return view('pages.payroll_management.overview._ajax_month_view', $params );
    }
}
