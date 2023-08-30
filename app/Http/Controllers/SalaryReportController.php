<?php

namespace App\Http\Controllers;

use App\Exports\Reports\SalaryRegisterExport;
use App\Http\Controllers\Controller;
use App\ReportHelper;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class SalaryReportController extends Controller
{
    use ReportHelper;
    function salary_register(Request $request) {
        $users = $this->collection($request)->paginate(15);
        $month = $request->month ?? date('m');
        return view('pages.reports.staff.salary-register.index', ['users' =>  $users, "month" => $month]);
    }
    function salary_register_export(Request $request) {
        $users = $this->collection($request)->get();
        return Excel::download(new SalaryRegisterExport($users),'salary_register_export.xlsx');
    }
}