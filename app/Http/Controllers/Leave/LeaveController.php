<?php

namespace App\Http\Controllers\Leave;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LeaveController extends Controller
{
    public function FunctionName(Request $request)
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
        return view('pages.masters.appointment_order_model.index',compact('breadcrums'));
    }
}
