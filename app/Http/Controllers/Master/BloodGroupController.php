<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\BloodGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BloodGroupController extends Controller
{
    public function save(Request $request)
    {
        $id = $request->id ?? '';
        $data = '';
        $validator      = Validator::make($request->all(), [
            'blood_group' => 'required|string|unique:blood_groups,name,' . $id,
        ]);
        
        if ($validator->passes()) {

            $ins['academic_id'] = academicYearId();
            $ins['name'] = $request->blood_group;
            $ins['status'] = 'active';
            $data = BloodGroup::updateOrCreate(['id' => $id], $ins);
            $error = 0;
            $message = 'Added successfully';

        } else {

            $error = 1;
            $message = $validator->errors()->all();

        }
        return response()->json(['error' => $error, 'message' => $message, 'inserted_data' => $data]);
    }
}
