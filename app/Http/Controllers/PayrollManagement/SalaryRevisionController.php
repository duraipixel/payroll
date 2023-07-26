<?php

namespace App\Http\Controllers\PayrollManagement;

use App\Http\Controllers\Controller;
use App\Models\PayrollManagement\StaffSalaryPattern;
use App\Models\User;
use DataTables;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SalaryRevisionController extends Controller
{
    public function index(Request $request)
    {
        $employees = User::where('status', 'active')->orderBy('name', 'asc')->whereNull('is_super_admin')->get();
        $params = array(
            'employees' => $employees
        );

        if ($request->ajax()) {
            
            $staff_id = $request->get('staff_id');
            $revision_status = $request->get('revision_status');
            $search_status = $revision_status;

            $data = StaffSalaryPattern::with('staff')->select('*')
                ->where('staff_salary_patterns.verification_status', $search_status)
                ->when($staff_id != '', function($q) use($staff_id){
                    $q->where('staff_id', $staff_id);
                });

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
                ->editColumn('payout_month', function ($row) {
                    $payout_month = commonDateFormat($row['payout_month']);
                    return $payout_month;
                })

                ->rawColumns(['status', 'checkbox']);
            return $datatables->make(true);
        }
        return view('pages.payroll_management.salary_revision.index', $params);
    }

    public function changeStatusModal(Request $request) {

        $revision = $request->revision;
        $status = $request->status;
        $revision_status = $request->revision_status;
        $title = ucfirst($status).' Remarks';
         
        $params = array(
            'revision' => $revision,
            'status' => $status,
            'revision_status' => $revision_status
        );

        $content = view('pages.payroll_management.salary_revision.remark_form', $params);
        return view('layouts.modal.dynamic_modal', compact('content', 'title'));

    }

    public function changeStatus(Request $request) {

        $status = $request->status;
        $remarks = $request->remarks;
        $revision_status = $request->revision_status;
        $revision = $request->revision;
        $revision = explode(',', $revision);
        $message = 'Error occured while changing status';

        if( isset( $revision ) ) {
            foreach ($revision as $item) {
                
                $patter_info = StaffSalaryPattern::find($item);
                if( $patter_info ) {
                    if( $status == 'approved') {
                        if( $revision_status != 'pending') {

                            $check_exist= StaffSalaryPattern::where('staff_id', $patter_info->staff_id)
                                            ->where('payout_month', $patter_info->payout_month)
                                            ->where('verification_status', '!=', 'rejected')
                                            ->where('verification_status', '!=', 'rejected')
                                            ->first();
                            // dd( $check_exist );
                            if( $check_exist ) {
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

                    } else if( $status == 'rejected') {
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
                }
            }
        }

        return array('error' => 0, 'message' => $message);
    }
}
