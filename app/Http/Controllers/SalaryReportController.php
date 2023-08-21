<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\ReportHelper;
use Illuminate\Http\Request;

class SalaryReportController extends Controller
{
    use ReportHelper;
    function salary_register(Request $request) {
        $users = $this->collection($request)->paginate(15);
        $month = $request->month ?? date('m');
        return view('pages.reports.staff.salary-register.index', ['users' =>  $users, "month" => $month]);
    }
    function salary_register_export(Request $request) {
        $users = $this->collection($request)->limit(10)->get();
        return view('pages.reports.staff.salary-register.export', ['users' =>  $users]);
    }
}
