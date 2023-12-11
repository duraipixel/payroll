<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Master\TopicTraining;
use App\Models\Staff\StaffTrainingDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StaffTrainingController extends Controller
{
    public function save(Request $request)
    {
        $id = $request->training_id ?? '';
        $data = '';
        $validator = Validator::make($request->all(), [
                                'from_training_date' => 'required|date|date_format:Y-m-d',
                                'to_training_date' => 'required|date|after_or_equal:from_training_date|date_format:Y-m-d',
                                'trainer_name' => 'required',
                                'training_topic' => 'required',
                                'training_remarks' => 'required'
                            ]);

        if ($validator->passes()) {
            
            $staff_id = $request->staff_id;
            $ins['academic_id'] = academicYearId();
            $ins['staff_id'] = $staff_id;
            $ins['from'] = date('Y-m-d', strtotime($request->from_training_date));
            $ins['to'] = date('Y-m-d', strtotime($request->to_training_date));
            $ins['trainer_name'] = $request->trainer_name;
            $ins['training_topic_id'] = $request->training_topic;
            $ins['remarks'] = $request->training_remarks;
            $ins['status'] = 'active';
            $data = StaffTrainingDetail::updateOrCreate(['id' => $id], $ins);
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
        
        $training_id = $request->training_id;
        $info = StaffTrainingDetail::find($training_id);
        $training_topics = TopicTraining::where('status', 'active')->get();

        $params = array(
                'training_info' => $info,
                'training_topics' => $training_topics
            );
        
        return view('pages.staff.registration.emp_position.training_form_content', $params);
    }

    public function getStaffTrainingList(Request $request)
    {
        $staff_id = $request->staff_id;
        $training_details = StaffTrainingDetail::where('status', 'active')
                                ->where('staff_id', $staff_id)->get();
        $params = array('training_details' => $training_details);

        return view('pages.staff.registration.emp_position.training_list', $params);
    }

    public function deleteStaffTraining(Request $request)
    {
        $training_id = $request->training_id;
        StaffTrainingDetail::where('id', $training_id)->delete();
        return response()->json(['error' => 1]);
    }

}
