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

class DocumentLockerController extends Controller
{
    public function index(Request $request)
    {
       
       /* if ($request->ajax()) 
        {
            $data = User::where('is_super_admin', '=', null);
            $datatables =  Datatables::of($data)
                            ->addIndexColumn();
            return $datatables->make(true);
        }*/
        $user = User::where('is_super_admin', '=', null)->get();
        $user_count = User::where('is_super_admin', '=', null)->count();
       
        $staff_document_pending = StaffDocument::where('verification_status','pending')->where('status','active')->count();
        $education_doc_pending=StaffEducationDetail::where('verification_status','pending')->count();
        $experince_doc_pending=StaffWorkExperience::where('verification_status','pending')->count();
        $leave_doc_pending=StaffLeave::where('status','pending')->count();
       
        $review_pending_documents=$staff_document_pending+$education_doc_pending+$experince_doc_pending+
                                 $leave_doc_pending;

        $staff_document_total = StaffDocument::where('status','active')->count();
        $education_doc_total=StaffEducationDetail::count();
        $experince_doc_total=StaffWorkExperience::count();
        $leave_doc_total=StaffLeave::count();
        $appointment_doc_total=StaffAppointmentDetail::where('status','active')->count();
        $total_documents = $staff_document_total+$education_doc_total+$experince_doc_total+
                            $leave_doc_total+$appointment_doc_total;
        // $user=User::find(6);
      //dd( $total_documents);
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
        $status         = 'approved';
        $info='';
        if($request->type=='personal')
        {
            $info           = StaffDocument::find($id);           
        }
        else if($request->type=='education')
        {
            $info           = StaffEducationDetail::find($id);            
        }
        else if($request->type=='experience')
        {
            $info           = StaffWorkExperience::find($id);            
        }
        else
        {
            $info           ='';
        }
        $info->verification_status   = $status;
        $info->update();
        
        
        return response()->json(['message' => "You are approved the document!", 'status' => 1]);
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
        
        return view('pages.document_locker.document_view',compact('user','personal_doc','education_doc','experince_doc','leave_doc','appointment_doc')); 
       
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
