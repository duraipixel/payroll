<?php

namespace App\Http\Controllers\PayrollManagement;

use App\Http\Controllers\Controller;
use App\Models\PayrollManagement\StaffSalaryPattern;
use App\Models\User;
use DataTables;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\AcademicYear;
use App\Models\PayrollManagement\StaffSalaryField;
use App\Models\PayrollManagement\SalaryField;
use App\Models\PayrollManagement\SalaryHead;
class SalaryRevisionController extends Controller
{
    public function index(Request $request)
    {
        $employees = User::where('status', 'active')->orderBy('name', 'asc')->whereNull('is_super_admin')->where('institute_id',session()->get('staff_institute_id'))->get();
        $params = array(
            'employees' => $employees
        );

        if ($request->ajax()) {

            $staff_id = $request->get('staff_id');
            $revision_status = $request->get('revision_status');
            $search_status = $revision_status;

            $data = StaffSalaryPattern::with('staff')->select('*')
                ->where('staff_salary_patterns.verification_status', $search_status)
                ->when($staff_id != '', function ($q) use ($staff_id) {
                    $q->where('staff_id', $staff_id);
                })->where('institute_id',session()->get('staff_institute_id'));

            $datatables = Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('checkbox', function ($row) {
                    $status = '<input type="checkbox" role="button" name="revision[]" class="revision_check" value="' . $row->id . '">';
                    return $status;
                })
                ->editColumn('status', function ($row) {
                    $status = '<a href="javascript:void(0);" class="badge badge-light-' . (($row->status == 'active') ? 'success' : 'danger') . '" tooltip="Click to ' . ucwords($row->status) . '" onclick="return nationalityChangeStatus(' . $row->id . ',\'' . ($row->status == 'active' ? 'inactive' : 'active') . '\')">' . ucfirst($row->status) . '</a>';
                    return $status;
                })
                ->editColumn('updated_at', function ($row) {
                    $created_at = commonDateFormat($row['created_at']);
                    return $created_at;
                })
                ->editColumn('effective_from', function ($row) {
                    $effective_from = commonDateFormat($row['effective_from']);
                    return $effective_from;
                })
                ->editColumn('view_btn', function ($row) {
                    return '<a href="' . route('salary.view', ['id' => $row->id]) . '"  class="btn btn-icon btn-active-info btn-light-info mx-1 w-30px h-30px" > 
                                    <i class="fa fa-eye"></i>
                                </a>';
                })
                ->editColumn('payout_month', function ($row) {
                    $payout_month = commonDateFormat($row['payout_month']);
                    return $payout_month;
                })

                ->rawColumns(['status', 'checkbox','view_btn']);
            return $datatables->make(true);
        }
        return view('pages.payroll_management.salary_revision.index', $params);
    }

    public function changeStatusModal(Request $request)
    {

        $revision = $request->revision;
        $status = $request->status;
        $revision_status = $request->revision_status;
        $title = ucfirst($status) . ' Remarks';

        $params = array(
            'revision' => $revision,
            'status' => $status,
            'revision_status' => $revision_status
        );

        $content = view('pages.payroll_management.salary_revision.remark_form', $params);
        return view('layouts.modal.dynamic_modal', compact('content', 'title'));
    }

    public function changeStatus(Request $request)
    {

        $status = $request->status;
        $remarks = $request->remarks;
        $revision_status = $request->revision_status;
        $revision = $request->revision;
        $revision = explode(',', $revision);
        $message = 'Error occured while changing status';

        if (isset($revision)) {
            foreach ($revision as $item) {

                $patter_info = StaffSalaryPattern::find($item);
                if ($patter_info) {
                    if ($status == 'approved') {
                        if ($revision_status != 'pending') {

                            $check_exist = StaffSalaryPattern::where('staff_id', $patter_info->staff_id)
                                ->where('payout_month', $patter_info->payout_month)
                                ->where('verification_status', '!=', 'rejected')
                                ->where('verification_status', '!=', 'rejected')
                                ->first();
                            // dd( $check_exist );
                            if ($check_exist) {
                                return array('error' => 1, 'message' => 'Cannot approve. Revision for payout month in list');
                            }
                        }
                        $patter_info->approved_on = date('Y-m-d H:i:s');
                        $patter_info->approved_remarks = $remarks;
                        $patter_info->verification_status = $status;
                        $patter_info->salary_approved_by = auth()->id();
                        $patter_info->rejected_on = null;
                        $patter_info->removed_remarks = null;
                        $patter_info->rejectedBy = null;

                        $message = 'Approved successfully';
                    } else if ($status == 'rejected') {
                        $patter_info->rejected_on = date('Y-m-d H:i:s');
                        $patter_info->removed_remarks = $remarks;
                        $patter_info->verification_status = $status;
                        $patter_info->rejectedBy = auth()->id();
                        $patter_info->approved_on = null;
                        $patter_info->approved_remarks = null;
                        $patter_info->salary_approved_by = null;
                        $message = 'Rejected successfully';
                    }
                    $patter_info->save();

                    //set is_current 
                    $max_info = DB::select('SELECT ssp.id, ssp.payout_month
                                        FROM staff_salary_patterns ssp
                                        WHERE ssp.staff_id = ' . $patter_info->staff_id . '
                                        AND ssp.payout_month = (
                                        SELECT MAX(payout_month)
                                        FROM staff_salary_patterns
                                        WHERE staff_id = ' . $patter_info->staff_id . ' and verification_status != \'rejected\' and deleted_at is null
                                        ) and ssp.deleted_at is null and verification_status != \'rejected\' ');

                    if (!empty($max_info)) {

                        $pattern_id = $max_info[0]->id ?? '';
                        if ($pattern_id) {
                            StaffSalaryPattern::where('staff_id', $patter_info->staff_id)->update(['is_current' => 'no']);
                            StaffSalaryPattern::where('id', $pattern_id)->update(['is_current' => 'yes']);
                        }
                    }
                }
            }
        }

        return array('error' => 0, 'message' => $message);
    }
     public function View(Request $request,$id)
    {
       
        $salary_info = StaffSalaryPattern::find($id);
        $staff_id = $salary_info->staff_id;
        $staff_info = User::find($staff_id);
        $salary_heads = SalaryHead::where('status', 'active')->get();
        $acYear = AcademicYear::find(academicYearId());
        $salary_fields = [];
        $payout_year = [];
        $nature_of_employment_id = '';
        if (isset($staff_info->appointment->nature_of_employment_id) && !empty($staff_info->appointment->nature_of_employment_id)) {
            $nature_of_employment_id = $staff_info->appointment->nature_of_employment_id;

            $earnings_data = SalaryField::where('nature_id', $nature_of_employment_id)
                ->where('salary_head_id', 1)
                ->orderBy('order_in_salary_slip')
                ->get();

            $deduction_data = SalaryField::where(function ($q) use ($nature_of_employment_id) {
                $q->where('nature_id', $nature_of_employment_id)
                    ->orWhere('entry_type', 'inbuilt_calculation');
            })
                ->where('salary_head_id', 2)
                ->orderBy('order_in_salary_slip')
                ->get();

            $start_year = '01-' . $acYear->from_month . '-' . $acYear->from_year;
            $end_year = '01-' . $acYear->to_month . '-' . $acYear->to_year;
            $start_Date = date('Y-m-d', strtotime($start_year));

            for ($i = 0; $i < 12; $i++) {
                $payout_year[] = date('Y-m-d', strtotime($start_Date . ' + ' . $i . ' months'));
            }
            $message = '';
        } else {
            $message = 'Empoyee Nature not mapped with this staff.Please assign in appointment details to add salary';
        }
        /**
         * CHECK SALARY IS ALREADY CREATED
         */
        $params = array(
            'nature_of_employment_id' => $nature_of_employment_id,
            'salary_heads' => $salary_heads,
            'salary_info' => $salary_info,
            'payout_year' => $payout_year,
            'message' => $message,
            'salary_fields' => $salary_fields,
            'earnings_data' => $earnings_data ?? [],
            'deduction_data' => $deduction_data ?? [],
            'staff_id' => $staff_id

        );
        if (!$salary_info) {
            return view('pages.payroll_management.salary_creation._salary_create', $params);
        } else {

            $all_salary_patterns = StaffSalaryPattern::where('staff_id', $staff_id)->orderBy('id', 'desc')
                ->where('verification_status', '!=', 'rejected')->get();
            $current_pattern = StaffSalaryPattern::where(['staff_id' => $staff_id, 'is_current' => 'yes'])->first();
            if (!$current_pattern) {
                $current_pattern = StaffSalaryPattern::where(['staff_id' => $staff_id, 'is_current' => 'no'])->orderBy('payout_month', 'desc')->first();
            }
            $staff_details = User::find($staff_id);
            $params['all_salary_patterns'] = $all_salary_patterns;
            $params['current_pattern'] = $current_pattern;
            $params['staff_details'] = $staff_details;

            return view('pages.payroll_management.salary_revision.view', $params);
        }
    }
}
