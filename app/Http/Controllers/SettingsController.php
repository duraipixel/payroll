<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AcademicYear;
use App\Models\CalenderYear;
use App\Models\Staff\StaffLeaveMapping;
use App\Models\Staff\StaffELEntry;
use DataTables;
use App\Models\User;
use Carbon\Carbon;
use DB;
use App\Imports\PayrollImport;
use App\Imports\PayrollLoanImport;
use App\Imports\PayrollHeadImport;
use App\Models\Staff\StaffAppointmentDetail;
use App\Models\Leave\StaffLeave;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\File;
class SettingsController extends Controller
{
    
    public function ListYEP(Request $request){
    $acadamic=AcademicYear::where('is_current',1)->first();
    $calender=CalenderYear::orderBy('id','desc')->first();
       return view('pages.setting.index',['acadamic'=>$acadamic,'calender'=>$calender]);
    }
     public function YEPUpdate(Request $request){
        $type=$request->type;
        if($type=='academic'){
        $validate_array = [
            'from_date' => 'required',
            'to_date' => 'required',
        ];
         $validator      = Validator::make($request->all(), $validate_array);
         if($validator->fails()){
            $error = 1;
            $message = $validator->errors()->all();
            return response()->json(['error' => $error, 'message' => $message]);
         }
        $acadamic=AcademicYear::where('from_year', date('Y',strtotime($request->from_date)))->where('to_year', date('Y',strtotime($request->to_date)))->first();
        if($acadamic){
            $error = 1;
            $message = ['AcademicYear already this date'];
        return response()->json(['error' => $error, 'message' => $message]);
        }
         $acadamic=AcademicYear::where('is_current', 1)->update(['is_current' => 0]);
          $data=new AcademicYear;
          $data->from_year=date('Y',strtotime($request->from_date));
          $data->to_year=date('Y',strtotime($request->to_date));
          $data->from_month=sprintf("%02d", date('m',strtotime($request->from_date)));
          $data->to_month=sprintf("%02d", date('m',strtotime($request->to_date)));
          $data->order_by=1;
          $data->is_current=1;
          if($data->save()){
            if($data) {
                Session::put('academic_id', $data->id);
            }
          $error = 0;
          $message = ['AcademicYear updated successfully'];
          return response()->json(['error' => $error, 'message' => $message]);
          }
        }elseif($type=='calender'){
        $acadamic=AcademicYear::where('is_current',1)->first();
        $validate_array = [
            'from_date' => 'required',
            'to_date' => 'required',
        ];
         $validator      = Validator::make($request->all(), $validate_array);
         if($validator->fails()){
            $error = 1;
            $message = $validator->errors()->all();
            return response()->json(['error' => $error, 'message' => $message]);
         }
        $calender=CalenderYear::where('year', date('Y',strtotime($request->from_date)))->first();
        if($calender){
            $error = 1;
            $message = ['CalenderYear already this date'];
        return response()->json(['error' => $error, 'message' => $message]);
        }
          $data=new CalenderYear;
          $data->year=date('Y',strtotime($request->from_date));
          //$data->calendar_date=$request->to_date;
          $data->from_month=sprintf("%02d", date('m',strtotime($request->from_date)));
          $data->to_month=sprintf("%02d", date('m',strtotime($request->to_date)));
          //$data->acadamic_id=$acadamic->id;
          if($data->save()){
          $error = 0;
          $message = ['CalenderYear updated successfully'];
          return response()->json(['error' => $error, 'message' => $message]);
          }

        }else{
        $acadamic=AcademicYear::where('is_current',1)->first();
        $calender=CalenderYear::orderBy('id','desc')->first();
        $mapping=StaffLeaveMapping::where('calender_id',$calender->id)->first();
        if($mapping){
            $error = 1;
            $message = ['Year End Process already Reset successfully'];
        return response()->json(['error' => $error, 'message' => $message]);
        }
          $this->AutoloadYearLeave($calender->year);
           $error = 0;
          $message = ['Year End Process Reset successfully'];
          return response()->json(['error' => $error, 'message' => $message]);

        }
    
    }
    public function StaffElsummary(Request $request,$id)
    {
        $breadcrums = array(
            'title' => 'Staff El Summary',
             'breadcrums' => array(
                array(
                    'link' => '', 
                    'title' => 'Staff El Summary'
                ),
            )
        );
        if ($request->ajax()) {
            $data = StaffLeaveMapping::where('leave_head_id',2)->where('staff_id',$id)->OrderBy('calender_id','asc')->get();
            $datatables =  Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('year', function ($row) {
                   return ($row->calanderYear !=null)? $row->calanderYear->year : '';
                })
               ->editColumn('el_availed', function ($row) {
                  return $row->availed;
                })

                ->editColumn('el_balance', function ($row) {
                  return $row->carry_forward_count;
                })
                ->addColumn('action', function ($row) {
                        $add_btn = '<a href="javascript:void(0);"  onclick="getElAddModal(' . $row->id . ', \'edit\')" class="btn btn-icon btn-active-primary btn-light-primary mx-1 w-30px h-30px" > 
                                   <i class="fa fa-edit"></i>
                          </a>';
                        $edit_btn = '<a href="javascript:void(0);"  onclick="getElModal(' . $row->id . ', \'edit\')" class="btn btn-icon btn-active-primary btn-light-primary mx-1 w-30px h-30px" > 
                                      <i class="fa fa-plus" aria-hidden="true"></i>
                                </a>';
                        $view_btn = '<a href="javascript:void(0);"  onclick="getElModal(' . $row->id . ', \'view\')" class="btn btn-icon btn-active-info btn-light-info mx-1 w-30px h-30px" >  
                                    <i class="fa fa-eye"></i>
                                </a>';
                    
                    
                    return $add_btn. $edit_btn . $view_btn;
                })
                ->rawColumns(['action']);
           return $datatables->make(true);
        }
        return view('pages.staff.registration.el_information.index', compact('breadcrums'));
    }
   public function StaffElsummaryAdd(Request $request)
    {
        $id = $request->id;
        $type = $request->type;
        $info = [];
        $title = $type.' EL Entry';
        if (isset($id) && !empty($id)) {
            $info = StaffLeaveMapping::find($id);
            $title =  $type.' EL Entry';
          
        }
        //dd($info );
        $content = view('pages.staff.registration.el_information.add', compact('info', 'title','type'));
        return view('layouts.modal.dynamic_modal', compact('content', 'title'));
    }
    public function StaffElAdd(Request $request)
    {
        $id = $request->id;
        $info = StaffLeaveMapping::find($id);
        if(!$info){
          return 'not fount';
        }
        $before=StaffLeaveMapping::where('leave_head_id',2)->where('staff_id',$info->staff_id)
                         ->where('id', '<', $id)
                         ->get()->last();
        if(isset($before) && !empty($before) && !empty($before->accumulated)){
        $info->accumulated =(int)$before->accumulated+(int)$request->el_granted;
        $info->carry_forward_count=(int)$request->el_granted+(int)$before->carry_forward_count;
        }else{
        $info->accumulated=(int)$request->el_granted;
        $info->carry_forward_count=(int)$request->el_granted;
        }
        $info->no_of_leave=$request->el_granted;
       
        if($info->update()){
          $this->TestELEntry($info->staff_id);
        }      
        return true;
    }
     public function StaffElsummaryEdit(Request $request)
    {
        $id = $request->id;
        $type = $request->type;
        $info = [];
        $leave_datas=[];
        $title = $type.' EL Summary';
        if (isset($id) && !empty($id) && $type !='single') {
            $info = StaffLeaveMapping::with('elentries')->find($id);
            $acadamic=CalenderYear::find($info->calender_id);
            $leave_datas=StaffLeave::where('staff_id',$info->staff_id)->where('leave_category','Earned Leave')->where('leave_category_id',2)
            ->where(function($query) use ($acadamic) {
              $query->whereYear('from_date', $acadamic->year)
                    ->orWhereYear('to_date', $acadamic->year);
            })->select('id','staff_id','leave_category','from_date','to_date','granted_days','reason','leave_category_id')->where('status','approved')->get();
           
            $title =  $type.' EL Summary';
          
          
        }else{
          $info = StaffELEntry::find($id);
          $title =  'Edit EL Summary';
        }
        //dd($info );
        $content = view('pages.staff.registration.el_information.add_edit', compact('info', 'title','type','leave_datas'));
        return view('layouts.modal.dynamic_modal', compact('content', 'title'));
    }
    
    public function StaffElsummaryUpdate(Request $request){
    $fromDates = $request->input('from_date');
    $toDates = $request->input('to_date');
    $availed = $request->input('availed');
    $remarks = $request->input('remarks');
    if(isset($request->type)  && $request->type=='single'){
      $el_entry=StaffELEntry::find($request->id);
      $el_entry->staff_id=$request->staff_id;
      $el_entry->leave_mapping_id=$request->leave_mapping_id;
      $el_entry->academic_id=$request->academic_id;
      $el_entry->calender_id=$request->calendar_id;
      $el_entry->from_date=$request->from_date;
      $el_entry->to_date=$request->to_date;
      $el_entry->leave_days=$request->leave_days;
      $el_entry->remarks=$request->remarks;
      $el_entry->update();
    }else{
    foreach ($fromDates as $index => $fromDate) {
    $toDate = $toDates[$index];
    $leaveAvailed = $availed[$index];
    $leaveRemarks = $remarks[$index];
        $el_entry=new StaffELEntry();
        $el_entry->staff_id=$request->staff_id;
        $el_entry->leave_mapping_id=$request->leave_mapping_id;
        $el_entry->academic_id=$request->academic_id;
        $el_entry->calender_id=$request->calendar_id;
        $el_entry->from_date=$fromDate;
        $el_entry->to_date=$toDate;
        $el_entry->leave_days=$leaveAvailed;
        $el_entry->remarks=$leaveRemarks;
        $el_entry->save();
    }
    }
    $this->TestELEntry($request->staff_id);
    return true;
    }
    public function StaffElsummaryDelete(Request $request){
    $el_entry=StaffELEntry::find($request->id);
    $el_entry->delete();
    $this->TestELEntry($el_entry->staff_id);
    return true;
    }
    public function AutoloadYearLeave($year)
    {
      ini_set("max_execution_time", 0);
           ini_set('memory_limit', '-1');
         $users=User::where('status','active')->get();
        foreach($users as $user){
            $academicYear=AcademicYear::where('from_year',$year)->orWhere('to_year',$year)->first();
            $calendarYear=CalenderYear::where('year',$year)->first();
            if (isset($user->firstAppointment) && isset($year) > 0 && isset($calendarYear)) {
              $entry = getStaffAppointment($user->id, $year);
             
              if (isset($entry) && isset($entry['id'])) {
                  $entryValues = appointmentLaeve($entry['id']);
                  if (isset($entryValues)) {
                      foreach ($entryValues as $leaveAllocated) {
                          $appointment = StaffAppointmentDetail::find($entry['id']);
                          
                          $new = [
                              "staff_id" => $user->id,
                              "leave_head_id" => $leaveAllocated->leave_head_id,
                              "no_of_leave_actual" => $leaveAllocated->leave_days,
                              "carry_forward_count" => 0,
                          ];
                          
                          if ($leaveAllocated->carry_forward === "yes" && $leaveAllocated->leave_head_id == 2) {
                              $previousData = StaffLeaveMapping::where("staff_id", $user->id)
                                  ->where("leave_head_id", 2)
                                  ->where("calender_id", $calendarYear->id - 1)
                                  ->first();
                              
                              $total = leaveData($user->id, $year, "Earned Leave");
                              
                              $manualEntry = StaffELEntry::where("staff_id", $user->id)
                                  ->where("academic_id", $academicYear->id)
                                  ->select(DB::raw("SUM(leave_days) as total_days"))
                                  ->first();
                              
                              $manualEntryTotal = $manualEntry->total_days ?? 0;
                              $previousCarryForward = $previousData->carry_forward_count ?? 0;
                              
                              if (getStaffAppointmentYear($year, $user->id) == 1) {
                                  $month = Carbon::parse($appointment->from_appointment)->month;
                                  $division = getStaffMonthSeparate($month);
                                  $leaveTotal = isset($division) && !empty($division) 
                                      ? $leaveAllocated->leave_days / $division 
                                      : $leaveAllocated->leave_days;
                              } else {
                                  $leaveTotal = $leaveAllocated->leave_days;
                              }
                              
                              $new["carry_forward_count"] = $previousCarryForward + $leaveTotal - $total - $manualEntryTotal;
                              $new["accumulated"] = (int) $previousCarryForward + $leaveTotal;
                              $new["no_of_leave"] = $leaveTotal;
                              $new["availed"] = (int) $total + (int) $manualEntryTotal;
                          } else {
                              $new["carry_forward_count"] = 0;
                              $month = Carbon::parse($appointment->from_appointment)->month;
                              $new["no_of_leave"] = $leaveAllocated->leave_days;
                              $new["accumulated"] = $leaveAllocated->leave_days;
                          }
                          
                          $new["acadamic_id"] = $academicYear->id;
                          $new["calender_id"] = $calendarYear->id;
                          
                          StaffLeaveMapping::updateOrCreate(
                              [
                                  "staff_id" => $user->id,
                                  "calender_id" => $calendarYear->id,
                                  "leave_head_id" => $leaveAllocated->leave_head_id,
                              ],
                              $new
                          );
                      }
                  }
              }
          }
      
           
        }
       return true;
    } 
    public function UserEntrylevelGentrate($user_id)
    {
      ini_set("max_execution_time", 0);
      ini_set('memory_limit', '-1');
        $user = User::find($user_id);
        $years = [];
        
        if (isset($user->firstAppointment)) {
            $years = getYearsBetween(
                date("Y", strtotime($user->firstAppointment->from_appointment)),
                date("Y")
            );
        }
        if (count($years) > 0) {
            foreach ($years as $year) {
                $academicYear = AcademicYear::where("from_year", $year)->first();
                $calendarYear = CalenderYear::where("year", $year)->first();
                
                if (isset($user->firstAppointment) && isset($year) > 0 && isset($calendarYear)) {
                    $entry = getStaffAppointment($user->id, $year);
                   
                    if (isset($entry)) {
                        $entryValues = appointmentLaeve($entry['id']);
   
                        if (isset($entryValues)) {
                            foreach ($entryValues as $leaveAllocated) {
                                $appointment = StaffAppointmentDetail::find($entry['id']);
                                
                                $new = [
                                    "staff_id" => $user->id,
                                    "leave_head_id" => $leaveAllocated->leave_head_id,
                                    "no_of_leave_actual" => $leaveAllocated->leave_days,
                                    "carry_forward_count" => 0,
                                ];
                                
                                if ($leaveAllocated->carry_forward === "yes" && $leaveAllocated->leave_head_id == 2) {
                                    $previousData = StaffLeaveMapping::where("staff_id", $user->id)
                                        ->where("leave_head_id", 2)
                                        ->where("calender_id", $calendarYear->id - 1)
                                        ->first();
                                    
                                    $total = leaveData($user->id, $year, "Earned Leave");
                                    
                                    $manualEntry = StaffELEntry::where("staff_id", $user->id)
                                        ->where("academic_id", $academicYear->id)
                                        ->select(DB::raw("SUM(leave_days) as total_days"))
                                        ->first();
                                    
                                    $manualEntryTotal = $manualEntry->total_days ?? 0;
                                    $previousCarryForward = $previousData->carry_forward_count ?? 0;
                                    
                                    if (getStaffAppointmentYear($year, $user->id) == 1) {
                                        $month = Carbon::parse($appointment->from_appointment)->month;
                                        $division = getStaffMonthSeparate($month);
                                        $leaveTotal = isset($division) && !empty($division) 
                                            ? $leaveAllocated->leave_days / $division 
                                            : $leaveAllocated->leave_days;
                                    } else {
                                        $leaveTotal = $leaveAllocated->leave_days;
                                    }
                                    
                                    $new["carry_forward_count"] = $previousCarryForward + $leaveTotal - $total - $manualEntryTotal;
                                    $new["accumulated"] = (int) $previousCarryForward + $leaveTotal;
                                    $new["no_of_leave"] = $leaveTotal;
                                    $new["availed"] = (int) $total + (int) $manualEntryTotal;
                                } else {
                                    $new["carry_forward_count"] = 0;
                                    $month = Carbon::parse($appointment->from_appointment)->month;
                                    $new["no_of_leave"] = $leaveAllocated->leave_days;
                                    $new["accumulated"] = $leaveAllocated->leave_days;
                                }
                                
                                $new["acadamic_id"] = $academicYear->id;
                                $new["calender_id"] = $calendarYear->id;
                                
                                StaffLeaveMapping::updateOrCreate(
                                    [
                                        "staff_id" => $user->id,
                                        "calender_id" => $calendarYear->id,
                                        "leave_head_id" => $leaveAllocated->leave_head_id,
                                    ],
                                    $new
                                );
                            }
                        }
                    }
                }
            }
        }
        
        return redirect()->route('staff.register', ['id' => $user_id]);
    }
    public function TestELEntry($user_id)
{
    ini_set("max_execution_time", 0);
    ini_set('memory_limit', '-1');
    
    $user = User::find($user_id);
    $years = [];

    if (isset($user->firstAppointment)) {
        $years = getYearsBetween(
            date("Y", strtotime($user->firstAppointment->from_appointment)),
            date("Y")
        );
    }
    
    if (count($years) > 0) {
        foreach ($years as $year) {
            $acadamic_id = AcademicYear::where("from_year", $year)->first();
            $calender_id = CalenderYear::where("year", $year)->first();
            $entry = getStaffAppointment($user->id, $year);
          
            if (isset($entry)) {
                $entry_value = appointmentLaeve($entry['id']);

                if (isset($entry_value)) {
                    foreach ($entry_value as $leaveAllocated) {
                        $appointment = StaffAppointmentDetail::find($entry['id']);
                        
                        $new = [
                            "staff_id" => $user->id,
                            "leave_head_id" => $leaveAllocated->leave_head_id,
                            "no_of_leave_actual" => $leaveAllocated->leave_days,
                        ];
                        
                        if ($leaveAllocated->leave_head_id == 2) {
                            if ( $leaveAllocated->carry_forward == "yes") {  
                            $previous_data = StaffLeaveMapping::where("staff_id", $user->id)
                                ->where("leave_head_id", 2)
                                ->where("calender_id", $calender_id->id - 1)
                                ->first();
                            
                            $total = leaveData($user->id, $year, "Earned Leave");
                            
                            $manual_entry = StaffELEntry::where("staff_id", $user->id)
                                ->where("academic_id", $acadamic_id->id)
                                ->select(DB::raw("SUM(leave_days) as total_days"))
                                ->first();
                            
                            $data_p = StaffLeaveMapping::where("staff_id", $user->id)
                                ->where("leave_head_id", 2)
                                ->where("calender_id", $calender_id->id)
                                ->first();
                            
                            if (isset($data_p) && (int)$leaveAllocated->leave_days != (int)$data_p->no_of_leave) {
                                $leave_total = $data_p->no_of_leave;
                            } else {
                                $leave_total = $leaveAllocated->leave_days;
                            }
                            
                            if ($previous_data) {
                                $new["carry_forward_count"] = $previous_data->carry_forward_count + $leave_total - $total - $manual_entry->total_days;
                                $new["accumulated"] = (int) $previous_data->carry_forward_count + $leave_total ?? 0;
                            } else {
                                if (isset($data_p) && (int)$leaveAllocated->leave_days != (int)$data_p->no_of_leave) {
                                    $n_leave_days = $data_p->no_of_leave;
                                } else {
                                    $n_leave_days = $leaveAllocated->leave_days;
                                }
                                $new["carry_forward_count"] = $n_leave_days - $total - $manual_entry->total_days;
                                $new["accumulated"] = (int) $n_leave_days ?? 0;
                            }
                            
                            $new["no_of_leave"] = $leave_total;
                            $new["availed"] = (int) $total + (int) $manual_entry->total_days ?? 0;
                            } else {
                                $new["carry_forward_count"] = 0;
                            }
                        
                        $new["acadamic_id"] = $acadamic_id->id;
                        $new["calender_id"] = $calender_id->id;
                        
                        StaffLeaveMapping::updateOrCreate(
                            [
                                "staff_id" => $user->id,
                                "leave_head_id" => $leaveAllocated->leave_head_id,
                                "calender_id" => $calender_id->id
                            ],
                            $new
                        );
                      }
                    }
                }
            }
        }
    }
    return redirect()->route('staff.register', ['id' => $user_id]);
}
    function PayrollBulkUpload()
    {
        return view('pages.payroll_management.bulk upload.index');
    }
    public function importPayroll(Request $request) 
    {  
    
      $validator=$this->validate($request, [
        'file' => 'required',     
       
    ],
    [
        'file.required' => 'You must need to upload the excel file!',    
      
    ]);  
      $exampleImport = new PayrollImport;
      $excel_import=Excel::import($exampleImport, $request->file);
      if($excel_import)
      {
          return back()->with('success','Excel Uploaded successfully!');
      }
      else
      {
          return back()->with('error','Excel Not Uploaded. Please try again later !');
      }   
        
    }
    public function SampleXls()
    {
        $filePath = public_path('Excel_Format\samplepayroll.xlsx');
        $fileName = 'PayrollBulkUpload.xlsx';

        return response()->download($filePath, $fileName);
    }
    public function PayrollHeadBulkUpload(Request $request) 
    {  
    
      $validator=$this->validate($request, [
        'file' => 'required',     
       
    ],
    [
        'file.required' => 'You must need to upload the excel file!',    
      
    ]);  
      $exampleImport = new PayrollHeadImport;
      $excel_import=Excel::import($exampleImport, $request->file);
      if($excel_import)
      {
          return back()->with('success','Excel Uploaded successfully!');
      }
      else
      {
          return back()->with('error','Excel Not Uploaded. Please try again later !');
      }   
        
    }
    public function SampleHeadXls()
    {
        $filePath = public_path('Excel_Format\head.xlsx');
        $fileName = 'PayrollHeadBulkUpload.xlsx';

        return response()->download($filePath, $fileName);
    }
    public function PayrollLoanBulkUpload(Request $request) 
    {  
    
      $validator=$this->validate($request, [
        'file' => 'required',     
       
    ],
    [
        'file.required' => 'You must need to upload the excel file!',    
      
    ]);  
      $exampleImport = new PayrollLoanImport;
      $excel_import=Excel::import($exampleImport, $request->file);
      if($excel_import)
      {
          return back()->with('success','Excel Uploaded successfully!');
      }
      else
      {
          return back()->with('error','Excel Not Uploaded. Please try again later !');
      }   
        
    }
    public function SampleLoanXls()
    {
        $filePath = public_path('Excel_Format\loan.xlsx');
        $fileName = 'LoanBulkUpload.xlsx';

        return response()->download($filePath, $fileName);
    }
    
}
