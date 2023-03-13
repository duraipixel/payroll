<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\TypeOfDuty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DutyTypeController extends Controller
{
    public function save(Request $request)
    {
        $id = $request->id ?? '';
        $data = '';
        $validator = Validator::make($request->all(), [
            'duty_type_name' => 'required|string|unique:type_of_duties,name,' . $id,
        ]);
        
        if ($validator->passes()) {

            $ins['academic_id'] = academicYearId();
            $ins['name'] = $request->duty_type_name;
            $ins['status'] = 'active';
            $data = TypeOfDuty::updateOrCreate(['id' => $id], $ins);
            $error = 0;
            $message = 'Added successfully';

        } else {
            $error = 1;
            $message = $validator->errors()->all();
        }
        return response()->json(['error' => $error, 'message' => $message, 'inserted_data' => $data]);
    }
}
