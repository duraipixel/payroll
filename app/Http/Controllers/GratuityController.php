<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Gratuity;
use App\Models\User;
use App\Repositories\GratuityRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use DataTables;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class GratuityController extends Controller
{

    public $gratuityRepository;

    public function __construct(GratuityRepository $gratuityRepository)
    {
        $this->gratuityRepository = $gratuityRepository;
    }

    public function index( Request $request ) {
        $page_type = $request->type;
        $title = ucwords(str_replace('_', ' ', $page_type));
        $page_title = 'Assessing of Gratuity For '.$title.' Staff';
        $breadcrums = array(
            'title' => ucwords(str_replace('_', ' ', $page_type)),
            'breadcrums' => array(
                array(
                    'link' => '', 'title' => ucwords(str_replace('_', ' ', $page_type))
                ),
            )
        );

        if ($request->ajax()) {
            $datatable_search = $request->datatable_search ?? '';
            $keywords = $datatable_search;

            $data = Gratuity::with(['staff'])
                ->when(!empty($datatable_search), function ($query) use ($datatable_search) {
                    $date = date('Y-m-d', strtotime($datatable_search));
                    return $query->where(function ($q) use ($datatable_search, $date) {

                        $q->whereHas('staff', function($jq) use($datatable_search){
                                $jq->where('name', 'like', "%{$datatable_search}%")
                                ->orWhere('institute_emp_code', 'like', "%{$datatable_search}%");
                            })
                            ->orWhere('reason', 'like', "%{$datatable_search}%")
                            ->orWhereDate('last_working_date', $date);
                    });
                })->where('types', $page_type);

            $datatables =  Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('status', function ($row) {
                    $status = '<a href="javascript:void(0);" class="badge badge-light-' . (($row->status == 'active') ? 'success' : 'danger') . '" tooltip="Click to ' . ucwords($row->status) . '" onclick="return carreerChangeStatus(' . $row->id . ',\'' . ($row->status == 'active' ? 'inactive' : 'active') . '\')">' . ucfirst($row->status) . '</a>';
                    return $status;
                })
                ->editColumn('created_at', function ($row) {
                    $created_at = Carbon::createFromFormat('Y-m-d H:i:s', $row['created_at'])->format('d-m-Y');
                    return $created_at;
                })
                ->addColumn('action', function ($row) {
                    $route_name = request()->route()->getName();
                    $edit_btn = $del_btn = '';
                    if (access()->buttonAccess($route_name, 'add_edit')) {
                        $edit_btn = '<a href="javascript:void(0);" onclick="getAddModal(' . $row->id . ')"  class="btn btn-icon btn-active-primary btn-light-primary mx-1 w-30px h-30px" > 
                    <i class="fa fa-edit"></i>
                    </a>';
                    }
                    if (access()->buttonAccess($route_name, 'delete')) {
                        $del_btn = '<a href="javascript:void(0);" onclick="deleteCareer(' . $row->id . ')" class="btn btn-icon btn-active-danger btn-light-danger mx-1 w-30px h-30px" > 
                    <i class="fa fa-trash"></i></a>';
                    }
                    return $edit_btn . $del_btn;
                })
                ->rawColumns(['action', 'status']);
            return $datatables->make(true);
        }

        return view('pages.gratuity.index', compact('breadcrums', 'title', 'page_type', 'page_title'));

    }

    public function addEdit(Request $request) {
        $page_type = $request->type;

        $title = ucwords(str_replace('_', ' ', $page_type));
        $page_title = 'Form for Assessing of Gratuity For '.$title.' Staff';
        $user = User::where(['status' => 'active', 'verification_status' => 'approved'])->whereNull('is_super_admin')->get();

        $params['page_title'] = $page_title;
        $params['page_type'] = $page_type;
        $params['user'] = $user;

        return view('pages.gratuity.add_edit', $params );

    }

    public function preview( Request $request ) {

        $staff_id = $request->staff_id;
        //REGULAR STAFF
        $staff_info = User::with('appointment.employment_nature')
                        ->whereHas('appointment.employment_nature', function($q){
                            $q->where('name', 'REGULAR STAFF');
                        })->find($staff_id);
                        
        $params = [
                        'staff_info' => $staff_info
                    ];
        $pdf = PDF::loadView('pages.gratuity._preview', $params)->setPaper('a4', 'portrait');
        return $pdf->stream('gratuity_preview.pdf');

    }

}
