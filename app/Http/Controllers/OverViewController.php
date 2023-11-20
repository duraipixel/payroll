<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Staff\StaffDocument;
use App\Models\Staff\StaffEducationDetail;
use App\Models\Staff\StaffWorkExperience;
use App\Models\Leave\StaffLeave;
use App\Models\Staff\StaffAppointmentDetail;
use App\Models\PayrollManagement\StaffSalary;
use App\Models\CalendarDays;
use App\Models\Staff\StaffBankLoan;
use App\Models\AcademicYear;
use App\Models\AttendanceManagement\AttendanceManualEntry;
use Carbon\Carbon;
class OverViewController extends Controller
{
    public function index()
    {
        $breadcrums = array(
            'title' => 'OverView',
            'breadcrums' => array(
                array(
                    'link' => '', 'title' => 'Account - OverView'
                ),
            )
        );
        $staff_id = Auth::id();
        $info = User::find($staff_id);

        $personal_doc=StaffDocument::where('staff_id',$staff_id)->get();
        $education_doc=StaffEducationDetail::where('staff_id',$staff_id)->get();
        $experince_doc=StaffWorkExperience::where('staff_id',$staff_id)->get();
        $acadamic_id= academicYearId();
        $leave_doc=StaffLeave::where('staff_id',$staff_id)->where('academic_id',$acadamic_id)->get();
        $appointment_doc=StaffAppointmentDetail::where('staff_id',$staff_id)->get();
        $salary_doc=StaffSalary::where('staff_id',$staff_id)->get();

        $from_year=AcademicYear::find(academicYearId());
         academicYearId();
        $year=$from_year->from_year;
        $firstDayOfYear = date("$year-01-01"); 
        $lastDayOfYear = date("$year-12-31");
        $total_year = (strtotime($lastDayOfYear) - strtotime($firstDayOfYear)) / (60 * 60 * 24) + 1;
        $loans=StaffBankLoan::with('emi','paid_emi')->where('staff_id',$staff_id)->where('status','active')->get();
        $working_days=CalendarDays::where('days_type','working_day')->where('academic_id', $acadamic_id)->count();
        $present=AttendanceManualEntry::where('employment_id',$staff_id)->where('academic_id', $acadamic_id)
                ->where('attendance_status', 'Present')->where('status','active')->count();
        $absence=AttendanceManualEntry::where('employment_id',$staff_id)->where('academic_id', $acadamic_id)
                ->where('attendance_status', 'Absence')->where('status','active')->count();
        return view('pages.overview.index',compact('breadcrums', 'info','personal_doc','education_doc','experince_doc',
    'leave_doc','appointment_doc','salary_doc','total_year','loans','working_days','present','absence'));
    }
    public function saveForm(Request $request)
    {   
        $id             = $request->id;
        $validator = Validator::make($request->all(), [
                'old_password' => 'required_if:type,old',
                'password' => 'required|min:6|required_with:password_confirmation|same:password_confirmation',
                'password_confirmation' => 'min:6'
               
        ]);
        if ($validator->passes()) {
            if($request->type=='old'){
                    if ((Hash::check($request->get('old_password'), Auth::user()->password))) {

                    $ins['password']            = Hash::make($request->password);
                    $error = 0;
                    $info = User::updateOrCreate(['id' => $id],$ins);
                    $message = (isset($id) && !empty($id)) ? 'Password updated successfully' :'Added successfully';

                } else {
                    $error = 1;
                    $message = array("Old password dons't match");
                    return response()->json(['error'=> $error, 'message' => $message]);
                }

            }else{

             $ins['password']            = Hash::make($request->password);
                    $error = 0;
                    $info = User::updateOrCreate(['id' => $id],$ins);
                    $message = (isset($id) && !empty($id)) ? 'Password updated successfully' :'Added successfully';
                return response()->json(['error'=> $error, 'message' => $message]);
            
        }
    }else {
                $error = 1;
                $message = $validator->errors()->all();
                return response()->json(['error'=> $error, 'message' => $message]);
            }
            
      
        return response()->json(['error'=> $error, 'message' => $message]);
    }
}
