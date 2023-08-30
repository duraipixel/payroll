<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Gratuity;
use App\Models\GratuityEmulument;
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
            $status = $request->get('status');
            $datatable_search = $request->datatable_search ?? '';
            $keywords = $datatable_search;
            $data = Gratuity::with(['staff'])->select('*')
            ->when(!empty($datatable_search), function ($query) use ($datatable_search) {
                $date = date('Y-m-d', strtotime($datatable_search));
                return $query->where(function ($q) use ($datatable_search, $date) {

                    $q->whereHas('staff', function($jq) use($datatable_search){
                            $jq->where('name', 'like', "%{$datatable_search}%")
                            ->orWhere('institute_emp_code', 'like', "%{$datatable_search}%");
                        })
                        ->orWhere('gross_service', 'like', "%{$datatable_search}%")
                        ->orWhere('mode_of_payment', 'like', "%{$datatable_search}%")
                        ->orWhere('mode_of_payment', 'like', "%{$datatable_search}%")
                        ->orWhere('total_payable_gratuity', 'like', "%{$datatable_search}%")
                        ->orWhere('gratuity_nomination_name', 'like', "%{$datatable_search}%")
                        ->orWhereDate('date_of_ending_service', $date)
                        ->orWhereDate('date_of_regularizion', $date);
                });
            })->where('page_type', $page_type);

            $datatables =  Datatables::of($data)
                
                ->addIndexColumn()
                ->editColumn('verification_status', function ($row) {
                    $status = '<a href="javascript:void(0);" class="badge badge-light-' . (($row->verification_status == 'verified') ? 'success' : (($row->verification_status == 'pending') ? 'warning' : 'danger') ). '" tooltip="Click to ' . ucwords($row->verification_status) . '" ">' . ucfirst($row->verification_status) . '</a>';
                    return $status;
                })
                ->editColumn('created_at', function ($row) {
                    $created_at = Carbon::createFromFormat('Y-m-d H:i:s', $row['created_at'])->format('d-m-Y');
                    return $created_at;
                })
                ->editColumn('cause_of_ending_service', function ($row) {
                    $created_at = ucwords(str_replace('_', ' ', $row['cause_of_ending_service']));
                    return $created_at;
                })
                ->addColumn('action', function ($row) use($page_type) {
                    $route_name = request()->route()->getName();
                    if (access()->buttonAccess($route_name, 'add_edit')) {
                        $edit_btn = '<a href="'.route('gratuity.add_edit', ['type' => $page_type, 'id' => $row->id]).'" class="btn btn-icon btn-active-primary btn-light-primary mx-1 w-30px h-30px" > 
                    <i class="fa fa-edit"></i>
                    </a>';
                    } else {
                        $edit_btn = '';
                    }
                    if (access()->buttonAccess($route_name, 'delete')) {
                        $del_btn = '<a href="javascript:void(0);" onclick="deleteGratuity(' . $row->id . ')" class="btn btn-icon btn-active-danger btn-light-danger mx-1 w-30px h-30px" > 
                    <i class="fa fa-trash"></i></a>';
                    } else {
                        $del_btn = '';
                    }
                    return $edit_btn . $del_btn;
                })
                ->rawColumns(['action', 'verification_status']);
            return $datatables->make(true);
        }

        return view('pages.gratuity.index', compact('breadcrums', 'title', 'page_type', 'page_title'));
    }

    public function addEdit(Request $request)
    {
        $page_type = $request->type;
        $id = $request->id ?? '';

        if( !empty( $id ) ) {
            $info = Gratuity::find( $id );
        }

        $title = ucwords(str_replace('_', ' ', $page_type));
        $page_title = 'Form for Assessing of Gratuity For ' . $title . ' Staff';
        $user = User::where(['users.status' => 'active', 'users.verification_status' => 'approved'])
            ->whereHas('appointment.employment_nature', function ($q) {
                $q->where('name', 'REGULAR STAFF');
            })
            ->whereNull('users.is_super_admin')->InstituteBased()
            ->join('staff_retired_resigned_details', 'staff_retired_resigned_details.staff_id', '=', 'users.id')
            ->where('staff_retired_resigned_details.types', $page_type)
            ->get();

        $params['page_title'] = $page_title;
        $params['page_type'] = $page_type;
        $params['user'] = $user;
        $params['info'] = $info ?? [];
            
        return view('pages.gratuity.add_edit', $params);
    }

    public function ajaxForm(Request $request)
    {

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
            'gratuity_type' => $request->gratuity_type
        ];
        $pdf = PDF::loadView('pages.gratuity._preview', $params)->setPaper('a4', 'portrait');
        return $pdf->stream('gratuity_preview.pdf');
    }

    public function save(Request $request)
    {

        $id = $request->id ?? '';
        $data = '';
        $validator      = Validator::make($request->all(), [
            'staff_id' => 'required|string|unique:gratuities,staff_id,' . $id . ',id,deleted_at,NULL',
            'last_post_held' => 'required',
            'date_of_regularizion' => 'required',
            'date_of_ending_service' => 'required',
            'cause_of_ending_service' => 'required',
            'gross_service_year' => 'required',
            'net_qualifying_service' => 'required',
            'qualify_service_expressed' => 'required',
            'total_emuluments' => 'required',
            'gratuity_calculation' => 'required',
            'total_payable_gratuity' => 'required',
            'gratuity_type' => 'required'
        ]);

        if ($validator->passes()) {
            $page_type = $request->page_type;
            $staff_id = $request->staff_id;
            $staff_info = User::find($staff_id);
            $year_names = isset($request->gross_service_year) && $request->gross_service_year > 1 ? $request->gross_service_year . ' Years' : $request->gross_service_year . ' Years';
            $month_names = '';
            if (isset($request->gross_service_month) && $request->gross_service_month > 0) {
                $month_names = isset($request->gross_service_month) && $request->gross_service_month > 1 ? ' and ' . $request->gross_service_month . ' months' : ' and ' . $request->gross_service_month . ' Month';
            }
            $gross_service = $year_names . $month_names;
            $ins = [];
            $ins['academic_id'] = academicYearId();
            $ins['staff_id'] = $staff_id;
            $ins['institution_id'] = session()->get('staff_institute_id');
            $ins['last_post_held'] = $request->last_post_held;
            $ins['date_of_regularizion'] = date('Y-m-d', strtotime($request->date_of_regularizion));
            $ins['date_of_ending_service'] = date('Y-m-d', strtotime($request->date_of_ending_service));;
            $ins['cause_of_ending_service'] = $request->cause_of_ending_service;
            $ins['gross_service'] = $gross_service;
            $ins['gross_service_year'] = $request->gross_service_year;
            $ins['gross_service_month'] = $request->gross_service_month;
            $ins['extraordinary_leave'] = $request->extraordinary_leave;
            $ins['suspension_qualifying_service'] = $request->suspension_qualifying_service;
            $ins['net_qualifying_service'] = $request->net_qualifying_service;
            $ins['qualify_service_expressed'] = $request->qualify_service_expressed;
            $ins['total_emuluments'] = $request->total_emuluments;
            $ins['gratuity_calculation'] = $request->gratuity_calculation;
            $ins['gratuity_nomination_name'] = $request->gratuity_nomination_name;
            // $ins['gratuity_nomination_type'] = '';
            $ins['total_payable_gratuity'] = $request->total_payable_gratuity;
            $ins['mode_of_payment'] = $request->mode_of_payment ?? null;
            // $ins['status'] = '';
            $ins['verification_status'] = $request->verification_status;
            $ins['date_of_issue'] = isset($request->date_of_issue) && !empty($request->date_of_issue) ? date('Y-m-d', strtotime($request->date_of_issue)) : null;
            $ins['issue_remarks'] = $request->issue_remarks ?? null;
            $ins['page_type'] = $page_type;
            $ins['gratuity_type'] = $request->gratuity_type;

            if ($request->hasFile('issue_attachment')) {

                $files = $request->file('issue_attachment');
                $imageName = uniqid() . Str::replace(' ', "-", $files->getClientOriginalName());

                $directory = 'gratuity/' . $staff_info->institute_emp_code;
                $filename  = $directory . '/' . $imageName;

                Storage::disk('public')->put($filename, File::get($files));
                $ins['issue_attachment'] = $filename;
            }
            if ($request->hasFile('payment_attachment')) {

                $files = $request->file('payment_attachment');
                $imageName = uniqid() . Str::replace(' ', "-", $files->getClientOriginalName());

                $directory = 'gratuity/' . $staff_info->institute_emp_code;
                $filename1  = $directory . '/' . $imageName;

                Storage::disk('public')->put($filename, File::get($files));
                $ins['payment_attachment'] = $filename1;
            }
            $ins['payment_remarks'] = $request->payment_remarks ?? null;
            $ins['approved_by'] = auth()->user()->id;
            $g_info = Gratuity::updateOrCreate(['staff_id' => $staff_id], $ins);

            if ($request->basic) {
                $e_ins = [];
                $e_ins['academic_id'] = academicYearId();
                $e_ins['gratuity_id'] = $g_info->id;
                $e_ins['field'] = 'Basic';
                $e_ins['amount'] = $request->basic;
                GratuityEmulument::updateOrCreate(['gratuity_id' => $g_info->id, 'field' => 'Basic'], $e_ins);
            }
            if ($request->basic_da) {
                $e_ins = [];
                $e_ins['academic_id'] = academicYearId();
                $e_ins['gratuity_id'] = $g_info->id;
                $e_ins['field'] = 'Basic DA';
                $e_ins['amount'] = $request->basic_da;
                GratuityEmulument::updateOrCreate(['gratuity_id' => $g_info->id, 'field' => 'Basic DA'], $e_ins);
            }
            if ($request->basic_pba) {
                $e_ins = [];
                $e_ins['academic_id'] = academicYearId();
                $e_ins['gratuity_id'] = $g_info->id;
                $e_ins['field'] = 'PBA';
                $e_ins['amount'] = $request->basic_pba;
                GratuityEmulument::updateOrCreate(['gratuity_id' => $g_info->id, 'field' => 'PBA'], $e_ins);
            }
            if ($request->basic_pbada) {
                $e_ins = [];
                $e_ins['academic_id'] = academicYearId();
                $e_ins['gratuity_id'] = $g_info->id;
                $e_ins['field'] = 'PBADA';
                $e_ins['amount'] = $request->basic_pbada;
                GratuityEmulument::updateOrCreate(['gratuity_id' => $g_info->id, 'field' => 'PBADA'], $e_ins);
            }
            $error = 0;
            $message = 'Added successfully';
            $url = route('gratuity', ['type' => $page_type]);
        } else {
            $error = 1;
            $message = $validator->errors()->all();
        }

        return response()->json(['error' => $error, 'message' => $message, 'url' => $url ?? '']);
    }

    public function delete(Request $request) {
        
        Gratuity::where('id', $request->id)->delete();
        GratuityEmulument::where('gratuity_id', $request->id)->delete();
        return response()->json(['message'=>"Successfully deleted state!",'status'=>1]);

    }
}
