<?php

namespace App\Http\Controllers\Leave;

use App\Http\Controllers\Controller;
use App\Models\AttendanceManagement\LeaveHead;
use App\Models\Leave\StaffLeave;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DataTables;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

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
        if ($request->ajax()) {

            $data = StaffLeave::select('staff_leaves.*', 'users.name as staff_name')->with(['staff_info'])
                                ->join('users', 'users.id', '=', 'staff_leaves.staff_id');
            $status = $request->get('status');
            $keywords = $request->datatable_search ?? '';

            $datatables =  Datatables::of($data)
                ->filter(function ($query) use ($status, $keywords) {
                    if ($keywords) {
                        // $date = date('Y-m-d', strtotime($keywords));
                        return $query->where(function ($q) use ($keywords) {
                            $q->where('staff_leaves.application_no', 'like', "%{$keywords}%")
                                ->orWhere('users.name', 'like', "%{$keywords}%");
                                // ->orWhereDate('staff_leaves.created_at', $date);
                        });
                    }
                })
                ->addIndexColumn()
                ->editColumn('status', function ($row) {
                    $status = '<a href="javascript:void(0);" class="badge badge-light-' . (($row->status == 'active') ? 'success' : 'danger') . '" )">' . ucfirst($row->status) . '</a>';
                    return $status;
                })
               
                ->editColumn('created_at', function ($row) {
                    $created_at = Carbon::createFromFormat('Y-m-d H:i:s', $row['created_at'])->format('d-m-Y');
                    return $created_at;
                })
                ->addColumn('action', function ($row) {
                    $url = Storage::url($row->document);
                    $approve_btn = '';
                    if( isset($row->approved_document ) && !empty( $row->approved_document ) ) {

                        $approved_doc = Storage::url($row->approved_document);
                        $approve_btn = '<a href="' . asset('public' . $approved_doc) . '" tooltip="Approved Document" target="_blank"  class="btn btn-icon btn-active-success btn-light-success mx-1 w-30px h-30px" > 
                                <i class="fa fa-download"></i>
                            </a>';
                    }
                    
                    if( $row->status == 'pending') {

                        $approve_btn = '<a href="javascript:void(0);" onclick="approveLeave(' . $row->id . ')" class="btn btn-icon btn-active-success btn-light-success mx-1 w-30px h-30px" > 
                                            <i class="fa fa-check"></i></a>';
                    }
                    $edit_btn = '<a href="' . asset('public' . $url) . '" target="_blank" tooltip="Leave form"  class="btn btn-icon btn-active-primary btn-light-primary mx-1 w-30px h-30px" > 
                                <i class="fa fa-download"></i>
                            </a>';
                    $del_btn = '<a href="javascript:void(0);" onclick="deleteAppointmentOrder(' . $row->id . ')" class="btn btn-icon btn-active-danger btn-light-danger mx-1 w-30px h-30px" > 
                                <i class="fa fa-trash"></i></a>';

                    return $edit_btn . $approve_btn . $del_btn;
                })
                ->rawColumns(['action', 'status', 'created_at', 'name']);
            return $datatables->make(true);
            
        }
        return view('pages.leave.request_leave.index', compact('breadcrums'));
    }

    public function addEditModal(Request $request)
    {
        $title = 'Add Leave Request';
        $id = $request->id;
        $info = '';
        if ($id) {
            $title = 'Approve Leave Request';
            $info = StaffLeave::find($id);
        }
        $leave_category = LeaveHead::where('status', 'active')->get();
        return view('pages.leave.request_leave.add_edit_form', compact('title', 'leave_category', 'info'));
    }

    public function saveLeaveRequest(Request $request)
    {

        $id = $request->id ?? '';
        $validate_array = [
            'leave_category_id' => 'required',
            'staff_id' => 'required',
            'requested_date' => 'required',
            'no_of_days' => 'required',
            'reason' => 'required',
        ];

        if (isset($id) && !empty($id)) {
            [
                'leave_category_id' => 'required',
                'staff_id' => 'required',
                'requested_date' => 'required',
                'no_of_days' => 'required',
                'reason' => 'required',
                'application_file' => 'file|required',
                'leave_granted' => 'required',
                'no_of_days_granted' => 'required'
            ];
        }

        $validator      = Validator::make($request->all(), $validate_array);

        if ($validator->passes()) {

            $req_dates = $request->requested_date;
            $req_dates = explode('-', $req_dates);

            $from_date = date('Y-m-d', strtotime(str_replace('/', '-', current($req_dates))));
            $end_date = date('Y-m-d', strtotime(str_replace('/', '-', end($req_dates))));

            /**
             * Check already request to that date
             */
            $check = StaffLeave::where('staff_id', $request->staff_id)
                ->where('from_date', $from_date)
                ->when($id != '', function ($query) use ($id) {
                    $query->where('id', '!=', $id);
                })->first();

            if ($check) {
                $error = 1;
                $message = 'Leave Request already submit for this date';
            } else {

                $staff_info = User::with('appointment.work_place')->find($request->staff_id);
                $leave_category_info = LeaveHead::find($request->leave_category_id);

                if (isset($id) && !empty($id)) {

                    $leave_info = StaffLeave::find($id);
                    if ($request->hasFile('application_file')) {

                        $files = $request->file('application_file');
                        $imageName = uniqid() . Str::replace(' ', "-", $files->getClientOriginalName());
        
                        $directory = 'leave/' . $leave_info->application_no;
                        $filename  = $directory . '/' . $imageName;
        
                        Storage::disk('public')->put($filename, File::get($files));
                        $ins['approved_document'] = 'public/'.$filename;
                    } else {
                        $error = 1;
                        $message = ['Application document upload is required'];
                        return response()->json(['error' => $error, 'message' => $message]);
                    }
                    $ins['is_granted'] = $request->leave_granted;
                    $ins['granted_days'] = $request->no_of_days_granted;
                    $ins['remarks']  = $request->remarks;
                    $ins['granted_designation']  = '';
                    $ins['granted_by']  = auth()->user()->id;
                    $ins['granted_start_date']  = $leave_info->from_date;
                    $ins['granted_end_date']  = $leave_info->to_date;

                } else {

                    $ins['academic_id'] = academicYearId();
                    $ins['application_no'] = leaveApplicationNo($request->staff_id, $leave_category_info->name);
                    $ins['staff_id'] = $request->staff_id;
                    $ins['designation'] = $request->designation;
                    $ins['place_of_work'] = $staff_info->appointment->work_place->name ?? null;
                    $ins['salary'] = $request->salary ?? null;
                    $ins['from_date'] = $from_date;
                    $ins['to_date'] = $end_date;
                    $ins['no_of_days'] = $request->no_of_days ?? 0;
                    $ins['reason'] = $request->reason;

                }
                $ins['leave_category'] = $leave_category_info->name;
                $ins['leave_category_id'] = $leave_category_info->id;

                $ins['address'] = $request->address ?? null;
                $ins['addedBy'] = auth()->user()->id;
                $ins['reporting_id'] = $staff_info->reporting_manager_id ?? null;

                if ($request->leave_granted) {
                    if ($request->leave_granted == 'yes') {
                        $ins['status'] = 'approved';
                    } else {
                        $ins['status'] = 'rejected';
                    }
                } else {
                    $ins['status'] = 'pending';
                }
                /** generate leave form and send */
                $leave_info = StaffLeave::updateOrCreate(['id' => $id], $ins);
                generateLeaveForm($leave_info->id);

                $error = 0;
                $message = 'Leave Request submit successfully';
            }
        } else {
            $error = 1;
            $message = $validator->errors()->all();
        }
        return response()->json(['error' => $error, 'message' => $message]);
    }

    
}
