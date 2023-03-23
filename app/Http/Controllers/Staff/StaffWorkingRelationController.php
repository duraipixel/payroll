<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Master\RelationshipType;
use App\Models\Staff\StaffWorkingRelation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StaffWorkingRelationController extends Controller
{
    public function save(Request $request)
    {
        $id = $request->relation_working_id ?? '';
        $data = '';
        $validator = Validator::make($request->all(), [
                                'working_relation_id' => 'required|unique:staff_working_relations,belonger_id,'.$id,
                                'working_relationship_type_id' => 'required',
                                'working_emp_code' => 'required',
                                'working_institute_id' => 'required'
                            ]);

        if ($validator->passes()) {
            
            $staff_id = $request->staff_id;
            $ins['academic_id'] = academicYearId();
            $ins['staff_id'] = $staff_id;
            $ins['types'] = 'staff';
            $ins['belonger_id'] = $request->working_relation_id;
            $ins['belonger_code'] = $request->working_emp_code;
            $ins['relationship_type_id'] = $request->working_relationship_type_id;
            $ins['status'] = 'active';
            $data = StaffWorkingRelation::updateOrCreate(['id' => $id], $ins);

            $error = 0;
            $message = 'Added successfully';
           
        } else {
            $error = 1;
            $message = $validator->errors()->all();
        }
        return response()->json(['error' => $error, 'message' => $message]);
    }

    public function staffWorkingList(Request $request)
    {
        $staff_id = $request->staff_id;

        $working_details = StaffWorkingRelation::where('status', 'active')
                                ->where('staff_id', $staff_id)->get();

        $params = array('working_details' => $working_details);

        return view('pages.staff.registration.relation_working.list', $params);
    }

    public function formContent(Request $request)
    {
        $working_id = $request->working_id;
        $working_info = StaffWorkingRelation::find($working_id);
        $relation_types = RelationshipType::where('status', 'active')->get();
        $id = $working_info->staff_id;
        $other_staff = User::with('institute')->where('status', 'active')
                        ->where('is_super_admin', null)
                        ->when($id != null, function($q) use($id){
                            $q->where('id', '!=', $id);
                        })
                        ->get();

        $params = array(
            'working_info' => $working_info,
            'other_staff' => $other_staff,
            'relation_types' => $relation_types
        );
        return view('pages.staff.registration.relation_working.form_content', $params);
    }

    public function deleteStaffWorkingRelation(Request $request)
    {
        $working_id = $request->working_id;
        StaffWorkingRelation::where('id', $working_id)->delete();
        return response()->json(['error' => 1]);
    }
}
