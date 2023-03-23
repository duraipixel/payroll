<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Staff\StaffHealthDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StaffHealthDetailController extends Controller
{
    public function save(Request $request)
    {

        $validator = Validator::make($request->all(), [
                                'medical_blood_group_id' => 'required',
                                'height' => 'required',
                                'weight' => 'required',
                                'identification_mark' => 'required'
                            ]);

        if ($validator->passes()) {
            
            $staff_id = $request->staff_id;
            
            $ins['academic_id'] = academicYearId();
            $ins['staff_id'] = $staff_id;
            $ins['bloodgroup_id'] = $request->medical_blood_group_id;
            $ins['height'] = $request->height;
            $ins['weight'] = $request->weight;
            $ins['identification_mark'] = $request->identification_mark;
            $ins['identification_mark1'] = $request->identification_mark1;
            $ins['identification_mark2'] = $request->identification_mark2;
            $ins['disease_allergy'] = isset($request->allergy) && $request->allergy == 'yes' ? $request->allergy_name : null;
            $ins['differently_abled'] = isset($request->diff_abled) && $request->diff_abled == 'yes' ? $request->abled_name : null;
            $ins['family_doctor_name'] = $request->family_doctor_name;
            $ins['family_doctor_contact_no'] = $request->doctor_contact_no;
            
            StaffHealthDetail::updateOrCreate(['staff_id' => $staff_id], $ins);
            $error = 0;
            $message = 'Added successfully';

        } else {
            $error = 1;
            $message = $validator->errors()->all();
        }
        return response()->json(['error' => $error, 'message' => $message]);
    }
}
