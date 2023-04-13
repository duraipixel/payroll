<?php

namespace App\Http\Controllers\AttendanceManagement;

use App\Exports\HolidayExport;
use App\Http\Controllers\Controller;
use App\Models\AttendanceManagement\Holiday;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use DataTables;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class HolidayController extends Controller
{
    public function index(Request $request)
    {
        $breadcrums = array(
            'title' => 'Holiday',
            'breadcrums' => array(
                array(
                    'link' => '', 'title' => 'Holiday'
                ),
            )
        );
        if($request->ajax())
        {
            $data = Holiday::select('*');
            $status = $request->get('status');
            $datatable_search = $request->datatable_search ?? '';
            $keywords = $datatable_search;
            
            $datatables =  Datatables::of($data)
            ->filter(function($query) use($status,$keywords) {
                if($keywords)
                {
                    $date = date('Y-m-d',strtotime($keywords));
                    return $query->where(function($q) use($keywords,$date){

                        $q->where('holidays.title','like',"%{$keywords}%")
                        ->orWhere('holidays.day','like',"%{$keywords}%")
                        ->orWhere('holidays.academic_year','like',"%{$keywords}%")
                        ->orWhereDate('holidays.created_at',$date);
                    });
                }
            })
            ->addIndexColumn()
            ->editColumn('status', function ($row) {
                $status = '<a href="javascript:void(0);" class="badge badge-light-' . (($row->status == 'active') ? 'success' : 'danger') . '" tooltip="Click to ' . ucwords($row->status) . '" onclick="return holidayChangeStatus(' . $row->id . ',\'' . ($row->status == 'active' ? 'inactive' : 'active') . '\')">' . ucfirst($row->status) . '</a>';
                return $status;
            })
            ->editColumn('created_at', function ($row) {
                $created_at = Carbon::createFromFormat('Y-m-d H:i:s', $row['created_at'])->format('d-m-Y');
                return $created_at;
            })
              ->addColumn('action', function ($row) {
                $edit_btn = '<a href="javascript:void(0);" onclick="getHolidayModal(' . $row->id . ')"  class="btn btn-icon btn-active-primary btn-light-primary mx-1 w-30px h-30px" > 
                <i class="fa fa-edit"></i>
            </a>';
                    $del_btn = '<a href="javascript:void(0);" onclick="deleteHoliday(' . $row->id . ')" class="btn btn-icon btn-active-danger btn-light-danger mx-1 w-30px h-30px" > 
                <i class="fa fa-trash"></i></a>';

                    return $edit_btn . $del_btn;
                })
                ->rawColumns(['action', 'status']);
            return $datatables->make(true);
        }
        return view('pages.attendance_management.holiday.index',compact('breadcrums'));
    }
    public function save(Request $request)
    {
        $id = $request->id ?? '';
        $data = '';
        $validator      = Validator::make($request->all(), [
            'title' => 'required|string|unique:holidays,title,' . $id .',id,deleted_at,NULL',
        ]);
        
        if ($validator->passes()) {

            $ins['academic_id']     = academicYearId();
            $ins['title']           = $request->title;
            $ins['academic_year']   = $request->academic_year;
            $ins['date']            = $request->date;
            $ins['day']             = $request->day;

            if($request->is_open_to_all)
            {
                $ins['is_open_to_all'] = 'yes';
            }
            else{
                $ins['is_open_to_all'] = 'no';
            }

            if($request->status)
            {
                $ins['status'] = 'active';
            }
            else{
                $ins['status'] = 'inactive';
            }
            
            $data = Holiday::updateOrCreate(['id' => $id], $ins);
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
        $years = [];
        $days = ["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday"];
        $title = 'Add Holiday';
        for($yr=date("Y")-5; $yr<=date("Y"); $yr++){
            $years[] = $yr;
        }
        $years = array_reverse($years);
        if(isset($id) && !empty($id))
        {
            $info = Holiday::find($id);
            $title = 'Update Holiday';
        }

         $content = view('pages.attendance_management.holiday.add_edit_form',compact('info','title','years','days'));
         return view('layouts.modal.dynamic_modal', compact('content', 'title'));
    }
    public function changeStatus(Request $request)
    {
        $id             = $request->id;
        $status         = $request->status;
        $info           = Holiday::find($id);
        $info->status   = $status;
        $info->update();
        return response()->json(['message' => "You changed the Holiday status!", 'status' => 1]);
    }

    public function delete(Request $request)
    {
        $id         = $request->id;
        $info       = Holiday::find($id);
        $info->delete();
        
        return response()->json(['message'=>"Successfully deleted state!",'status'=>1]);
    }
    public function export()
    {
        return Excel::download(new HolidayExport,'Holiday.xlsx');
    }
}
