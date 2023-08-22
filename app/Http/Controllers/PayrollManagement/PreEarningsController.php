<?php

namespace App\Http\Controllers\PayrollManagement;

use App\Http\Controllers\Controller;
use App\Models\Master\NatureOfEmployment;
use App\Models\Staff\StaffSalaryPreEarning;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DataTables;
use Illuminate\Validation\Rule;

class PreEarningsController extends Controller
{
    public function index( Request $request) {
        
        $page_type = $request->type;
        $title = ucwords( str_replace('_', ' ', $page_type)); 
        $breadcrums = array(
            'title' => ucwords( str_replace('_', ' ', $page_type)),
            'breadcrums' => array(
                array(
                    'link' => '', 'title' => ucwords( str_replace('_', ' ', $page_type))
                ),
            )
        );
        $search_date = date('Y-m-d');
   
        return view('pages.payroll_management.earnings.index', compact('breadcrums', 'title', 'page_type', 'search_date'));

    }

    public function tableView( Request $request ) {

        $search_date = $request->dates;
        $month_no = $request->month_no;
        $page_type = $request->page_type;
        $title = ucwords( str_replace('_', ' ', $page_type)); 
       
        if ($request->ajax() && $request->from == '') {
            $hold_date = $request->hold_date;
            $start_date = date('Y-m-1', strtotime($hold_date));
            $end_date = date('Y-m-1', strtotime($hold_date));

            $data = StaffSalaryPreEarning::with(['staff'])
                ->when(!empty($hold_date), function ($query) use ($start_date, $end_date) {
                    $query->whereBetween('salary_month', [$start_date, $end_date]);
                })
                ->where('earnings_type', $page_type);

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

        return view('pages.payroll_management.earnings.'.$page_type.'_view_ajax', compact('search_date', 'month_no', 'title', 'page_type'));

    }

    public function add(Request $request) {

        $page_type = $request->type;
        $title = 'Add '.ucwords( str_replace('_', ' ', $page_type)); 
        $employees = User::whereNull('is_super_admin')
                    ->where('verification_status','approved')->get();
        $nature_of_employees = NatureOfEmployment::where('status', 'active')->get();

        $params = [
            'page_type' => $page_type,
            'title' => $title,
            'employees' => $employees,
            'nature_of_employees' => $nature_of_employees
        ];
        return view('pages.payroll_management.earnings.add_form', $params);

    }

    public function getTableView( Request $request ) {

        $employee_id = $request->employee_id ?? ['all'];
        $employees  = User::whereNull('is_super_admin')
                        ->where('verification_status','approved')
                        ->when( current($employee_id) != 'all', function($query) use($employee_id){
                            $query->whereIn('users.id', $employee_id);
                        })
                        ->get();
        $params     = [ 'employees' => $employees ];
        return view('pages.payroll_management.earnings._form_table', $params);
    }

    public function save( Request $request) {

        $bonus = $request->bonus;
        $has_error = false;
        $error = 0;

        if( isset( $bonus ) && count( $bonus ) > 0 ) {
            foreach ($bonus as $staff_id) {
                if( !$_POST['amount_'.$staff_id ] ) {
                    $has_error = true;
                    $error = 1;
                    $message = 'Please enter amount for selected staff';
                }
            }
        }

        if( !$has_error ) {
            
            $page_type = $request->page_type;
            $salary_month = $request->salary_month;
            $common_remarks = $request->common_remarks;

            if( isset( $bonus ) && count( $bonus ) > 0 ) {
                foreach ($bonus as $staff_id) {
                  
                    $ins = [];
                    $ins['staff_id'] = $staff_id;
                    $ins['salary_month'] = $salary_month;
                    $ins['academic_id'] = academicYearId();
                    $ins['amount'] = $_POST['amount_'.$staff_id ] ?? 0;
                    $ins['remarks'] = $common_remarks ?? $_POST['remarks_'.$staff_id] ?? null;
                    $ins['earnings_type'] = $page_type;
                    $ins['status'] = 'active';
                    $ins['added_by'] = auth()->user()->id;

                    StaffSalaryPreEarning::updateOrCreate(['staff_id' => $staff_id, 'salary_month' => $salary_month], $ins);
                }
                $error = 0;
                $message = ucwords( str_replace('_', ' ', $page_type)).' added successfully';
                $return_url = route('earnings.index', ['type' => $page_type]);
            }
        }

        return ['error' => $error, 'message' => $message, 'return_url' => $return_url ?? '' ];

    }
}
