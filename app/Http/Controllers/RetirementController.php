<?php

namespace App\Http\Controllers;

use App\Exports\Reports\RetirementExport;
use App\Http\Controllers\Controller;
use App\ReportHelper;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class RetirementController extends Controller
{
    use ReportHelper;

    function index(Request $request)
    {
        $perPage = (!empty($request->limit) && $request->limit === 'all') ? 100000000000000000000 : $request->limit;
        $users = $this->collection($request)->paginate($perPage);
        $month = $request->month ?? date('m');
        return view('pages.reports.retirement.index', ['users' =>  $users, "month" => $month]);
    }

    function export(Request $request)
    {    $institute_id=session()->get('staff_institute_id');
        $users = $this->collection($request)->get();
        return Excel::download(new RetirementExport($users,$institute_id??''), 'retirement-report.xlsx');
    }
}
