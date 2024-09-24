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
          $data->calendar_date=$request->to_date;
          $data->month=sprintf("%02d", date('m',strtotime($request->from_date)));
          $data->acadamic_id=$acadamic->id;
          if($data->save()){
          $error = 0;
          $message = ['CalenderYear updated successfully'];
          return response()->json(['error' => $error, 'message' => $message]);
          }

        }else{
        $acadamic=AcademicYear::where('is_current',1)->first();
        $mapping=StaffLeaveMapping::where('acadamic_id',$acadamic->id)->first();
        $calender=CalenderYear::orderBy('id','desc')->first();
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
                   return ($row->academicYaer !=null)? $row->academicYaer->from_year : '';
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
            $acadamic=AcademicYear::find($info->acadamic_id);
            $leave_datas=StaffLeave::where('staff_id',$info->staff_id)->where('leave_category','Earned Leave')->where('leave_category_id',2)
            ->where(function($query) use ($acadamic) {
              $query->whereYear('from_date', $acadamic->from_year)
                    ->orWhereYear('to_date', $acadamic->from_year);
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
     public function AutoloadEntryLeave(Request $request)
    {
        
            ini_set("max_execution_time", 0);
            $users = User::where("status", "active")->get();
            foreach ($users as $user) {
              $years = [];
              if (isset($user->firstAppointment)) {
                $years = getYearsBetween(
                  date(
                    "Y",
                    strtotime($user->firstAppointment->from_appointment)
                  ),
                  date("Y")
                );
              }
              if (
                count($years) > 0 &&
                isset($user->firstAppointment) &&
                isset($user->firstAppointment->leaveAllocated) &&
                count($user->firstAppointment->leaveAllocated) > 0
              ) {
        
                foreach ($years as $year) {
                  $acadamic_id = AcademicYear::where(
                    "from_year",
                    $year
                  )->first();
                  $calender_id = CalenderYear::where("year", $year)->first();
                  if (isset($acadamic_id)) {
                    foreach (
                      $user->firstAppointment->leaveAllocated
                      as $leaveAllocated
                    ) {
                      if($leaveAllocated->teaching_type==$user->firstAppointment->teaching_type_id){
                      $new["staff_id"] = $user->id;
                      $new["leave_head_id"] =
                      $leaveAllocated->leave_head_id;
                      $new["no_of_leave_actual"] =
                      $leaveAllocated->leave_days;
                      if (
                        $leaveAllocated->carry_forward == "yes" &&
                        $leaveAllocated->leave_head_id == 2
                      ) {
                        $previous_data = StaffLeaveMapping::where(
                          "staff_id",
                          $user->id
                        )
                        ->where("leave_head_id",2)
                        ->where("calender_id", $calender_id->id - 1)
                        ->first();
                    
                        $total = leaveData(
                          $user->id,
                          $year,
                          "Earned Leave"
                        );
                        $manual_entry = StaffELEntry::where(
                          "staff_id",
                          $user->id
                        )
                        ->where("academic_id", $acadamic_id->id)
                        ->select(
                          DB::raw("SUM(leave_days) as total_days")
                        )
                        ->first();
                        if ($previous_data) {
        
                          $new["carry_forward_count"] =
                          $previous_data->carry_forward_count +
                          $leaveAllocated->leave_days -
                          $total -
                          $manual_entry->total_days;
                          $new["accumulated"] =
                          (int) $previous_data->carry_forward_count +
                          $leaveAllocated->leave_days;
                        } else {
                          $new["carry_forward_count"] =
                          $leaveAllocated->leave_days -
                          $total -
                          $manual_entry->total_days;
                          $new["accumulated"] =
                          (int) $leaveAllocated->leave_days;
                        }
                        $new["availed"] =
                        (int) $total +
                        (int) $manual_entry->total_days;
                      } else {
                        $new["carry_forward_count"] = 0;
                      }
                      $new["no_of_leave"] = $leaveAllocated->leave_days;
        
                      $new["acadamic_id"] = $acadamic_id->id;
                      $new["calender_id"] = $calender_id->id;
                      StaffLeaveMapping::updateOrCreate(
                        [
                          "staff_id" => $user->id,
                          "acadamic_id" => $acadamic_id->id,
                          "leave_head_id" =>
                          $leaveAllocated->leave_head_id,
                        ],
                        $new
                      );
                    }
                  }
                  }
                }
              }
            }
            return true;
            
    } 
    public function UserAutoloadEntryLeave($user_id)
    {
      ini_set("max_execution_time", 0);
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
          if (
            isset($user->firstAppointment) &&
            isset($user->firstAppointment->leaveAllocated) &&
            count($user->firstAppointment->leaveAllocated) > 0 &&
            isset($acadamic_id)
          ) {
            foreach (
              $user->firstAppointment->leaveAllocated
              as $leaveAllocated
            ) {
              if($leaveAllocated->teaching_type==$user->firstAppointment->teaching_type_id){
              $new["staff_id"] = $user->id;
              $new["leave_head_id"] = $leaveAllocated->leave_head_id;
              $new["no_of_leave_actual"] =
              $leaveAllocated->leave_days;
              if (
                $leaveAllocated->carry_forward == "yes" &&
                $leaveAllocated->leave_head_id == 2
              ) {
                $previous_data = StaffLeaveMapping::where(
                  "staff_id",
                  $user->id
                )->where("leave_head_id",2)
                ->where("calender_id", $calender_id->id - 1)
                ->first();
                $total = leaveData(
                  $user->id,
                  $year,
                  "Earned Leave"
                );
                $manual_entry = StaffELEntry::where(
                  "staff_id",
                  $user->id
                )
                ->where("academic_id", $acadamic_id->id)
                ->select(
                  DB::raw("SUM(leave_days) as total_days")
                )
                ->first();
                if ($previous_data) {
                  $new["carry_forward_count"] =
                  $previous_data->carry_forward_count +
                  $leaveAllocated->leave_days -
                  $total -
                  $manual_entry->total_days;
                  $new["accumulated"] =
                  (int) $previous_data->carry_forward_count +
                  $leaveAllocated->leave_days ??
                  0;
                } else {
                  $new["carry_forward_count"] =
                  $leaveAllocated->leave_days -
                  $total -
                  $manual_entry->total_days;
                  $new["accumulated"] =
                  (int) $leaveAllocated->leave_days ?? 0;
                }
                $new["availed"] =
                (int) $total +
                (int) $manual_entry->total_days ??
                0;
              } else {
                $new["carry_forward_count"] = 0;
              }
              $new["no_of_leave"] = $leaveAllocated->leave_days;
  
              $new["acadamic_id"] = $acadamic_id->id;
              $new["calender_id"] = $calender_id->id;
              StaffLeaveMapping::updateOrCreate(
                [
                  "staff_id" => $user->id,
                  "acadamic_id" => $acadamic_id->id,
                   "leave_head_id" =>
                    $leaveAllocated->leave_head_id,
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
    public function UserELEntryLeave($user_id)
    {
        
      ini_set("max_execution_time", 0);
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
          if (
            isset($user->firstAppointment) &&
            isset($user->firstAppointment->leaveAllocated) &&
            count($user->firstAppointment->leaveAllocated) > 0 &&
            isset($acadamic_id)
          ) {
            foreach (
              $user->firstAppointment->leaveAllocated
              as $leaveAllocated
            ) {
              if($leaveAllocated->teaching_type==$user->firstAppointment->teaching_type_id){
              $new["staff_id"] = $user->id;
              $new["leave_head_id"] = $leaveAllocated->leave_head_id;
              $new["no_of_leave_actual"] =
              $leaveAllocated->leave_days;
              if (
                $leaveAllocated->carry_forward == "yes" &&
                $leaveAllocated->leave_head_id == 2
              ) {
                $previous_data = StaffLeaveMapping::where(
                  "staff_id",
                  $user->id
                )->where("leave_head_id",2)
                ->where("calender_id", $calender_id->id - 1)
                ->first();
                $total = leaveData(
                  $user->id,
                  $year,
                  "Earned Leave"
                );
                $manual_entry = StaffELEntry::where(
                  "staff_id",
                  $user->id
                )
                ->where("academic_id", $acadamic_id->id)
                ->select(
                  DB::raw("SUM(leave_days) as total_days")
                )
                ->first();
                if ($previous_data) {
                  $new["carry_forward_count"] =
                  $previous_data->carry_forward_count +
                  $leaveAllocated->leave_days -
                  $total -
                  $manual_entry->total_days;
                  $new["accumulated"] =
                  (int) $previous_data->carry_forward_count +
                  $leaveAllocated->leave_days ??
                  0;
                } else {
                  $new["carry_forward_count"] =
                  $leaveAllocated->leave_days -
                  $total -
                  $manual_entry->total_days;
                  $new["accumulated"] =
                  (int) $leaveAllocated->leave_days ?? 0;
                }
                $new["availed"] =
                (int) $total +
                (int) $manual_entry->total_days ??
                0;
              } else {
                $new["carry_forward_count"] = 0;
              }
              $new["no_of_leave"] = $leaveAllocated->leave_days;
  
              $new["acadamic_id"] = $acadamic_id->id;
              $new["calender_id"] = $calender_id->id;
              StaffLeaveMapping::updateOrCreate(
                [
                  "staff_id" => $user->id,
                  "acadamic_id" => $acadamic_id->id,
                   "leave_head_id" =>
                    $leaveAllocated->leave_head_id,
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
    public function UserEntrylevelLeave($user_id,$nature_id)
    {
        
      ini_set("max_execution_time", 0);
      $user = User::with(['TeachingAppointment' => function ($query) use ($nature_id) {
        $query->where('nature_of_employment_id',$nature_id);
        }])->find($user_id);
      $years = [];
      if (isset($user->TeachingAppointment)) {
        $years = getYearsBetween(
          date("Y", strtotime($user->TeachingAppointment->from_appointment)),
          date("Y")
        );
      }
      if (count($years) > 0) {
        foreach ($years as $year) {
          $acadamic_id = AcademicYear::where("from_year", $year)->first();
          $calender_id = CalenderYear::where("year", $year)->first();
       
          if (
            isset($user->TeachingAppointment) &&
            isset($user->TeachingAppointment->leaveAllocated) &&
            count($user->TeachingAppointment->leaveAllocated) > 0 &&
            isset($acadamic_id)
          ) {
            foreach (
              $user->TeachingAppointment->leaveAllocated
              as $leaveAllocated
            ) {
              if($user->TeachingAppointment->teaching_type_id){
              $new["staff_id"] = $user->id;
              $new["leave_head_id"] = $leaveAllocated->leave_head_id;
              $new["no_of_leave_actual"] =
              $leaveAllocated->leave_days;
              if (
                $leaveAllocated->carry_forward == "yes" &&
                $leaveAllocated->leave_head_id == 2
              ) {
                $previous_data = StaffLeaveMapping::where(
                  "staff_id",
                  $user->id
                )->where("leave_head_id",2)
                ->where("calender_id", $calender_id->id - 1)
                ->first();
                $total = leaveData(
                  $user->id,
                  $year,
                  "Earned Leave"
                );
                $manual_entry = StaffELEntry::where(
                  "staff_id",
                  $user->id
                )
                ->where("academic_id", $acadamic_id->id)
                ->select(
                  DB::raw("SUM(leave_days) as total_days")
                )
                ->first();
                $leaveAllocated_days=$leaveAllocated->leave_days/2;
                if ($previous_data) {
                  $new["carry_forward_count"] =
                  $previous_data->carry_forward_count +
                  $leaveAllocated_days - 
                  $total -
                  $manual_entry->total_days;
                  $new["accumulated"] =
                  (int) $previous_data->carry_forward_count +
                  $leaveAllocated_days ??
                  0;
                } else {
                  $new["carry_forward_count"] =
                  $leaveAllocated_days -
                  $total -
                  $manual_entry->total_days;
                  $new["accumulated"] =
                  (int) $leaveAllocated_days ?? 0;
                }
                $new["availed"] =
                (int) $total +
                (int) $manual_entry->total_days ??
                0;
              } else {
                $new["carry_forward_count"] = 0;
              }
              $leaveAllocated_days=$leaveAllocated->leave_days/2;
              $new["no_of_leave"] = $leaveAllocated_days;
  
              $new["acadamic_id"] = $acadamic_id->id;
              $new["calender_id"] = $calender_id->id;
              StaffLeaveMapping::updateOrCreate(
                [
                  "staff_id" => $user->id,
                  "acadamic_id" => $acadamic_id->id,
                   "leave_head_id" =>
                    $leaveAllocated->leave_head_id,
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
        ini_set('max_execution_time', 0);
         $users=User::where('status','active')->get();
         // $leave_mapping=StaffLeaveMapping::where('staff_id',$id)->where('acadamic_id',academicYearId())->get();
        foreach($users as $user){
        $acadamic_id=AcademicYear::where('from_year',$year)->first();
            $calender_id=CalenderYear::where('year',$year)->first();
        if(isset($user->appointment) && isset($user->appointment->leaveAllocated) && count($user->appointment->leaveAllocated)>0 && isset($acadamic_id)){
        foreach($user->appointment->leaveAllocated as $leaveAllocated){
            $new['staff_id']=$user->id;
            $new['leave_head_id']=$leaveAllocated->leave_head_id;
            $new['no_of_leave_actual']=$leaveAllocated->leave_days;
            if($leaveAllocated->carry_forward=='yes' && $leaveAllocated->leave_head_id==2){
    $previous_data=StaffLeaveMapping::where('staff_id', $user->id)->where('calender_id',$calender_id->id-1)->first();
    $total=leaveData($user->id,$year,'Earned Leave');
    $manual_entry=StaffELEntry::where('staff_id',$user->id)->where('academic_id',$acadamic_id->id)->select(DB::raw('SUM(leave_days) as total_days'))->first();
            if($previous_data){

              $new['carry_forward_count']=$previous_data->carry_forward_count+$leaveAllocated->leave_days-$total-$manual_entry->total_days;
              $new['accumulated']=(int)$previous_data->carry_forward_count+$leaveAllocated->leave_days??0;
            }else{
            $new['carry_forward_count']=$leaveAllocated->leave_days-$total-$manual_entry->total_days;
            $new['accumulated']=(int) $leaveAllocated->leave_days??0;
            }
            $new['availed']=(int) $total +(int) $manual_entry->total_days ??0;
            }else{
            $new['carry_forward_count']=0;
            }
            $new['no_of_leave']=$leaveAllocated->leave_days;
           
            $new['acadamic_id']=$acadamic_id->id;
            $new['calender_id']=$calender_id->id;
             StaffLeaveMapping::updateOrCreate(['staff_id'=>$user->id,'acadamic_id'=>$acadamic_id->id], $new);
            }
           } 
        }
       return true;
    } 
    public function TestELEntry($user_id)
    {
        
      ini_set("max_execution_time", 0);
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
          $entry=getStaffAppointment($user->id,$year);
           if(isset($entry)){
            $entry_value=appointmentLaeve($entry['id']);
            if(isset($entry_value)){
              foreach (
                $entry_value
                as $leaveAllocated
              ) {
              $appointment=StaffAppointmentDetail::find($entry['id']);
              $new["staff_id"] = $user->id;
              $new["leave_head_id"] = $leaveAllocated->leave_head_id;
              $new["no_of_leave_actual"] =
              $leaveAllocated->leave_days;
              if (
                $leaveAllocated->carry_forward == "yes" &&
                $leaveAllocated->leave_head_id == 2
              ) {
                $previous_data = StaffLeaveMapping::where(
                  "staff_id",
                  $user->id
                )->where("leave_head_id",2)
                ->where("calender_id", $calender_id->id - 1)
                ->first();
                $total = leaveData(
                  $user->id,
                  $year,
                  "Earned Leave"
                );
                $manual_entry = StaffELEntry::where(
                  "staff_id",
                  $user->id
                )
                ->where("academic_id", $acadamic_id->id)
                ->select(
                  DB::raw("SUM(leave_days) as total_days")
                )
                ->first();
                if ($previous_data) {
                  $data_p = StaffLeaveMapping::where(
                    "staff_id",
                    $user->id
                  )->where("leave_head_id",2)
                  ->where("calender_id", $calender_id->id)
                  ->first();
               
                  if(isset($data_p) && (int)$leaveAllocated->leave_days != (int)$data_p->no_of_leave){
                    $leave_total=$data_p->no_of_leave;
                  }else{
                    $leave_total=$leaveAllocated->leave_days;
                  }
                  $new["carry_forward_count"] =
                  $previous_data->carry_forward_count +
                  $leave_total -
                  $total -
                  $manual_entry->total_days;
                  $new["accumulated"] =
                  (int) $previous_data->carry_forward_count +
                  $leave_total ??
                  0;
                  $new["no_of_leave"] = $leave_total;
                } else {
                  
                  $data_p = StaffLeaveMapping::where(
                    "staff_id",
                    $user->id
                  )->where("leave_head_id",2)
                  ->where("calender_id", $calender_id->id)
                  ->first();
                  if(isset($data_p) &&  (int)$leaveAllocated->leave_days !=  (int)$data_p->no_of_leave){
                    $n_leave_days=$data_p->no_of_leave;
                  }else{
                    $n_leave_days=$leaveAllocated->leave_days;
                  }
                  $new["carry_forward_count"] =
                  $n_leave_days -
                  $total -
                  $manual_entry->total_days;
                  $new["accumulated"] =
                  (int) $n_leave_days ?? 0;
                   $new["no_of_leave"] = $n_leave_days;
                }
                $new["availed"] =
                (int) $total +
                (int) $manual_entry->total_days ??
                0;
               
               
              } else {
                $new["carry_forward_count"] = 0;
              }
             
  
              $new["acadamic_id"] = $acadamic_id->id;
              $new["calender_id"] = $calender_id->id;
              StaffLeaveMapping::updateOrCreate(
                [
                  "staff_id" => $user->id,
                  "acadamic_id" => $acadamic_id->id,
                   "leave_head_id" =>
                    $leaveAllocated->leave_head_id,
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
          if (
            isset($user->firstAppointment) &&
            isset($year) > 0 &&
            isset($acadamic_id)
          ) {
            $entry=getStaffAppointment($user->id,$year);
           if(isset($entry)){
            $entry_value=appointmentLaeve($entry['id']);
            if(isset($entry_value)){
              foreach (
                $entry_value
                as $leaveAllocated
              ) {
                $appointment=StaffAppointmentDetail::find($entry['id']);
                $new["staff_id"] = $user->id;
                $new["leave_head_id"] = $leaveAllocated->leave_head_id;
                $new["no_of_leave_actual"] =
                $leaveAllocated->leave_days;
                if (
                  $leaveAllocated->carry_forward == "yes" &&
                  $leaveAllocated->leave_head_id == 2
                ) {
                
                  $previous_data = StaffLeaveMapping::where(
                    "staff_id",
                    $user->id
                  )->where("leave_head_id",2)
                  ->where("calender_id", $calender_id->id - 1)
                  ->first();
                  
                  $total = leaveData(
                    $user->id,
                    $year,
                    "Earned Leave"
                  );
                  $manual_entry = StaffELEntry::where(
                    "staff_id",
                    $user->id
                  )
                  ->where("academic_id", $acadamic_id->id)
                  ->select(
                    DB::raw("SUM(leave_days) as total_days")
                  )
                  ->first();
                  if ($previous_data) {
                    
                    $data_p = StaffLeaveMapping::where(
                      "staff_id",
                      $user->id
                    )->where("leave_head_id",2)
                    ->where("calender_id", $calender_id->id)
                    ->first();
                    if(getStaffAppointmentYear($year,$user->id)==1){
                      $month=Carbon::parse($appointment->from_appointment)->month;
                      $division=getStaffMonthSeprate($month);
                       if(isset($division) && !empty($division)){
                        $leave_total=$leaveAllocated->leave_days/$division;
                       }else{
                          $leave_total=$leaveAllocated->leave_days;
                       }
                      }
                    else{
                      $leave_total=$leaveAllocated->leave_days;
                    }
                    $new["carry_forward_count"] =
                    $previous_data->carry_forward_count +
                    $leave_total -
                    $total -
                    $manual_entry->total_days;
                    $new["accumulated"] =
                    (int) $previous_data->carry_forward_count +
                    $leave_total ??
                    0;
                    $new["no_of_leave"] = $leave_total;
                  } else {
                   
                    $data_p = StaffLeaveMapping::where(
                      "staff_id",
                      $user->id
                    )->where("leave_head_id",2)
                    ->where("calender_id", $calender_id->id)
                    ->first();
                      $month=Carbon::parse($appointment->from_appointment)->month;
                      $division=getStaffMonthSeprate($month);
                      if(isset($division) && !empty($division)){
                       $n_leave_days =$leaveAllocated->leave_days/$division;
                      }else{
                        $n_leave_days =$leaveAllocated->leave_days;
                      }
                    $new["carry_forward_count"] =
                    $n_leave_days -
                    $total -
                    $manual_entry->total_days;
                    $new["accumulated"] =
                    (int) $n_leave_days ?? 0;
                     $new["no_of_leave"] = $n_leave_days;
                  }
                  $new["availed"] =
                  (int) $total +
                  (int) $manual_entry->total_days ??
                  0;
                 
                 
                } else {
                  $new["carry_forward_count"] = 0;
                  $month=Carbon::parse($appointment->from_appointment)->month;
                  if($month >= 1 && $month <= 6){
                        $new["no_of_leave"]=$leaveAllocated->leave_days;
                        $new["accumulated"] =$leaveAllocated->leave_days;
                  }else{
                        $new["no_of_leave"]=$leaveAllocated->leave_days/2;
                        $new["accumulated"] =$leaveAllocated->leave_days/2;
                  }
                     
                }
               
    
                $new["acadamic_id"] = $acadamic_id->id;
                $new["calender_id"] = $calender_id->id;
                
                StaffLeaveMapping::updateOrCreate(
                  [
                    "staff_id" => $user->id,
                    "acadamic_id" => $acadamic_id->id,
                    "calender_id"=>$calender_id->id,
                    "leave_head_id" =>$leaveAllocated->leave_head_id,
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
        'file' => 'required|mimes:xlsx, xls',     
       
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
}
