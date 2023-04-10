<?php

namespace App\Http\Controllers;

use App\Models\Audit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use DataTables;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
class LogController extends Controller
{
    public function index(Request $request)
    {
        $breadcrums = array(
            'title' => 'Logs',
            'breadcrums' => array(
                array(
                    'link' => '', 'title' => 'Logs'
                ),
            )
        );
        if($request->ajax())
        {
            $data = Audit::select('audits.*','users.name')
            ->leftJoin('users','users.id','=','audits.user_id');
            $status = $request->get('status');
            $datatable_search = $request->datatable_search ?? '';
            $keywords = $datatable_search;
            
            $datatables =  Datatables::of($data)
            ->filter(function($query) use($status,$keywords) {
                if($keywords)
                {
                    $date = date('Y-m-d',strtotime($keywords));
                    return $query->where(function($q) use($keywords,$date){

                        $q->where('audits.ip_address','like',"%{$keywords}%")
                        ->orWhere('audits.event','like',"%{$keywords}%")
                        ->orWhere('users.name','like',"%{$keywords}%")
                        ->orWhere('users.email','like',"%{$keywords}%")
                        ->orWhereDate('audits.created_at',$date);
                    });
                }
            })
            ->addIndexColumn()
            ->editColumn('updated_at', function ($row) {
                $created_at = Carbon::createFromFormat('Y-m-d H:i:s', $row['updated_at'])->format('d-m-Y');
                return $created_at;
            })
            ->editColumn('created_at', function ($row) {
                $created_at = Carbon::createFromFormat('Y-m-d H:i:s', $row['created_at'])->format('d-m-Y');
                return $created_at;
            })
              ->addColumn('action', function ($row) {
                $view_btn = '<a href="javascript:void(0);" onclick="getLogsView(' . $row->id . ')"  class="btn btn-icon btn-active-primary btn-light-primary mx-1 w-30px h-30px" > 
                <i class="fa fa-eye"></i>
            </a>';

                    return $view_btn;
                })
                ->rawColumns(['action']);
            return $datatables->make(true);
        }
       return view('pages.logs.index',compact('breadcrums'));
    }
    public function view(Request $request)
    {
        $id = $request->id;
        $info = [];
        $title = "View Log Details";
        if(isset($id) && !empty($id))
        {
            $info = Audit::find($id);
        }
        $content = view('pages.logs.add_edit_form',compact('info','title'));
        return view('layouts.modal.dynamic_modal', compact('content', 'title'));
    }
}
