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
        $total_documents = StaffDocument::where('status','active')->count();
        $review_pending_documents = StaffDocument::where('verification_status','pending')->where('status','active')->count();
      // $user=User::find(6);
      //dd( $total_documents);
        $institution=Institution::where('status','active')->get();
        $division=NatureOfEmployment::where('status','active')->get();
        $designation=Designation::where('status','active')->get();
        $staffCategory=StaffCategory::where('status','active')->get();
        $department=Department::where('status','active')->get();

        //dd($institution);
        
        return view('pages.document_locker.index',compact('institution','total_documents','review_pending_documents','user','user_count','designation','division','department','staffCategory')); 
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
    public function autocompleteSearch(Request $request)
    {
          $search = $request->get('query');
          /*$filterResult = User::where('name', 'LIKE', '%'. $search. '%')->orwhere('emp_code', 'LIKE', '%'. $search. '%')->get();*/
          $filterResult = User::select("name", 'emp_code')->where('status', 'active')->where('is_super_admin', '=', null)
          ->where(function($query) use ($search){
              $query->where('name', 'LIKE', '%'.$search.'%')
                    ->orWhere('emp_code', 'LIKE', '%'.$search.'%');
                  
          })->get();
          return response()->json($filterResult);
    } 
}
