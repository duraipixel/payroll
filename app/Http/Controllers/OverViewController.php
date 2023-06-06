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
        $staff_id = auth()->user()->id;
        $info = User::find($staff_id);

        $personal_doc=StaffDocument::where('staff_id',$staff_id)->get();
        $education_doc=StaffEducationDetail::where('staff_id',$staff_id)->get();
        $experince_doc=StaffWorkExperience::where('staff_id',$staff_id)->get();
        $acadamic_id= academicYearId();
        $leave_doc=StaffLeave::where('staff_id',$staff_id)->where('academic_id',$acadamic_id)->get();
        $appointment_doc=StaffAppointmentDetail::where('staff_id',$staff_id)->get();
        $salary_doc=StaffSalary::where('staff_id',$staff_id)->get();
        return view('pages.overview.index',compact('breadcrums', 'info','personal_doc','education_doc','experince_doc',
    'leave_doc','appointment_doc','salary_doc'));
    }
    public function saveForm(Request $request)
    {
        $id             = $request->id;
            $validator = Validator::make($request->all(), [
                'old_password' => 'required',
                'password' => 'required|min:6|required_with:password_confirmation|same:password_confirmation',
                'password_confirmation' => 'min:6'
               
            ]);
            if ($validator->passes()) {
                
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

            } else {
                $error = 1;
                $message = $validator->errors()->all();
                return response()->json(['error'=> $error, 'message' => $message]);
            }
      
        return response()->json(['error'=> $error, 'message' => $message]);
    }
}
