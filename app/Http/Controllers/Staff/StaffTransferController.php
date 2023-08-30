<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Master\Institution;
use App\Models\Staff\StaffTransfer;
use App\Models\User;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class StaffTransferController extends Controller
{
    public function index(Request $request)
    {
        $users = StaffTransfer::with(['staff'])->get();
        if ($request->ajax()) {
            $from_institution_id = '';
            $staff_id = $request->staff_id ?? '';
            $search = '';
            $transfer_status = $request->transfer_status ?? '';
            $data = StaffTransfer::with(['staff', 'from', 'to'])
                ->when(isset($from_institution_id) && !empty($from_institution_id), function ($query) use ($from_institution_id) {
                    $query->where('institute_id', $from_institution_id);
                })
                ->when(!empty($transfer_status), function ($query) use ($transfer_status) {
                    $query->where('status', $transfer_status);
                })
                ->when(!empty($staff_id), function ($query) use ($staff_id) {
                    $query->where('staff_id', $staff_id);
                })
                ->when(!empty($search), function ($query) use ($search) {
                    $query->where('staff.name', 'like', "%{$search}%")
                        ->orWhere('staff.emp_code', 'like', "%{$search}%")
                        ->orWhere('staff.society_emp_code', 'like', "%{$search}%")
                        ->orWhere('staff.institute_emp_code', 'like', "%{$search}%")
                        ->orWhere('staff.first_name_tamil', 'like', "%{$search}%");
                });

            $datatables = Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('checkbox', function ($row) {
                    $status = '<input type="checkbox" role="button" name="transfer[]" class="transfer_check" value="' . $row->id . '">';
                    return $status;
                })
                ->editColumn('effective_from', function ($row) {
                    return commonDateFormat($row->effective_from);
                })
                ->editColumn('status', function ($row) {
                    $status = '<a href="javascript:void(0);" class="badge badge-light-' . (($row->status == 'active') ? 'success' : 'danger') . '" ">' . ucfirst($row->status) . '</a>';
                    return $status;
                })
                ->rawColumns(['status', 'checkbox']);
            return $datatables->make(true);
        }
        return view('pages.transfer.index', compact('users'));
    }

    public function add(Request $request)
    {

        $institutions = Institution::where('status', 'active')->get();
        return view('pages.transfer.add', compact('institutions'));
    }

    public function getInstitutionStaff(Request $request)
    {

        $from_institution_id = $request->from_institution_id;

        if ($from_institution_id && !empty($from_institution_id)) {
            if ($request->ajax()) {
                $search = $request->search ?? '';
                $data = User::with('personal')
                    ->where('institute_id', $from_institution_id)
                    ->where('users.status', 'active')
                    ->where('users.transfer_status', 'active')
                    ->when(!empty($search), function ($query) use ($search) {
                        $query->where('users.name', 'like', "%{$search}%")
                            ->orWhere('users.emp_code', 'like', "%{$search}%")
                            ->orWhere('users.society_emp_code', 'like', "%{$search}%")
                            ->orWhere('users.institute_emp_code', 'like', "%{$search}%")
                            ->orWhere('users.first_name_tamil', 'like', "%{$search}%");
                    });

                $datatables = Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('checkbox', function ($row) {
                        $status = '<input type="checkbox" role="button" name="transfer[]" class="transfer_check" value="' . $row->id . '">';
                        return $status;
                    })
                    ->editColumn('email', function ($row) {
                        return $row->personal?->email ?? 'n/a';
                    })
                    ->editColumn('phone_no', function ($row) {
                        return $row->personal?->phone_no ?? 'n/a';
                    })
                    ->editColumn('status', function ($row) {
                        $status = '<a href="javascript:void(0);" class="badge badge-light-' . (($row->status == 'active') ? 'success' : 'danger') . '" ">' . ucfirst($row->status) . '</a>';
                        return $status;
                    })
                    ->rawColumns(['status', 'checkbox']);
                return $datatables->make(true);
            }
        } else {
            return ['draw' => 0, 'recordsTotal' => '0', 'recordsFiltered' => 0, 'data' => []];
        }
    }

    public function doTransferStaff(Request $request)
    {

        $from_institution_id = $request->from_institution_id;
        $to_institution_id = $request->to_institution_id;
        $effective_from = $request->effective_from;
        $remarks = $request->remarks;
        $transfer = $request->transfer;

        if (isset($transfer) && !empty($transfer)) {
            foreach ($transfer as $staff_id) {

                $staff_info  = User::find($staff_id);
                $ins['academic_id'] = academicYearId();
                $ins['from_institution_id'] = $from_institution_id;
                $ins['to_institution_id'] = $to_institution_id;
                $ins['staff_id'] = $staff_info->id;
                $ins['remarks'] = $remarks;
                $ins['effective_from'] = date('Y-m-d', strtotime($effective_from));
                $ins['new_institution_code'] = getStaffInstitutionCode($to_institution_id);
                $ins['old_institution_code'] = $staff_info->institute_emp_code;
                $ins['status'] = 'pending';

                StaffTransfer::updateOrCreate(['staff_id' => $staff_info->id], $ins);
            }
        }

        return ['error' => 0, 'message' => 'Transfer added successfully. Pending approval'];
    }

    public function openTransferStatusModal(Request $request)
    {

        $transfer = $request->transfer;
        $status = $request->status;
        $transfer_status = $request->transfer_status;
        $title = ucfirst($status) . ' Remarks';

        $params = array(
            'transfer' => $transfer,
            'status' => $status,
            'transfer_status' => $transfer_status
        );

        $content = view('pages.transfer.remarks_form', $params);
        return view('layouts.modal.dynamic_modal', compact('content', 'title'));
    }

    public function changeStatus(Request $request)
    {

        $status = $request->status;
        $remarks = $request->remarks;
        $transfer_status = $request->transfer_status;
        $transfer = $request->transfer;
        $transfer = explode(',', $transfer);

        if (isset($transfer) && !empty($transfer)) {
            foreach ($transfer as $transfer_id) {

                $ins = [];
                if ($status == 'approved') {
                    $transfer_info = StaffTransfer::find($transfer_id);
                    $transfer_info->status = 'approved';
                    $transfer_info->reason = $remarks;
                    $transfer_info->save();
                    /** 
                     * change ins id to user
                     */

                    $user_info = User::find($transfer_info->staff_id);
                    $clonedUser = $user_info->replicate();

                   
                    $clonedUser->refer_user_id = $user_info->id;
                    $clonedUser->status = 'transferred';
                    $clonedUser->save();

                 
                    $user_info->institute_id = $transfer_info->to_institution_id;
                    $user_info->institute_emp_code = $transfer_info->new_institution_code;
                    $user_info->save();

                } else if ($status == 'rejected') {
                    $transfer_info = StaffTransfer::find($transfer_id);
                    $transfer_info->status = 'rejected';
                    $transfer_info->reason = $remarks;
                    $transfer_info->save();
                }
            }
            $message = 'Successfully changed';
        } else {

            $message = 'Error occured while changing status';
        }
        return array('error' => 0, 'message' => $message);
    }
}
