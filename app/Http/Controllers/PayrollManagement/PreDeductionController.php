<?php

namespace App\Http\Controllers\PayrollManagement;

use App\Http\Controllers\Controller;
use App\Models\Master\NatureOfEmployment;
use App\Models\Staff\StaffSalaryPreDeduction;
use App\Models\User;
use Illuminate\Http\Request;
use DataTables;

class PreDeductionController extends Controller
{
    public function index(Request $request)
    {

        $page_type = $request->type;
        $title = ucwords(str_replace('_', ' ', $page_type));
        $breadcrums = array(
            'title' => ucwords(str_replace('_', ' ', $page_type)),
            'breadcrums' => array(
                array(
                    'link' => '', 'title' => ucwords(str_replace('_', ' ', $page_type))
                ),
            )
        );
        $search_date = date('Y-m-d');

        return view('pages.payroll_management.deductions.index', compact('breadcrums', 'title', 'page_type', 'search_date'));
    }

    public function tableView(Request $request)
    {

        $search_date = $request->dates;
        $month_no = $request->month_no;
        $page_type = $request->page_type;
        $title = ucwords(str_replace('_', ' ', $page_type));

        $start_date = date('Y-m-1', strtotime($search_date));
        $end_date = date('Y-m-t', strtotime($search_date));

        $has_data = StaffSalaryPreDeduction::with(['staff'])
            ->when(!empty($search_date), function ($query) use ($start_date, $end_date) {
                $query->whereBetween('salary_month', [$start_date, $end_date]);
            })
            ->where('staff_salary_pre_deductions.status', 'active')
            ->where('deduction_type', $page_type)->count();

        if ($request->ajax() && $request->from == '') {

            $hold_date = $request->hold_date;
            $start_date = date('Y-m-1', strtotime($hold_date));
            $end_date = date('Y-m-t', strtotime($hold_date));
            $datatable_search = $request->datatable_search ?? '';

            $data = StaffSalaryPreDeduction::select('staff_salary_pre_deductions.*')->with(['staff'])
                ->when(!empty($hold_date), function ($query) use ($start_date, $end_date) {
                    $query->whereBetween('salary_month', [$start_date, $end_date]);
                })
                ->when( !empty( $datatable_search ), function($query) use( $datatable_search ) {
                    $query->whereHas('staff', function ($q) use ($datatable_search) {
                        $q->where('name', 'like', '%' . $datatable_search . '%');
                    });
                })
                ->where('staff_salary_pre_deductions.status', 'active')
                ->where('deduction_type', $page_type);

            // dd( $data[0]->staff->currentSalaryPattern );
            $status = $request->get('status');
            $datatable_search = $request->datatable_search ?? '';
            $keywords = $datatable_search;

            $datatables =  Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $del_btn = '<a href="javascript:void(0);" onclick="deleteEarnings(' . $row->id . ')" class="btn btn-icon btn-active-danger btn-light-danger mx-1 w-30px h-30px" > 
                    <i class="fa fa-trash"></i></a>';
                    return $del_btn;
                })
                ->rawColumns(['action']);
            return $datatables->make(true);
        }

        return view('pages.payroll_management.deductions.' . $page_type . '_view_ajax', compact('search_date', 'month_no', 'title', 'page_type', 'has_data'));
    }

    public function add(Request $request)
    {

        $page_type = $request->type;
        $date = $request->date;
        $salary_date = date('Y-m-01', strtotime( $date ) );
        $title = 'Add ' . ucwords(str_replace('_', ' ', $page_type));
        $employees = User::whereNull('is_super_admin')
            ->where('verification_status', 'approved')->get();
        $nature_of_employees = NatureOfEmployment::where('status', 'active')->get();

        $earnings_details = StaffSalaryPreDeduction::where('salary_month', $salary_date)
                            ->where('deduction_type', $page_type)
                            ->where('status', 'active')->get();
        $earning_ids = $earnings_details->pluck('staff_id')->toArray();

        $params = [
            'page_type' => $page_type,
            'title' => $title,
            'employees' => $employees,
            'nature_of_employees' => $nature_of_employees,
            'earnings_details' => $earnings_details,
            'earning_ids' => $earning_ids,
            'salary_date' => $salary_date
        ];
        return view('pages.payroll_management.deductions.add_form', $params);
    }

    public function getTableView(Request $request)
    {

        $employee_id = $request->employee_id ?? ['all'];
        $salary_date = $request->salary_date;
        $page_type = $request->page_type;
        $employees = User::whereNull('is_super_admin')
            ->where('verification_status', 'approved')
            ->when(current($employee_id) != 'all', function ($query) use ($employee_id) {
                $query->whereIn('users.id', $employee_id);
            })
            ->get();
        $params = ['employees' => $employees, 'salary_date' => $salary_date, 'page_type' => $page_type ];
        return view('pages.payroll_management.deductions._form_table', $params);
    }

    public function save(Request $request)
    {

        $bonus = $request->bonus;
        $has_error = false;
        $error = 0;

        if (isset($bonus) && count($bonus) > 0) {
            foreach ($bonus as $staff_id) {
                if (!$_POST['amount_' . $staff_id]) {
                    $has_error = true;
                    $error = 1;
                    $message = 'Please enter amount for selected staff';
                }
            }
        }

        if (!$has_error) {

            $page_type = $request->page_type;
            $salary_month = $request->salary_month;
            $common_remarks = $request->common_remarks;

            if (isset($bonus) && count($bonus) > 0) {
                StaffSalaryPreDeduction::where(['salary_month' => $salary_month, 'deduction_type' => $page_type])
                                    ->update(['status' => 'inactive']);
                foreach ($bonus as $staff_id) {

                    $ins = [];
                    $ins['staff_id'] = $staff_id;
                    $ins['salary_month'] = $salary_month;
                    $ins['academic_id'] = academicYearId();
                    $ins['amount'] = $_POST['amount_' . $staff_id] ?? 0;
                    $ins['remarks'] = $common_remarks ?? $_POST['remarks_' . $staff_id] ?? null;
                    $ins['deduction_type'] = $page_type;
                    $ins['status'] = 'active';
                    $ins['added_by'] = auth()->user()->id;

                    StaffSalaryPreDeduction::updateOrCreate(['staff_id' => $staff_id, 'salary_month' => $salary_month, 'deduction_type' => $page_type], $ins);
                }
                $error = 0;
                $message = ucwords(str_replace('_', ' ', $page_type)) . ' added successfully';
                $return_url = route('deductions.index', ['type' => $page_type]);
            }
        }

        return ['error' => $error, 'message' => $message, 'return_url' => $return_url ?? ''];
    }

    public function delete(Request $request) {

        $id = $request->id;
        StaffSalaryPreDeduction::where('id', $id)->delete();
        return ['error' => 0, 'message' => 'Deleted successfully'];

    }
}
