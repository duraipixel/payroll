<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AttendanceManagement\LeaveMapping;
use App\Models\ElGratuity;
use App\Models\Staff\StaffAppointmentDetail;
use App\Models\Staff\StaffRetiredResignedDetail;
use App\Models\User;
use Illuminate\Http\Request;
use DataTables;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class GratuityElController extends Controller
{
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
            $data = ElGratuity::with(['staff'])->select('*')
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

        return view('pages.el.index', compact('breadcrums', 'title', 'page_type', 'page_title'));
    }

    public function addEdit(Request $request)
    {
        $page_type = $request->type;
        $id = $request->id ?? '';

        if( !empty( $id ) ) {
            $info = ElGratuity::find( $id );
        }

        $title = ucwords(str_replace('_', ' ', $page_type));
        $page_title = 'Form for Assessing of Gratuity For ' . $title . ' Staff';
        $user = User::select('users.*')->where(['users.status' => 'active', 'users.verification_status' => 'approved'])
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
            
        return view('pages.el.add_edit', $params);
    }

    public function ajaxForm(Request $request)
    {

        $staff_id = $request->staff_id;
        $page_type = $request->page_type;
        $staff_info = User::find($staff_id);
        $first_appointment = StaffAppointmentDetail::where('staff_id', $staff_id)
                        ->whereHas('employment_nature', function ($q) {
                            $q->where('name', 'REGULAR STAFF');
                        })
                        ->orderBy('from_appointment', 'asc')
                        ->first();
        $total_avail_el = LeaveMapping::where('nature_of_employment_id', '3')
                            ->where('leave_head_id', 2)->first();

        $staff_resigned_retired_details = StaffRetiredResignedDetail::where('staff_id', $staff_id)->first();

        $last_working_date = $staff_resigned_retired_details->last_working_date;

        $from = $first_appointment->from_appointment;
        $el_days = [];
        for ($i=0; $i < 50; $i++) { 

            $to = date('Y-m-d', strtotime($from.' + 1 year' ));
            $tmp = ['from_date' => $from, 'to_date' => date('Y-m-d', strtotime($to.' -1 Day')), 'is_final' => 'no' ];
            $from = $to;

            if( date('Y', strtotime($to)) == date('Y', strtotime($last_working_date))) {
                if( $last_working_date > $to ) {
                    
                    $el_days[] = $tmp;
                    $el_days[] = ['from_date' => $from, 'to_date' => $last_working_date, 'is_final' => 'yes' ];
                    break;

                } else {

                    $tmp['to_date'] = $last_working_date;
                    $tmp['is_final'] = 'yes';
                    $el_days[] = $tmp;
                    break;
                    
                }
            }
            $el_days[] = $tmp;

        }
        $availed_year_el = $total_avail_el->leave_days;

        $params = [
            'staff_id' => $staff_id,
            'page_type' => $page_type,
            'staff_info' => $staff_info,
            'allocated_year_el_day' => $availed_year_el,
            'el_days' => $el_days
        ];
        
        return view('pages.el._ajax_form', $params);
    }

}
