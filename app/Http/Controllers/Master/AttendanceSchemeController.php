<?php

namespace App\Http\Controllers\Master;

use App\Exports\AttendanceSchemeExport;
use App\Http\Controllers\Controller;
use App\Models\Master\AttendanceScheme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use DataTables;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class AttendanceSchemeController extends Controller
{
    public function index(Request $request)
    {
        $breadcrums = array(
            'title' => 'Attendance Scheme',
            'breadcrums' => array(
                array(
                    'link' => '', 'title' => 'Attendance Scheme'
                ),
            )
        );
        if ($request->ajax()) {
            $data = AttendanceScheme::select('*');
            $status = $request->get('status');
            $datatable_search = $request->datatable_search ?? '';
            $keywords = $datatable_search;

            $datatables =  Datatables::of($data)
                ->filter(function ($query) use ($status, $keywords) {
                    if ($keywords) {
                        $date = date('Y-m-d', strtotime($keywords));
                        return $query->where(function ($q) use ($keywords, $date) {

                            $q->where('attendance_schemes.name', 'like', "%{$keywords}%")
                                ->orWhereDate('attendance_schemes.created_at', $date);
                        });
                    }
                })
                ->addIndexColumn()
                ->editColumn('status', function ($row) {
                    $status = '<a href="javascript:void(0);" class="badge badge-light-' . (($row->status == 'active') ? 'success' : 'danger') . '" tooltip="Click to ' . ucwords($row->status) . '" onclick="return attendanceSchemeChangeStatus(' . $row->id . ',\'' . ($row->status == 'active' ? 'inactive' : 'active') . '\')">' . ucfirst($row->status) . '</a>';
                    return $status;
                })
                ->addColumn('timings', function ($row) {
                    
                    $timings = Carbon::parse($row->start_time)->format('H:i A').' - '.Carbon::parse($row->end_time)->format('H:i A');
                    return $timings;
                })
                ->addColumn('action', function ($row) {
                    $route_name = request()->route()->getName();
                    $edit_btn = '';
                    $del_btn = '';
                    if (access()->buttonAccess($route_name, 'add_edit')) {
                        $edit_btn = '<a href="' . route('appointment.orders.add', ['id' => $row->id]) . '" class="btn btn-icon btn-active-primary btn-light-primary mx-1 w-30px h-30px" > 
                                    <i class="fa fa-edit"></i>
                                </a>';
                    }
                    if (access()->buttonAccess($route_name, 'delete')) {
                        $del_btn = '<a href="javascript:void(0);" onclick="deleteAttendanceScheme(' . $row->id . ')" class="btn btn-icon btn-active-danger btn-light-danger mx-1 w-30px h-30px" > 
                    <i class="fa fa-trash"></i></a>';
                    }
                    return $edit_btn . $del_btn;
                })
                ->rawColumns(['action', 'status', 'timings']);
            return $datatables->make(true);
        }
        return view('pages.masters.scheme.index', compact('breadcrums'));
    }

    public function save(Request $request)
    {
        $id = $request->id ?? '';
        $data = '';
        $validator      = Validator::make($request->all(), [
            'scheme_name' => 'required|string|unique:attendance_schemes,name,' . $id . ',id,deleted_at,NULL',
        ]);

        if ($validator->passes()) {

            $ins['academic_id'] = academicYearId();
            $ins['name'] = $request->scheme_name;
            $ins['scheme_code'] = $request->scheme_code;
            $ins['start_time'] = $request->start_time;
            $ins['end_time'] = $request->end_time;
            $ins['totol_hours'] = $request->totol_hours;
            $ins['late_cutoff_time'] = $request->late_cutoff_time ? '00:' . $request->late_cutoff_time : null;
            $ins['permission_cutoff_time'] = $request->permission_cutoff_time ? '00:' . $request->permission_cutoff_time : null;
            $ins['status'] = $request->status;
            $data = AttendanceScheme::updateOrCreate(['id' => $id], $ins);
            $error = 0;
            $message = 'Added successfully';
        } else {
            $error = 1;
            $message = $validator->errors()->all();
        }
        return response()->json(['error' => $error, 'message' => $message, 'inserted_data' => $data]);
    }

    public function add_edit(Request $request)
    {

        $id = $request->id;
        $info = [];
        $title = 'Add Attendance Scheme';
        $from = 'master';

        $breadcrums = array(
            'title' => 'Attendance Schemes',
            'breadcrums' => array(
                array(
                    'link' => route('scheme'), 'title' => 'Attendance Schemes'
                ),
            )
        );

        if (isset($id) && !empty($id)) {
            $info = AttendanceScheme::find($id);
            $title = 'Update Attendance Scheme';
        }

        return view('pages.masters.scheme.add_page', compact('info', 'title', 'from', 'breadcrums'));
    }

    public function changeStatus(Request $request)
    {

        $id             = $request->id;
        $status         = $request->status;
        $info           = AttendanceScheme::find($id);
        $info->status   = $status;
        $info->update();
        return response()->json(['message' => "You changed the Attendance Scheme status!", 'status' => 1]);
    }

    public function delete(Request $request)
    {

        $id         = $request->id;
        $info       = AttendanceScheme::find($id);
        $info->delete();

        return response()->json(['message' => "Successfully deleted state!", 'status' => 1]);
    }

    public function export()
    {
        return Excel::download(new AttendanceSchemeExport, 'AttendanceScheme.xlsx');
    }
}
