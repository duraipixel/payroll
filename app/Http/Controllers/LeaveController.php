<?php

namespace App\Http\Controllers;

use App\Exports\LeavesReportExport;
use App\Http\Controllers\Controller;
use App\Models\Leave\StaffLeave;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class LeaveController extends Controller
{
    function collection($request)
    {
        $perPage = (!empty($request->limit) && $request->limit === 'all') ? 100000000000000000000 : $request->limit;
        $leaves = StaffLeave::whereHas('user.position.department', function ($q) use ($request) {
            if (!empty($request->department)) $q->where('id', '=', $request->department);
        })->paginate($perPage);
        $month = $request->month ?? date('m');
        return [ $leaves, $month];
    }
    function index(Request $request)
    {
        [$leaves, $month] = $this->collection($request);
        return view('pages.reports.leaves.index', ['leaves' =>  $leaves, "month" => $month]);
    }

    function export(Request $request)
    {
        [$leaves] = $this->collection($request);
        return Excel::download(new LeavesReportExport($leaves), 'leaves-reports.xlsx');
    }
}
