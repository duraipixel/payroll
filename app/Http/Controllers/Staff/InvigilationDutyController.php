<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Staff\StaffInvigilationDuty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InvigilationDutyController extends Controller
{
    public function save(Request $request)
    {
        $id = $request->id ?? '';
        $data = '';
        $validator = Validator::make($request->all(), [
                                'duty_classes' => 'required',
                                'duty_type' => 'required',
                                'other_school' => 'required',
                                'other_place_id' => 'required',
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
            $ins['school_id'] = $request->other_school;
            $ins['school_place_id'] = $request->other_place_id;
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
        return response()->json(['error' => $error, 'message' => $message, 'list' => $data]);
    }
}
