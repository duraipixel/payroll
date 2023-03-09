<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\Institution;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class InstitutionController extends Controller
{
    public function save(Request $request)
    {
        
        $id = $request->id ?? '';
        $data = '';
        $validator      = Validator::make($request->all(), [
            'society_id' => 'required',
            'institute_name' => 'required|string|unique:institutions,name,' . $id.',id,deleted_at,NULL',
            'institute_code' => 'required|string|unique:institutions,code,'.$id.',id,deleted_at,NULL',
        ]);
        
        if ($validator->passes()) {
            $ins['academic_id'] = academicYearId();
            $ins['society_id'] = $request->society_id;
            $ins['name'] = $request->institute_name;
            $ins['code'] = $request->institute_code;
            $ins['address'] = $request->address;
            $ins['status'] = 'active';
            $data = Institution::updateOrCreate(['id' => $id], $ins);
            $error = 0;
            $message = 'Added successfully';
            $code = getStaffInstitutionCode($request->institute_code);

        } else {
            $error = 1;
            $message = $validator->errors()->all();
        }
        return response()->json(['error' => $error, 'message' => $message, 'inserted_data' => $data, 'code' => $code ?? '' ]);
    }

    public function getInstituteStaffCode(Request $request)
    {
        $institute_id = $request->institute_id;
        $instituteInfo = Institution::find($institute_id);
        return getStaffInstitutionCode( $instituteInfo->code );
    }
}
