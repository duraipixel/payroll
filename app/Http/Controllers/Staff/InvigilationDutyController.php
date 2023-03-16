<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Master\DutyClass;
use App\Models\Master\OtherSchool;
use App\Models\Master\OtherSchoolPlace;
use App\Models\Master\TypeOfDuty;
use App\Models\Staff\StaffInvigilationDuty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InvigilationDutyController extends Controller
{
    public function save(Request $request)
    {
        $id = $request->duty_id ?? '';
        $data = '';
        $validator = Validator::make($request->all(), [
                                'duty_classes' => 'required',
                                'duty_type' => 'required',
                                'duty_other_school' => 'required',
                                'duty_other_place_id' => 'required',
                                'inv_from_date' => 'required',
                                'inv_to_date' => 'required',
                                'facility' => 'required',
                            ]);

        if ($validator->passes()) {
            
            $staff_id = $request->staff_id;
            $ins['academic_id'] = academicYearId();
            $ins['staff_id'] = $staff_id;
            $ins['class_id'] = $request->duty_classes;
            $ins['type_of_duty_id'] = $request->duty_type;
            $ins['school_id'] = $request->duty_other_school;
            $ins['school_place_id'] = $request->duty_other_place_id;
            $ins['from_date'] = date('Y-m-d', strtotime($request->inv_from_date));
            $ins['to_date'] = date('Y-m-d', strtotime($request->inv_to_date));
            $ins['facility'] = $request->facility;
            $ins['status'] = 'active';
            $data = StaffInvigilationDuty::updateOrCreate(['id' => $id], $ins);
            $error = 0;
            $message = 'Added successfully';

           

           
        } else {
            $error = 1;
            $message = $validator->errors()->all();
        }
        return response()->json(['error' => $error, 'message' => $message, 'list' => $list ?? '']);
    }

    public function formContent(Request $request)
    {
        
        $duty_id = $request->duty_id;
        $info = StaffInvigilationDuty::find($duty_id);
        $duty_classes = DutyClass::where('status', 'active')->get();
        $duty_types = TypeOfDuty::where('status', 'active')->get();
        $other_schools = OtherSchool::where('status', 'active')->get();
        $places = OtherSchoolPlace::where('status', 'active')->get();

        $params = array(
                'duty_info' => $info,
                'duty_classes' => $duty_classes,
                'duty_types' => $duty_types,
                'other_schools' => $other_schools,
                'places' => $places
            );
        
        return view('pages.staff.registration.emp_position.invigilation_form_content', $params);

    }

    public function getStaffInvigilationList(Request $request)
    {
        $staff_id = $request->staff_id;
        $invigilation_details = StaffInvigilationDuty::where('status', 'active')
                                ->where('staff_id', $staff_id)->get();
        $params = array('invigilation_details' => $invigilation_details);

        return view('pages.staff.registration.emp_position.invigilation_list', $params);
    }

    public function deleteStaffInvigilation(Request $request)
    {
        $duty_id = $request->duty_id;
        StaffInvigilationDuty::where('id', $duty_id)->delete();

        return response()->json(['error' => 1]);

    }
}
