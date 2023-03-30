<?php

namespace App\Http\Controllers\Master;

use App\Exports\DivisionExport;
use App\Http\Controllers\Controller;
use App\Models\Master\Division;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use DataTables;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class DivisionController extends Controller
{
    public function index(Request $request)
    {
        $breadcrums = array(
            'title' => 'Divisions',
            'breadcrums' => array(
                array(
                    'link' => '', 'title' => 'Divisions'
                ),
            )
        );
        if($request->ajax())
        {
            $data = Division::orderBy('id','desc');
            $status = $request->get('status');
            $datatable_search = $request->datatable_search ?? '';
            $keywords = $datatable_search;
            $datatables =  Datatables::of($data)
            ->filter(function($query) use($status,$keywords) {
                if($status)
                {
                    return $query->where('divisions.status','=',"$status");
                }
                if($keywords)
                {
                    $date = date('Y-m-d',strtotime($keywords));
                    return $query->where(function($q) use($keywords,$date){

                        $q->where('divisions.name','like',"%{$keywords}%")
                        ->orWhereDate('divisions.created_at',$date);
                    });
                }
            })
            ->addIndexColumn()
            ->editColumn('status', function ($row) {
                $status = '<a href="javascript:void(0);" class="badge badge-light-' . (($row->status == 'active') ? 'success' : 'danger') . '" tooltip="Click to ' . ucwords($row->status) . '" onclick="return divisionsChangeStatus(' . $row->id . ',\'' . ($row->status == 'active' ? 'inactive' : 'active') . '\')">' . ucfirst($row->status) . '</a>';
                return $status;
            })
            ->editColumn('created_at', function ($row) {
                $created_at = Carbon::createFromFormat('Y-m-d H:i:s', $row['created_at'])->format('d-m-Y');
                return $created_at;
            })
              ->addColumn('action', function ($row) {
                $edit_btn = '<a href="javascript:void(0);" onclick="getDivisionsModal(' . $row->id . ')"  class="btn btn-icon btn-active-primary btn-light-primary mx-1 w-30px h-30px" > 
                <i class="fa fa-edit"></i>
            </a>';
                    $del_btn = '<a href="javascript:void(0);" onclick="deleteDivisions(' . $row->id . ')" class="btn btn-icon btn-active-danger btn-light-danger mx-1 w-30px h-30px" > 
                <i class="fa fa-trash"></i></a>';

                    return $edit_btn . $del_btn;
                })
                ->rawColumns(['action', 'status']);
            return $datatables->make(true);
        }
        return view('pages.masters.divisions.index',compact('breadcrums'));
    }
    public function add_edit(Request $request)
    {
        $id = $request->id;
        $info = [];
        $title = 'Add Division';
        if(isset($id) && !empty($id))
        {
            $info = Division::find($id);
            $title = 'Update Division';
        }

         $content = view('pages.masters.divisions.add_edit_form',compact('info','title'));
         return view('layouts.modal.dynamic_modal', compact('content', 'title'));
    }
    public function save(Request $request)
    {
        $id = $request->id ?? '';
        $data = '';
        $validator      = Validator::make($request->all(), [
            'division_name' => 'required|string|unique:divisions,name,' . $id,
        ]);
        
        if ($validator->passes()) {
            $ins['academic_id'] = academicYearId();
            $ins['name'] = $request->division_name;
            $ins['status'] = 'active';
            $data = Division::updateOrCreate(['id' => $id], $ins);
            $error = 0;
            $message = 'Added successfully';

        } else {
            $error = 1;
            $message = $validator->errors()->all();
        }
        return response()->json(['error' => $error, 'message' => $message, 'inserted_data' => $data]);
    }
    public function changeStatus(Request $request)
    {
        $id             = $request->id;
        $status         = $request->status;
        $info           = Division::find($id);
        $info->status   = $status;
        $info->update();
        return response()->json(['message' => "You changed the division status!", 'status' => 1]);
    }

    public function delete(Request $request)
    {
        $id         = $request->id;
        $info       = Division::find($id);
        $info->delete();
        
        return response()->json(['message'=>"Successfully deleted state!",'status'=>1]);
    }
    public function export()
    {
        return Excel::download(new DivisionExport,'division.xlsx');
    }
}
