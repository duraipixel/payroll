<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Staff\StaffMedicalRemark;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class StaffMedicalRemarkController extends Controller
{
    public function save(Request $request)
    {
        $id = $request->medical_remark_id ?? '';
        $validator = Validator::make($request->all(), [
                                'medic_remark_date' => 'required',
                                'remark_reason' => 'required'
                            ]);

        if ($validator->passes()) {
            
            $staff_id = $request->staff_id;
            $staff_info = User::find($staff_id);
            
            $ins['academic_id'] = academicYearId();
            $ins['staff_id'] = $staff_id;
            $ins['medic_date'] = date('Y-m-d', strtotime($request->medic_remark_date));
            $ins['reason'] = $request->remark_reason;

            if ($request->hasFile('medic_file')) {
    
                $files = $request->file('medic_file');
                $imageName = uniqid() . Str::replace(' ', "-", $files->getClientOriginalName());

                $directory = 'staff/' . $staff_info->emp_code . '/medic_remarks';
                $filename  = $directory . '/' . $imageName;

                Storage::disk('public')->put($filename, File::get($files));
                $ins['medic_documents'] = $filename;
            }
            
            StaffMedicalRemark::updateOrCreate(['id' => $id], $ins);
            $error = 0;
            $message = 'Added successfully';

        } else {
            $error = 1;
            $message = $validator->errors()->all();
        }
        return response()->json(['error' => $error, 'message' => $message]);
    }

    public function list(Request $request)
    {

        $staff_id = $request->staff_id;
        $medical_remarks = StaffMedicalRemark::where('staff_id', $staff_id)->get();
        return view('pages.staff.registration.medical_remarks.list', compact('medical_remarks'));

    }

    public function formContent(Request $request)
    {
        $remark_id = $request->remark_id;
        $remark_info = StaffMedicalRemark::find($remark_id);
       

        $params = array(
            'remark_info' => $remark_info
        );
        return view('pages.staff.registration.medical_remarks.form_content', $params);
    }

    public function deleteStaffMedcialRemarks(Request $request)
    {
        $remark_id = $request->remark_id;
        StaffMedicalRemark::where('id', $remark_id)->delete();
        return response()->json(['error' => 1]);
    }

}
