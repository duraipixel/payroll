<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Leave\StaffLeave;
use App\ReportHelper;
use Illuminate\Http\Request;

class LeaveController extends Controller
{
    function index(Request $request)
    {
        $perPage = (!empty($request->limit) && $request->limit === 'all') ? 100000000000000000000 : $request->limit;
        $leaves = StaffLeave::paginate($perPage);
        $month = $request->month ?? date('m');
        return view('pages.reports.leaves.index', ['leaves' =>  $leaves, "month" => $month]);
    }

    function export(Request $request)
    {
        $users = $this->collection($request)->get();
    }
}
