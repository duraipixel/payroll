<?php

namespace App\Http\Controllers\DocumentLocker;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Master\Institution;
use App\Models\Master\Division;
use App\Models\Master\Designation;
use App\Models\Master\StaffCategory;
use App\Models\Master\Caste;
use App\Models\Master\Department;
use App\Models\Master\NatureOfEmployment;
use App\Models\Staff\StaffDocument;
use App\Models\Staff\StaffEducationDetail;
use App\Models\Staff\StaffWorkExperience;
use App\Models\Leave\StaffLeave;
use App\Models\Staff\StaffAppointmentDetail;
use App\Models\Master\PlaceOfWork;
use Carbon\Carbon;
use App\Models\PayrollManagement\StaffSalary;
use App\Models\PayrollManagement\SalaryApprovalLog;
use DB;
use Yajra\DataTables\DataTables;

class DocumentLockerController extends Controller
{
    public function index(Request $request)
    {
        $auth_user  = auth()->user();
        $result = User::withCount([
            'staffDocuments',
            'StaffEducationDetail',
            'StaffWorkExperience',
            'StaffLeave',
            'StaffSalary',
            'StaffAppointmentDetail',
            'staffDocumentsPending',
            'staffEducationDocPending',
            'staffExperienceDocPending',
            'leavesPending'

        ])->when(!is_null($auth_user->reporting_manager_id), function ($q) use ($auth_user) {
            $q->where('reporting_manager_id', $auth_user->id);
        })
        ->InstituteBased()
        ->get();

        // Retrieve the total user count
        $totalUserCount = $result->count();

        // Calculate the total count for all relationships
        $totalDocumentCount = $result->sum('staff_documents_count');
        $totalEducationCount = $result->sum('staff_education_detail_count');
        $totalWorkExperienceCount = $result->sum('staff_work_experience_count');
        $totalLeaveCount = $result->sum('staff_leave_count');
        $totalSalaryCount = $result->sum('staff_salary_count');
        $totalAppointmentCount = $result->sum('staff_appointment_detail_count');

        $totalStaffDocumentsPendingCount = $result->sum('staff_documents_pending_count');
        $totalstaffEducationDocPendingCount = $result->sum('staff_education_doc_pending_count');
        $totalstaffExperienceDocPendingCount = $result->sum('staff_experience_doc_pending_count');
        $totalleavesPendingCount = $result->sum('leaves_pending_count');

        $totalstaffDocumentsApproved = $result->sum('staff_documents_approved_count');
        $totalstaffEducationDocApproved = $result->sum('staff_education_doc_approved_count');
        $totalstaffExperienceDocApproved = $result->sum('staff_experience_doc_approved_count');
        $totalleavesApproved = $result->sum('leaves_approved_count');

        $review_pending_documents = $totalStaffDocumentsPendingCount + $totalstaffEducationDocPendingCount + $totalstaffExperienceDocPendingCount + $totalleavesPendingCount;
        $total_documents = $totalDocumentCount + $totalEducationCount + $totalWorkExperienceCount + $totalLeaveCount + $totalSalaryCount + $totalAppointmentCount;
        $approved_documents = $totalstaffDocumentsApproved + $totalstaffEducationDocApproved + $totalstaffExperienceDocApproved + $totalleavesApproved;

        $user_count               = 0;
        $user                     = User::all();

        if ($request->ajax()) {

            $staff_id = $request->staff_id;
            $emp_nature_id = $request->emp_nature_id;
            $work_place_id = $request->work_place_id;

            $data = User::withCount([
                'staffDocuments',
                'StaffEducationDetail',
                'StaffWorkExperience',
                'StaffLeave',
                'StaffSalary',
                'StaffAppointmentDetail',
                'staffDocumentsPending',
                'staffEducationDocPending',
                'staffExperienceDocPending',
                'leavesPending'    
            ])->with(['position.department', 'position.designation'])->select('*')
            ->when( !empty( $staff_id ), function($q) use($staff_id){
                $q->where('users.id', $staff_id);
            })->InstituteBased();
            $status = $request->get('status');
            $datatable_search = $request->datatable_search ?? '';
            $key_search = $request->search['value'];
            
            $keywords = $key_search;

            $datatables =  Datatables::of($data)
                ->filter(function ($query) use ($status, $keywords) {
                    if($keywords)
                    {
                        $date = date('Y-m-d',strtotime($keywords));
                        return $query->where(function($q) use($keywords,$date){

                            $q->where('users.name','like',"%{$keywords}%")
                            ->orWhere('users.society_emp_code','like',"%{$keywords}%")
                            ->orWhereDate('users.created_at',$date);
                        });
                    }
                })
                ->addIndexColumn()
                ->addColumn('department_name', function ($row) {
                    return $row->position->department->name ?? '';
                })
                ->addColumn('designation_name', function($row){
                    return $row->position->designation->name ?? '';
                })
                ->addColumn('total_document', function($row){
                    $total_DocumentCount = $row->staffDocuments->count();
                    $total_EducationCount = $row->StaffEducationDetail->count();
                    $total_WorkExperienceCount = $row->StaffWorkExperience->count();
                    $total_LeaveCount = $row->StaffLeave->count();
                    $total_SalaryCount = $row->StaffSalary->count();
                    $total_AppointmentCount = $row->StaffAppointmentDetail->count();

                    return $total_DocumentCount + $total_EducationCount + $total_WorkExperienceCount + $total_LeaveCount + $total_SalaryCount + $total_AppointmentCount;
                })
                ->editColumn('created_at', function ($row) {
                    $created_at = Carbon::createFromFormat('Y-m-d H:i:s', $row['created_at'])->format('d-m-Y');
                    return $created_at;
                })
                ->addColumn('action', function ($row) {
                    return '<a href="' . route('user.dl_view', ['id' => $row->id]) . '"
                    class="btn btn-icon btn-active-info btn-light-info mx-1 w-30px h-30px">
                    <i class="fa fa-eye"></i>
                </a>';
                })
                ->rawColumns(['action', 'department_name', 'designation_name', 'total_document']);
            return $datatables->make(true);
        }
        $institution     = Institution::where('status', 'active')->get();
        $employee_nature = NatureOfEmployment::where('status', 'active')->get();
        $place_of_work   = PlaceOfWork::where('status', 'active')->get();
        $designation     = Designation::where('status', 'active')->get();
        $staffCategory   = StaffCategory::where('status', 'active')->get();
        $department      = Department::where('status', 'active')->get();

        return view('pages.document_locker.index', compact('institution', 'employee_nature', 'user', 'place_of_work', 'total_documents', 'review_pending_documents',  'user_count', 'designation', 'department', 'staffCategory'));
    }

    public  function changeDocumentStaus(Request $request)
    {
        $id             = $request->id;
        $status         = $request->status;
        $user_id        = auth()->id();
        $info = '';
        if ($request->type == 'personal') {
            $info        = StaffDocument::find($id);
        } else if ($request->type == 'education') {
            $info        = StaffEducationDetail::find($id);
        } else if ($request->type == 'experience') {
            $info        = StaffWorkExperience::find($id);
        } else if ($request->type == 'leave') {
            $info        = StaffLeave::find($id);
            $info->granted_by   = $user_id;
            $info->status   = $status;
        } else if ($request->type == 'salary') {
            $info        = StaffSalary::find($id);
            $info->salary_approved_by   = $user_id;
            if ($status == 'approved') {
                $info->is_salary_processed = 'yes';
            } else if ($status == 'rejected') {
                $info->is_salary_processed = 'no';
            }

            $approved_log_date = Carbon::now();
            $approved_date = $approved_log_date->toDateTimeString();
            $acadamic_id = academicYearId();
            $salary_log = new  SalaryApprovalLog();
            $salary_log->staff_id = $info->staff_id;
            $salary_log->academic_id = $acadamic_id;
            $salary_log->salary_id = $id;
            $salary_log->approved_by = $user_id;
            $salary_log->approval_status = $status;
            $salary_log->approval_date = $approved_date;
            $salary_log->save();
        }
        if ($status == 'approved') {
            $approved_date = Carbon::now();
            $info->approved_date = $approved_date->toDateTimeString();
        } else if ($status == 'rejected') {
            $rejected_date = Carbon::now();
            $info->rejected_date = $rejected_date->toDateTimeString();
        }

        if ($request->type != 'leave' && $request->type != 'salary') {
            $info->approved_by   = $user_id;
            $info->verification_status   = $status;
        }

        $info->update();
        return response()->json(['message' => "You are " . $status . " the document!", 'status' => 1]);
    }

    public  function documentView($id)
    {

        $user            = User::find($id);
        $personal_doc    = StaffDocument::where('staff_id', $id)->get();
        $education_doc   = StaffEducationDetail::where('staff_id', $id)->get();
        $experince_doc   = StaffWorkExperience::where('staff_id', $id)->get();
        $acadamic_id     = academicYearId();
        $leave_doc       = StaffLeave::where('staff_id', $id)->where('academic_id', $acadamic_id)->get();
        $appointment_doc = StaffAppointmentDetail::where('staff_id', $id)->get();
        $salary_doc      = StaffSalary::where('staff_id', $id)->get();
        return view('pages.document_locker.document_view', compact('user', 'personal_doc', 'salary_doc', 'education_doc', 'experince_doc', 'leave_doc', 'appointment_doc'));
        
    }

    public function searchData(Request $request)
    {
        $user = '';
        $staff_id = array();
        if ($request->staff_id != '') {
            $user = User::where('id', $request->staff_id)->get();
        } else {
            if ($request->emp_nature_id != '' &&  $request->work_place_id != '') {
                $app_details = StaffAppointmentDetail::where('nature_of_employment_id', $request->emp_nature_id)->where('place_of_work_id', $request->work_place_id)->get();
                foreach ($app_details as $app_det) {
                    $staff_id[] = $app_det->staff_id;
                }
                $user = User::whereIn('id', $staff_id)->get();
            } else if ($request->emp_nature_id != '' &&  $request->work_place_id == '') {
                $app_details = StaffAppointmentDetail::where('nature_of_employment_id', $request->emp_nature_id)->get();
                foreach ($app_details as $app_det) {
                    $staff_id[] = $app_det->staff_id;
                }
                $user = User::whereIn('id', $staff_id)->get();
            } else if ($request->emp_nature_id == '' &&  $request->work_place_id != '') {
                $app_details = StaffAppointmentDetail::where('place_of_work_id', $request->work_place_id)->get();
                foreach ($app_details as $app_det) {
                    $staff_id[] = $app_det->staff_id;
                }
                $user = User::whereIn('id', $staff_id)->get();
            }
        }
        return view('pages.document_locker.table_ajax', compact('user'));
    }

    public function showOptions(Request $request)
    {
        $staff_details = StaffAppointmentDetail::where('staff_id', $request->staff_id)->first();
        if ($staff_details) {
            $place_of_work_id = $staff_details->place_of_work_id;
            $emp_nature_id = $staff_details->nature_of_employment_id;
            $place_of_work = PlaceOfWork::where('id', $place_of_work_id)->first();
            $emp_nature = NatureOfEmployment::where('id', $emp_nature_id)->first();
            return response()->json(['place_of_work' => $place_of_work, 'emp_nature' => $emp_nature]);
        } else {
            return response()->json(['place_of_work' => '', 'emp_nature' => '']);
        }
    }
}
