<?php

namespace App\Http\Controllers\DocumentLocker;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use DataTables;
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

class DocumentLockerController extends Controller
{
    public function index(Request $request)
    {

        /*$post = new SalaryApprovalLog;
  
        $columns = $post->getTableColumns();
        $tables = DB::connection()->getDoctrineSchemaManager()->listTableNames();
        dd($tables);*/
        $user_id        = auth()->user()->id;
        $user_check=User::where('id',$user_id)->where('is_super_admin','1')->first();
        if($user_check)
        {
        $user = User::where('is_super_admin', '=', null)->get();
        $user_count = User::where('is_super_admin', '=', null)->count();
       
        $staff_document_pending = StaffDocument::where('verification_status','pending')->where('status','active')->count();
        $education_doc_pending=StaffEducationDetail::where('verification_status','pending')->count();
        $experince_doc_pending=StaffWorkExperience::where('verification_status','pending')->count();
        $leave_doc_pending=StaffLeave::where('status','pending')->count();
        $salary_pending=StaffSalary::where('status','active')->where('is_salary_processed','no')->count();
       
        $review_pending_documents=$staff_document_pending+$education_doc_pending+$experince_doc_pending+
                                 $leave_doc_pending+$salary_pending;

        $staff_document_total = StaffDocument::where('status','active')->count();
        $education_doc_total=StaffEducationDetail::count();
        $experince_doc_total=StaffWorkExperience::count();
        $leave_doc_total=StaffLeave::count();
        $salary_total=StaffSalary::count();
        
        $appointment_doc_total=StaffAppointmentDetail::where('status','active')->count();
        $total_documents = $staff_document_total+$education_doc_total+$experince_doc_total+
                            $leave_doc_total+$appointment_doc_total+$salary_total;

      
        }
        else
        {
            //dd($user_id);
          
            $user_check_reporting=User::where('is_super_admin','=', null)->where('reporting_manager_id',$user_id)->get();
            $report_manager=[];
            foreach ($user_check_reporting as $key => $user_check_reportings) {
                $report_manager[]=$user_check_reportings->id;
            }

            $user = User::where('is_super_admin', '=', null)->whereIn('id',$report_manager)->get();
            $user_count = User::where('is_super_admin', '=', null)->whereIn('id',$report_manager)->count();
           
            $staff_document_pending = StaffDocument::where('verification_status','pending')->whereIn('staff_id',$report_manager)->where('status','active')->count();
            $education_doc_pending=StaffEducationDetail::where('verification_status','pending')->whereIn('staff_id',$report_manager)->count();
            $experince_doc_pending=StaffWorkExperience::where('verification_status','pending')->whereIn('staff_id',$report_manager)->count();
            $leave_doc_pending=StaffLeave::where('status','pending')->whereIn('staff_id',$report_manager)->count();
            $salary_pending=StaffSalary::where('status','active')->whereIn('staff_id',$report_manager)->where('is_salary_processed','no')->count();
           
            $review_pending_documents=$staff_document_pending+$education_doc_pending+$experince_doc_pending+
                                     $leave_doc_pending+$salary_pending;
    
            $staff_document_total = StaffDocument::where('status','active')->whereIn('staff_id',$report_manager)->count();
            $education_doc_total=StaffEducationDetail::whereIn('staff_id',$report_manager)->count();
            $experince_doc_total=StaffWorkExperience::whereIn('staff_id',$report_manager)->count();
            $leave_doc_total=StaffLeave::whereIn('staff_id',$report_manager)->count();
            $salary_total=StaffSalary::whereIn('staff_id',$report_manager)->count();
            
            $appointment_doc_total=StaffAppointmentDetail::where('status','active')->whereIn('staff_id',$report_manager)->count();
            $total_documents = $staff_document_total+$education_doc_total+$experince_doc_total+
                                $leave_doc_total+$appointment_doc_total+$salary_total;
           //dd($report_manager);
        }
        $institution=Institution::where('status','active')->get();
        $employee_nature=NatureOfEmployment::where('status','active')->get();
        $place_of_work=PlaceOfWork::where('status','active')->get();
        $designation=Designation::where('status','active')->get();
        $staffCategory=StaffCategory::where('status','active')->get();
        $department=Department::where('status','active')->get();
       

        //dd($institution);
        
        return view('pages.document_locker.index',compact('institution','employee_nature','place_of_work','total_documents','review_pending_documents','user','user_count','designation','department','staffCategory')); 
    }
    public  function changeDocumentStaus(Request $request)
    {
        $id             = $request->id;
        $status         = $request->status;
        $user_id        = auth()->id();
        $info='';
        if($request->type=='personal')
        {
            $info        = StaffDocument::find($id);  
        }
        else if($request->type=='education')
        {
            $info        = StaffEducationDetail::find($id);                    
        }
        else if($request->type=='experience')
        {
            $info        = StaffWorkExperience::find($id);                      
        }
        else if($request->type=='leave')
        {
            $info        = StaffLeave::find($id); 
            $info->granted_by   = $user_id;   
            $info->status   = $status;             
        }
        else if($request->type=='salary')
        {
            $info        = StaffSalary::find($id); 
            $info->salary_approved_by   = $user_id;  
            if($status=='approved')
            {  
                $info->is_salary_processed='yes'; 
            }
            else if($status=='rejected')
            {
                $info->is_salary_processed='no'; 
            }

            $approved_log_date = Carbon::now();
            $approved_date=$approved_log_date->toDateTimeString();
            $acadamic_id= academicYearId();
            $salary_log=new  SalaryApprovalLog();           
            $salary_log->staff_id=$info->staff_id;
            $salary_log->academic_id=$acadamic_id;
            $salary_log->salary_id=$id;
            $salary_log->approved_by=$user_id;
            $salary_log->approval_status=$status;
            $salary_log->approval_date=$approved_date;
            $salary_log->save();
        }
        if($status=='approved')
        {               
            $approved_date = Carbon::now();
            $info->approved_date=$approved_date->toDateTimeString();
        }
        else if($status=='rejected')
        {
            $rejected_date = Carbon::now();
            $info->rejected_date=$rejected_date->toDateTimeString();
        }    
       
        if($request->type!='leave' && $request->type!='salary')
        {
            $info->approved_by   = $user_id;
            $info->verification_status   = $status;
        }
      
        $info->update();
        return response()->json(['message' => "You are ".$status." the document!", 'status' => 1]);
    }
    public  function documentView($id)
    {
        $user=User::find($id);  
        $personal_doc=StaffDocument::where('staff_id',$id)->get();
        $education_doc=StaffEducationDetail::where('staff_id',$id)->get();
        $experince_doc=StaffWorkExperience::where('staff_id',$id)->get();
        $acadamic_id= academicYearId();
        $leave_doc=StaffLeave::where('staff_id',$id)->where('academic_id',$acadamic_id)->get();
        $appointment_doc=StaffAppointmentDetail::where('staff_id',$id)->get();
        $salary_doc=StaffSalary::where('staff_id',$id)->get();
        
        return view('pages.document_locker.document_view',compact('user','personal_doc','salary_doc','education_doc','experince_doc','leave_doc','appointment_doc')); 
       
    }
    public function searchData(Request $request)
    {
        $user='';
        $staff_id=array();
       if($request->staff_id!='')
       {
            $user = User::where('is_super_admin', '=', null)->where('id',$request->staff_id)->get();
        }
       else
       {
            if($request->emp_nature_id!='' &&  $request->work_place_id!='')
            {              
                $app_details=StaffAppointmentDetail::where('nature_of_employment_id',$request->emp_nature_id)->where('place_of_work_id', $request->work_place_id)->get();
                foreach($app_details as $app_det)
                {
                    $staff_id[]=$app_det->staff_id;
                }
                $user = User::where('is_super_admin', '=', null)->whereIn('id',$staff_id)->get();               
            }
            else if($request->emp_nature_id!='' &&  $request->work_place_id=='')
            {
                $app_details=StaffAppointmentDetail::where('nature_of_employment_id',$request->emp_nature_id)->get();
                foreach($app_details as $app_det)
                {
                    $staff_id[]=$app_det->staff_id;
                }
                $user = User::where('is_super_admin', '=', null)->whereIn('id',$staff_id)->get();      

            }
            else if($request->emp_nature_id=='' &&  $request->work_place_id!='')
            {
                $app_details=StaffAppointmentDetail::where('place_of_work_id', $request->work_place_id)->get();
                foreach($app_details as $app_det)
                {
                    $staff_id[]=$app_det->staff_id;
                }
                $user = User::where('is_super_admin', '=', null)->whereIn('id',$staff_id)->get(); 
            }
           
        }
        return view('pages.document_locker.table_ajax', compact('user'));
    }
    public function showOptions(Request $request)
    {
        $staff_details=StaffAppointmentDetail::where('staff_id',$request->staff_id)->first();
        if($staff_details)
        {        
            $place_of_work_id=$staff_details->place_of_work_id;
            $emp_nature_id=$staff_details->nature_of_employment_id;
            $place_of_work=PlaceOfWork::where('id',$place_of_work_id)->first();
            $emp_nature=NatureOfEmployment::where('id',$emp_nature_id)->first();
            return response()->json(['place_of_work' => $place_of_work, 'emp_nature' => $emp_nature]);
        }
        else
        {
            return response()->json(['place_of_work' => '', 'emp_nature' => '']);
        }

    }
}
