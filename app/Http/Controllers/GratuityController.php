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

    public function index(Request $request)
    {
        $page_type = $request->type;
        $title = ucwords(str_replace('_', ' ', $page_type));
        $page_title = 'Assessing of Gratuity For ' . $title . ' Staff';
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

                        $q->whereHas('staff', function ($jq) use ($datatable_search) {
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

    public function addEdit(Request $request)
    {
        $page_type = $request->type;

        $title = ucwords(str_replace('_', ' ', $page_type));
        $page_title = 'Form for Assessing of Gratuity For ' . $title . ' Staff';
        $user = User::where(['status' => 'active', 'verification_status' => 'approved'])
            ->whereHas('appointment.employment_nature', function ($q) {
                $q->where('name', 'REGULAR STAFF');
            })
            ->whereNull('is_super_admin')->InstituteBased()->get();

        $params['page_title'] = $page_title;
        $params['page_type'] = $page_type;
        $params['user'] = $user;

        return view('pages.gratuity.add_edit', $params);
    }

    public function ajaxForm(Request $request) {

        $staff_id = $request->staff_id;
        $page_type = $request->page_type;
        $staff_info = User::find($staff_id);
        $params = [
            'staff_id' => $staff_id,
            'page_type' => $page_type,
            'staff_info' => $staff_info
        ];
        // dd( $staff_info->appointment );
        return view('pages.gratuity._ajax_form', $params);

    }

    public function preview(Request $request)
    {

        $staff_id = $request->staff_id;
        //REGULAR STAFF
        $staff_info = User::with('appointment.employment_nature')->find($staff_id);
        // dd( $request->all() );
        $params = [
            'staff_info' => $staff_info,
            'last_post_held' => $request->last_post_held,
            'date_of_regularizion' => $request->date_of_regularizion,
            'date_of_ending_service' => $request->date_of_ending_service,
            'cause_of_ending_service' => $request->cause_of_ending_service,
            'gross_service_year' => $request->gross_service_year,
            'gross_service_month' => $request->gross_service_month,
            'extraordinary_leave' => $request->extraordinary_leave,
            'suspension_qualifying_service' => $request->suspension_qualifying_service,
            'net_qualifying_service' => $request->net_qualifying_service,
            'qualify_service_expressed' => $request->qualify_service_expressed,
            'total_emuluments' => $request->total_emuluments,
            'gratuity_calculation' => $request->gratuity_calculation,
            'nomination' => $request->nomination,
            'gratuity_nomination_name' => $request->gratuity_nomination_name,
            'total_payable_gratuity' => $request->total_payable_gratuity,
            'date_of_issue' => $request->date_of_issue,
            'issue_remarks' => $request->issue_remarks,
            'mode_of_payment' => $request->mode_of_payment,
            'payment_remarks' => $request->payment_remarks,
            'verification_status' => $request->verification_status,
            'basic' => $request->basic,
            'basic_da' => $request->basic_da,
            'basic_pba' => $request->basic_pba ?? 0,
            'basic_pbada' => $request->basic_pbada ?? 0,
        ];
        $pdf = PDF::loadView('pages.gratuity._preview', $params)->setPaper('a4', 'portrait');
        return $pdf->stream('gratuity_preview.pdf');
    }
}
