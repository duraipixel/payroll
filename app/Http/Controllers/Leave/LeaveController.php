<?php

namespace App\Http\Controllers\Leave;

use App\Http\Controllers\Controller;
use App\Models\AttendanceManagement\LeaveHead;
use App\Models\Leave\StaffLeave;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LeaveController extends Controller
{
    public function index(Request $request)
    {
        $breadcrums = array(
            'title' => 'Leave Management',
            'breadcrums' => array(
                array(
                    'link' => '', 'title' => 'Leave List'
                ),
            )
        );
        // if($request->ajax())
        // {
        //     $data = AppointmentOrderModel::select('*');
        //     $status = $request->get('status');
        //     $datatable_search = $request->datatable_search ?? '';
        //     $keywords = $datatable_search;
            
        //     $datatables =  Datatables::of($data)
        //     ->filter(function($query) use($status,$keywords) {
        //         if($keywords)
        //         {
        //             $date = date('Y-m-d',strtotime($keywords));
        //             return $query->where(function($q) use($keywords,$date){

        //                 $q->where('appointment_order_models.name','like',"%{$keywords}%")
        //                 ->orWhereDate('appointment_order_models.created_at',$date);
        //             });
        //         }
        //     })
        //     ->addIndexColumn()
        //     ->editColumn('status', function ($row) {
        //         $status = '<a href="javascript:void(0);" class="badge badge-light-' . (($row->status == 'active') ? 'success' : 'danger') . '" tooltip="Click to ' . ucwords($row->status) . '" onclick="return appointmentOrderChangeStatus(' . $row->id . ',\'' . ($row->status == 'active' ? 'inactive' : 'active') . '\')">' . ucfirst($row->status) . '</a>';
        //         return $status;
        //     })
        //     ->editColumn('created_at', function ($row) {
        //         $created_at = Carbon::createFromFormat('Y-m-d H:i:s', $row['created_at'])->format('d-m-Y');
        //         return $created_at;
        //     })
        //       ->addColumn('action', function ($row) {
        //         $edit_btn = '<a href="javascript:void(0);" onclick="getAppointmentOrderModal(' . $row->id . ')"  class="btn btn-icon btn-active-primary btn-light-primary mx-1 w-30px h-30px" > 
        //         <i class="fa fa-edit"></i>
        //     </a>';
        //             $del_btn = '<a href="javascript:void(0);" onclick="deleteAppointmentOrder(' . $row->id . ')" class="btn btn-icon btn-active-danger btn-light-danger mx-1 w-30px h-30px" > 
        //         <i class="fa fa-trash"></i></a>';

        //             return $edit_btn . $del_btn;
        //         })
        //         ->rawColumns(['action', 'status']);
        //     return $datatables->make(true);
        // }
        return view('pages.leave.request_leave.index',compact('breadcrums'));
    }

    public function addEditModal(Request $request)
    {
        $title = 'Add Leave Request';
        $leave_category = LeaveHead::where('status', 'active')->get();
        return view('pages.leave.request_leave.add_edit_form', compact('title', 'leave_category'));
    }

    public function saveLeaveRequest(Request $request)
    {      

        $id = $request->id ?? '';
        $data = '';
        $validator      = Validator::make($request->all(), [
            'leave_category_id' => 'required',
            'staff_id' => 'required',
            'requested_date' => 'required',
            'no_of_days' => 'required',
            'reason' => 'required'
        ]);
        
        if ($validator->passes()) {

            $req_dates = $request->requested_date;
            $req_dates = explode('-', $req_dates);

            $from_date = date('Y-m-d', strtotime(str_replace('/', '-', current($req_dates) )));
            $end_date = date('Y-m-d', strtotime(str_replace('/', '-', end($req_dates) )));
            dump( $from_date );
            $staff_info = User::with('appointment.work_place')->find($request->staff_id);
            dd( $staff_info->appointment->work_place->name );
            $ins['academic_id'] = academicYearId();
            $ins['staff_id'] = $request->staff_id;
            $ins['designation'] = $request->designation;
            $ins['place_of_work'] = $staff_info->appointment->work_place->name ?? null;
            $ins['salary'] = $request->salary ?? null;
            $ins['leave_category'] = '';
            $ins['leave_category_id'] = '';
            $ins['from_date'] = $from_date;
            $ins['to_date'] = $end_date;
            $ins['no_of_days'] = $no_of_days ?? 0;
            $ins['reason'] = $request->reason;
            $ins['address'] = $request->address ?? null;
            /** generate leave form and send */
            
            //document

            StaffLeave::updateOrCreate(['id' => $id], $ins);

        }  else {
            $error = 1;
            $message = $validator->errors()->all();
        }
        return response()->json(['error' => $error, 'message' => $message]);
    }
}
