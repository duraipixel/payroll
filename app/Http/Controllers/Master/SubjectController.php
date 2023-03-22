<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\Classes;
use App\Models\Master\Subject;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubjectController extends Controller
{
    public function save(Request $request)
    {
        $id = $request->id ?? '';
        $data = '';
        $validator      = Validator::make($request->all(), [
            'subject_name' => 'required|string|unique:subjects,name,' . $id,
        ]);
        
        if ($validator->passes()) {
            $ins['academic_id'] = academicYearId();
            $ins['name'] = $request->subject_name;
            $ins['status'] = 'active';
            $data = Subject::updateOrCreate(['id' => $id], $ins);
            $error = 0;
            $message = 'Added successfully';

        } else {
            $error = 1;
            $message = $validator->errors()->all();
        }
        return response()->json(['error' => $error, 'message' => $message, 'inserted_data' => $data]);
    }

    public function getSubjectStudied(Request $request)
    {
        $classes = Classes::where('status', 'active')->get();
        $subjects = Subject::where('status', 'active')->get();
        $staff_id = $request->staff_id;
        $staff_details = User::find($staff_id);
        $params = array(
            'classes' => $classes,
            'subjects' => $subjects,
            'staff_details' => $staff_details
        );
        return view('pages.staff.registration.emp_position.studied_subject_pane', $params);
    }
}
