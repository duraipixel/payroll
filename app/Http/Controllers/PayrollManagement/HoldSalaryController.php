<?php

namespace App\Http\Controllers\PayrollManagement;

use App\Http\Controllers\Controller;
use App\Models\PayrollManagement\HoldSalary;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DataTables;

class HoldSalaryController extends Controller
{
    public function index(Request $request)
    {

        $breadcrums = array(
            'title' => 'Hold Salary',
            'breadcrums' => array(
                array(
                    'link' => '', 'title' => 'Hold Salary'
                ),
            )
        );   
        $search_date = date('Y-m-d');     
        
        return view('pages.payroll_management.hold.index', compact('breadcrums', 'search_date'));
    }

    public function addEdit(Request $request)
    {
        $title = 'Hold Salary';
        $staff = User::select('users.*')->join('staff_salary_patterns', 'staff_salary_patterns.staff_id', '=', 'users.id')
                ->where('users.status', 'active')
                ->where('staff_salary_patterns.status', 'active')
                ->get();
        $payroll_hold_month = $request->payroll_hold_month;

        $params = array(
            'staff' => $staff,
            'title' => $title,
            'payroll_hold_month' => $payroll_hold_month
        );
        return view('pages.payroll_management.hold.add_edit', $params);
    }

    public function save(Request $request)
    {

        $id = $request->id ?? '';
        $validator = Validator::make($request->all(), [
            'employee_id' => 'required|unique:hold_salaries,staff_id,' . $id . ',id,deleted_at,NULL',
            'hold_reason' => 'required',
        ]);

        if ($validator->passes()) {
            
            $ins['staff_id'] = $request->employee_id;
            $ins['academic_id'] = academicYearId();
            $ins['hold_reason'] = $request->hold_reason;
            $ins['remarks'] = $request->remarks ?? '';
            $ins['hold_at'] = date('Y-m-d H:i:s');
            $ins['hold_by'] = auth()->id();
            $ins['status'] = 'active';
            $ins['hold_month'] = date('Y-m-d', strtotime($request->hold_month));
            $data = HoldSalary::updateOrCreate(['staff_id' => $request->employee_id], $ins);
            $error = 0;
            $message = 'success';
        } else {
            $error = 1;
            $message = $validator->errors()->all();
        }
        return response()->json(['error' => $error, 'message' => $message]);
    }

    public function view(Request $request) {

        $search_date = $request->dates;
        $month_no = $request->month_no;       
        
        if ($request->ajax() && $request->from == '') {
            $hold_date = $request->hold_date;
            $start_date = date('Y-m-1', strtotime($hold_date));
            $end_date = date('Y-m-1', strtotime($hold_date));
            
            $data = HoldSalary::with(['staff', 'staff.currentSalaryPattern'])
                        ->when(!empty( $hold_date ), function($query) use($start_date, $end_date){
                            $query->whereBetween('hold_month', [$start_date, $end_date]);
                        })->select('*')->get()
                        ->map(function ($item) {
                            $item->current_salary_pattern = $item->staff->currentSalaryPattern ?? '-';
                            return $item;
                        });

            // dd( $data[0]->staff->currentSalaryPattern );
            $status = $request->get('status');
            $datatable_search = $request->datatable_search ?? '';
            $keywords = $datatable_search;

            $datatables =  Datatables::of($data)
                ->filter(function ($query) use ($status, $keywords) {
                    if ($keywords) {
                        $date = date('Y-m-d', strtotime($keywords));
                        return $query->where(function ($q) use ($keywords, $date) {

                            $q->where('staff.name', 'like', "%{$keywords}%")
                                ->orWhereDate('hold_salaries.created_at', $date);
                        });
                    }
                })
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $del_btn = '<a href="javascript:void(0);" onclick="deleteHold(' . $row->id . ')" class="btn btn-icon btn-active-danger btn-light-danger mx-1 w-30px h-30px" > 
                    <i class="fa fa-trash"></i></a>';
                    return $del_btn;
                })
                ->rawColumns(['action']);
            return $datatables->make(true);

        }
            
        return view('pages.payroll_management.hold.view_ajax', compact('search_date', 'month_no'));
    }

    public function delete(Request $request) {

        $id = $request->id;
        HoldSalary::where('id', $id)->delete();

        return response()->json([ 'message' => "Successfully deleted!", 'status' => 1 ] );
        
    }
}
