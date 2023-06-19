<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Master\BloodGroup;
use App\Models\Master\Nationality;
use App\Models\Master\Qualification;
use App\Models\Master\RelationshipType;
use App\Models\Staff\StaffFamilyMember;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StaffFamilyMemberController extends Controller
{
    public function list(Request $request)
    {
        $staff_id = $request->staff_id;
        $member_details = StaffFamilyMember::where('status', 'active')
                                ->where('staff_id', $staff_id)->get();
        $params = array('member_details' => $member_details);

        return view('pages.staff.registration.family.family_list', $params);
    }

    public function save(Request $request)
    {
        
        $id = $request->family_id ?? '';
        $data = '';
        $validator = Validator::make($request->all(), [
                                'staff_relationship_id' => 'required',
                                'family_member_name' => 'required',
                                'dob' => 'required',
                                'gender' => 'required',
                                'age' => 'required',
                                'qualification_id' => 'required',
                                'profession_type' => 'required',
                                'premises' => 'required',
                                'family_contact_no' => 'required', 
                                'relation_register_no' => 'required_if:premises,==,amalarpavam',
                            ]);

        if ($validator->passes()) {
            
            $staff_id = $request->staff_id;

            $ins['academic_id'] = academicYearId();
            $ins['staff_id'] = $staff_id;
            $ins['relation_type_id'] = $request->staff_relationship_id;
            $ins['dob'] = date('Y-m-d', strtotime($request->dob));           
            $ins['first_name'] = $request->family_member_name;           
            $ins['gender'] = $request->gender;           
            $ins['age'] = $request->age;     
            $ins['contact_no']       = $request->family_contact_no;
            $ins['qualification_id'] = $request->qualification_id;           
            $ins['blood_group_id'] = $request->blood_group_id;           
            $ins['nationality_id'] = $request->family_nationality;           
            $ins['premises'] = $request->premises;           
            $ins['remarks'] = $request->family_remarks;           
            $ins['residential_address'] = $request->family_residential_address;           
            $ins['occupational_address'] = $request->occupation_address;           
            $ins['profession'] = $request->profession_type;  
            $ins['other_profession'] = ($request->profession_type == 'others') ? $request->other_profession : null;  
            $ins['registration_no'] = $request->relation_register_no ?? '';         
            $ins['standard'] = $request->relation_standard ?? '';         
            $ins['status'] = 'active';           

            $data = StaffFamilyMember::updateOrCreate(['id' => $id], $ins);
            $error = 0;
            $message = 'Added successfully';
           
        } else {
            $error = 1;
            $message = $validator->errors()->all();
        }
        return response()->json(['error' => $error, 'message' => $message]);
    }

    public function formContent(Request $request)
    {
        $family_id = $request->family_id;

        $info = StaffFamilyMember::where('id', $family_id)->first();

        $relation_types = RelationshipType::where('status', 'active')->get();
        $blood_groups = BloodGroup::where('status', 'active')->get();
        $qualificaiton = Qualification::where('status', 'active')->get();
        $nationalities = Nationality::where('status', 'active')->get();

        $params = array(
            'family_details' => $info,
            'blood_groups' => $blood_groups,
            'qualificaiton' => $qualificaiton,
            'relation_types' => $relation_types,
            'nationalities' => $nationalities
        );
        return view('pages.staff.registration.family.form_content', $params );
    }

    function deleteStaffFamilyMember(Request $request) {

        $family_id = $request->family_id;
        StaffFamilyMember::where('id', $family_id)->delete();
        return response()->json(['error' => 1]);
        
    }
}
