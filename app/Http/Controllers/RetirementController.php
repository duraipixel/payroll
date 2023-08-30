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
        $users = $this->collection($request)->paginate($request->limit ?? 15);
        $month = $request->month ?? date('m');
        return view('pages.reports.retirement.index', ['users' =>  $users, "month" => $month]);
    }

    function export(Request $request) {
        $users = $this->collection($request)->get();
        return Excel::download(new RetirementExport($users),'retirement-report.xlsx');
    }
}