<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\Qualification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class QualificationController extends Controller
{
    public function save(Request $request)
    {
        $id = $request->id ?? '';
        $data = '';
        $validator      = Validator::make($request->all(), [
            'qualification' => 'required|string|unique:qualifications,name,' . $id,
        ]);
        
        if ($validator->passes()) {

            $ins['academic_id'] = academicYearId();
            $ins['name'] = $request->qualification;
            $ins['status'] = 'active';
            $data = Qualification::updateOrCreate(['id' => $id], $ins);
            $error = 0;
            $message = 'Added successfully';

        } else {

            $error = 1;
            $message = $validator->errors()->all();

        }
        return response()->json(['error' => $error, 'message' => $message, 'inserted_data' => $data]);
    }
}
