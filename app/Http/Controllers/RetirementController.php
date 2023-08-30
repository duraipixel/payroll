<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\ReportHelper;
use Illuminate\Http\Request;

class RetirementController extends Controller
{
    use ReportHelper;

    function index(Request $request)
    {
        $users = $this->collection($request)->paginate($request->limit ?? 15);
        $month = $request->month ?? date('m');
        return view('pages.reports.retirement.index', ['users' =>  $users, "month" => $month]);
    }
}