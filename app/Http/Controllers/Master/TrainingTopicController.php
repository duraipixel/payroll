<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\TopicTraining;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TrainingTopicController extends Controller
{
    public function save(Request $request)
    {
        $id = $request->id ?? '';
        $data = '';
        $validator = Validator::make($request->all(), [
            'training_topic_name' => 'required|string|unique:topic_trainings,name,' . $id,
        ]);
        
        if ($validator->passes()) {

            $ins['academic_id'] = academicYearId();
            $ins['name'] = $request->training_topic_name;
            $ins['status'] = 'active';
            $data = TopicTraining::updateOrCreate(['id' => $id], $ins);
            $error = 0;
            $message = 'Added successfully';

        } else {
            $error = 1;
            $message = $validator->errors()->all();
        }
        return response()->json(['error' => $error, 'message' => $message, 'inserted_data' => $data]);
    } 
}
