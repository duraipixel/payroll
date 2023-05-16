<?php

namespace App\Http\Controllers\Master;

use App\Exports\AppointmentOrderModelExport;
use App\Http\Controllers\Controller;
use App\Models\Master\AppointmentOrderModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use DataTables;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class AppointmentOrderModelController extends Controller
{
    public function index(Request $request)
    {
        $breadcrums = array(
            'title' => 'Appointment Order',
            'breadcrums' => array(
                array(
                    'link' => '', 'title' => 'Appointment Order'
                ),
            )
        );
        if($request->ajax())
        {
            $data = AppointmentOrderModel::select('*');
            $status = $request->get('status');
            $datatable_search = $request->datatable_search ?? '';
            $keywords = $datatable_search;
            
            $datatables =  Datatables::of($data)
            ->filter(function($query) use($status,$keywords) {
                if($keywords)
                {
                    $date = date('Y-m-d',strtotime($keywords));
                    return $query->where(function($q) use($keywords,$date){

                        $q->where('appointment_order_models.name','like',"%{$keywords}%")
                        ->orWhereDate('appointment_order_models.created_at',$date);
                    });
                }
            })
            ->addIndexColumn()
            ->editColumn('status', function ($row) {
                $status = '<a href="javascript:void(0);" class="badge badge-light-' . (($row->status == 'active') ? 'success' : 'danger') . '" tooltip="Click to ' . ucwords($row->status) . '" onclick="return appointmentOrderChangeStatus(' . $row->id . ',\'' . ($row->status == 'active' ? 'inactive' : 'active') . '\')">' . ucfirst($row->status) . '</a>';
                return $status;
            })
            ->editColumn('created_at', function ($row) {
                $created_at = Carbon::createFromFormat('Y-m-d H:i:s', $row['created_at'])->format('d-m-Y');
                return $created_at;
            })
              ->addColumn('action', function ($row) {
                $edit_btn = '<a href="'.route('appointment.orders.add', ['id' => $row->id]).'"  class="btn btn-icon btn-active-primary btn-light-primary mx-1 w-30px h-30px" > 
                                <i class="fa fa-edit"></i>
                            </a>';
                    $del_btn = '<a href="javascript:void(0);" onclick="deleteAppointmentOrder(' . $row->id . ')" class="btn btn-icon btn-active-danger btn-light-danger mx-1 w-30px h-30px" > 
                <i class="fa fa-trash"></i></a>';

                    return $edit_btn . $del_btn;
                })
                ->rawColumns(['action', 'status']);
            return $datatables->make(true);
        }
        return view('pages.masters.appointment_order_model.index',compact('breadcrums'));

    }

    public function save(Request $request)
    {

        $id = $request->id ?? '';
        $data = '';
        $validator      = Validator::make($request->all(), [
            'order_model' => 'required|string|unique:appointment_order_models,name,' . $id .',id,deleted_at,NULL',
        ]);
        
        if ($validator->passes()) {
            
            $ins['academic_id'] = academicYearId();
            $ins['name'] = $request->order_model;
            $ins['document'] = $request->document_data;
            $ins['status'] = $request->status == 1 ? 'active' : 'inactive';
            
            $data = AppointmentOrderModel::updateOrCreate(['id' => $id], $ins);
            $error = 0;
            $message = 'Added successfully';

        } else {

            $error = 1;
            $message = $validator->errors()->all();

        }
        return response()->json(['error' => $error, 'message' => $message, 'inserted_data' => $data]);

    }

    public function add_edit(Request $request, AppointmentOrderModel $id)
    {
        
        $info = [];
        $title = 'Add Appointment Order';
        $from = 'master';
        $breadcrums = array(
            'title' => 'Appointment Order',
            'breadcrums' => array(
                array(
                    'link' => route('appointment.orders'), 'title' => 'Appointment Order'
                ),
            )
        );
        if(isset($id->id) && !empty($id->id))
        {
            $info = $id;
            $title = 'Update Appointment Order';
        }
        
        return view('pages.masters.appointment_order_model.add_page',compact('info','title', 'from', 'breadcrums'));
        
    }

    public function changeStatus(Request $request)
    {
        $id             = $request->id;
        $status         = $request->status;
        $info           = AppointmentOrderModel::find($id);
        $info->status   = $status;
        $info->update();
        return response()->json(['message' => "You changed the Appointment Order status!", 'status' => 1]);
    }

    public function delete(Request $request)
    {
        $id         = $request->id;
        $info       = AppointmentOrderModel::find($id);
        $info->delete();
        
        return response()->json(['message'=>"Successfully deleted state!",'status'=>1]);
    }
    public function export()
    {
        return Excel::download(new AppointmentOrderModelExport,'appointment_order.xlsx');
    }
}
