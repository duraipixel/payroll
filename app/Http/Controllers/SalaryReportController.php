<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\ReportHelper;
use Illuminate\Http\Request;

class SalaryReportController extends Controller
{
    use ReportHelper;
    function staff_register(Request $request) {
        $users = $this->collection($request)->paginate(15);
        return view('pages.reports.staff.register.index', ['users' =>  $users]);
    }
}
