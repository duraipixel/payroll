<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Test;
use Illuminate\Support\Facades\Validator;
use DataTables;
use Carbon\Carbon;

class TestOne extends Controller
{
    public function index(Request $request)
    {
        $breadcrums = array(
            'title' => 'TestOne',
            'breadcrums' => array(
                array(
                    'link' => '', 'title' => 'TestOne'
                ),
            )
        );
        if($request->ajax())
        {
            $data = TestOne::select('*');
            $status = $request->get('status');
            $datatable_search = $request->datatable_search ?? '';
            $keywords = $datatable_search;
            
            $datatables =  Datatables::of($data)
            ->filter(function($query) use($status,$keywords) {
                if($keywords)
                {
                    $date = date('Y-m-d',strtotime($keywords));
                    return $query->where(function($q) use($keywords,$date){
                        $q->where('test_ones.name','like',"%{$keywords}%")->orWhereDate('test_ones.created_at','like',"%{$date}%");
                    });
                }
            })
            ->addIndexColumn()
            ->editColumn('status', function ($row) {
                $status = '<a href="javascript:void(0);" class="badge badge-light-' . (($row->status == 'active') ? 'success' : 'danger') . '" tooltip="Click to ' . ucwords($row->status) . '" onclick="return TestOneChangeStatus(' . $row->id . ',\'' . ($row->status == 'active' ? 'inactive' : 'active') . '\')">' . ucfirst($row->status) . '</a>';
                return $status;
            })
            ->editColumn('created_at', function ($row) {
                $created_at = Carbon::createFromFormat('Y-m-d H:i:s', $row['created_at'])->format('d-m-Y');
                return $created_at;
            })
              ->addColumn('action', function ($row) {
                $edit_btn = '<a href="javascript:void(0);" onclick="addTestOneModal(' . $row->id . ')"  class="btn btn-icon btn-active-primary btn-light-primary mx-1 w-30px h-30px" > 
                <i class="fa fa-edit"></i>
            </a>';
                    $del_btn = '<a href="javascript:void(0);" onclick="deleteTestOne(' . $row->id . ')" class="btn btn-icon btn-active-danger btn-light-danger mx-1 w-30px h-30px" > 
                <i class="fa fa-trash"></i></a>';

                    return $edit_btn . $del_btn;
                })
                ->rawColumns(['action', 'status']);
            return $datatables->make(true);
        }
        return view('pages.testone.index',compact('breadcrums'));
    }

    public function save(Request $request)
    {
        $id = $request->id ?? '';
        $data = '';
        $validator      = Validator::make($request->all(), ['name' => 'required|string']);
        
        if ($validator->passes()) {

            //$ins['academic_id'] = academicYearId();
            $ins['name'] = $request->name;$ins['status'] = $request->status ? 'active' : 'inactive';$ins['addedBy'] = auth()->user()->id;
            
            $data = TestOne::updateOrCreate(['id' => $id], $ins);
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
        $title = 'Add TestOne';
        if(isset($id) && !empty($id))
        {
            $info = TestOne::find($id);
            $title = 'Update TestOne';
        }
        return view('{{ view_add_form }}', compact('info', 'title'));
    }

    public function changeStatus(Request $request)
    {
        $id             = $request->id;
        $status         = $request->status;
        $info           = TestOne::find($id);
        $info->status   = $status;
        $info->update();
        return response()->json(['message' => "You changed the status!", 'status' => 1]);
    }

    public function delete(Request $request)
    {
        $id         = $request->id;
        $info       = TestOne::find($id);
        $info->delete();
        
        return response()->json(['message'=>"Successfully deleted!",'status'=>1]);
    }
    
}
