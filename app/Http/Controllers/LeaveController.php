<?php

namespace App\Http\Controllers;

use App\Exports\LeavesReportExport;
use App\Http\Controllers\Controller;
use App\Models\Leave\StaffLeave;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Master\PlaceOfWork;
class LeaveController extends Controller
{
    function collection($request)
    {  
        $place_work=$request->input('place_work');
        $from_date=$request->input('from_date');
        $to_date=$request->input('to_date');
        $perPage = (!empty($request->limit) && $request->limit === 'all') ? 100000000000000000000 : $request->limit;
        $leaves = StaffLeave::whereHas('user.position.department', function ($q) use ($request) {
         $q->where('institute_id',session()->get('staff_institute_id'));
            if (!empty($request->department)) $q->where('id', '=', $request->department);
        })->when(isset($from_date), function ($q) use ($from_date,$to_date) {
            $q->whereBetween('from_date', [$from_date,$to_date]);
        })->when(isset($place_work), function ($q) use ($place_work) {
            $q->where('place_of_work',  $place_work);
        })->orderBy('id','desc')->paginate($perPage);
        $month = $request->month ?? date('m');
        $places = PlaceOfWork::where('status', 'active')->orderBy('name', 'asc')->get();
        // dd($leaves);
        return [ $leaves, $month,$places];
    }
    function index(Request $request)
    {
        [$leaves, $month,$places] = $this->collection($request);
        return view('pages.reports.leaves.index', ['leaves' =>  $leaves, "month" => $month,'places'=>$places]);
    }

    function export(Request $request)
    {
        [$leaves] = $this->collection($request);
        return Excel::download(new LeavesReportExport($leaves), 'leaves-reports.xlsx');
    }
}
