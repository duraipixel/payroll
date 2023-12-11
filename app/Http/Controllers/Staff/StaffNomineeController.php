<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Staff\StaffFamilyMember;
use App\Models\Staff\StaffNominee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StaffNomineeController extends Controller
{
    public function getStaffNominee(Request $request)
    {

        $staff_id = $request->staff_id;
        return StaffFamilyMember::where('status', 'active')->where('staff_id', $staff_id)->get();

    }

    public function getStaffNomineeInfo(Request $request)
    {
        $nominee_id = $request->nominee_id;
        return StaffFamilyMember::with('relationship')->find($nominee_id);
    }

    public function save(Request $request)
    {

        $id     = $request->staff_nominee_id ?? '';
        $validator = Validator::make($request->all(), [
                                'nominee_id' => 'required|unique:staff_nominees,nominee_id,'.$id,
                                'nominee_age' => 'required|integer',
                                'share' => 'required',
                                // 'minor_name' => 'required_if:nominee_age,<,18',
                                // 'minor_contact' => 'required_if:nominee_age,<,18',
                                // 'minor_address' => 'required_if:nominee_age,<,18',
                            ]);

        if ($validator->passes()) {

            $staff_id = $request->staff_id;
            $nominee_info = StaffFamilyMember::find($request->nominee_id);
            
            $ins['academic_id'] = academicYearId();
            $ins['staff_id'] = $staff_id;
            $ins['nominee_id'] = $request->nominee_id;
            $ins['relationship_type_id'] = $nominee_info->relation_type_id;
            $ins['dob'] = $nominee_info->dob;
            $ins['gender'] = $nominee_info->gender;
            $ins['age'] = $request->nominee_age;
            $ins['minor_name'] = $request->minor_name ?? '';
            $ins['share'] = $request->share;
            $ins['minor_address'] = $request->minor_address ?? '';
            $ins['minor_contact_no'] = $request->minor_contact ?? '';
            
            StaffNominee::updateOrCreate(['id' => $id], $ins);
            $error = 0;
            $message = 'Added successfully';

        } else {
            $error = 1;
            $message = $validator->errors()->all();
        }
        return response()->json(['error' => $error, 'message' => $message]);
    }

    public function list(Request $request)
    {
        $staff_id = $request->staff_id;
        $nominee_details = StaffNominee::where('staff_id', $staff_id)->get();
        $params = array('nominee_details' => $nominee_details);

        return view('pages.staff.registration.nominee.nominee_list', $params);
    }

    public function formContent(Request $request)
    {

        $nominee_id = $request->nominee_id;
        $nominee_info = StaffNominee::find($nominee_id);

        StaffFamilyMember::where('status', 'active')->where('staff_id', $nominee_info->staff_id)->get();

        $params = array(
            'nominee_info' => $nominee_info
        );
        return view('pages.staff.registration.nominee.form_content', $params );

    }

    function deleteStaffNominee(Request $request) {

        $nominee_id = $request->nominee_id;
        StaffNominee::where('id', $nominee_id)->delete();
        return response()->json(['error' => 1]);
        
    }

}
