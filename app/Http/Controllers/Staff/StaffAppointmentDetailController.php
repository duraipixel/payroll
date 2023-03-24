<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Staff\StaffAppointmentDetail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Filesystem\Filesystem;


class StaffAppointmentDetailController extends Controller
{
    public function save(Request $request)
    {
        $validator      = Validator::make($request->all(), [
            'staff_category_id' => 'required',
            'nature_of_employment_id' => 'required',
            'teaching_type_id' => 'required',
            'place_of_work_id' => 'required',
            'joining_date' => 'required',
            'salary_scale' => 'required',
            'from_appointment' => 'required',
            'to_appointment' => 'required',
            'appointment_order_model_id' => 'required',
            'probation_period' => 'required_if:probation, ==,yes',

        ]);

        if ($validator->passes()) {

            $academic_id = academicYearId();
            $staff_id = $request->staff_id;
            $staff_info = User::find($staff_id);

            $ins['academic_id'] = $academic_id;
            $ins['staff_id'] = $staff_id;
            $ins['category_id'] = $request->staff_category_id;
            $ins['nature_of_employment_id'] = $request->nature_of_employment_id;
            $ins['teaching_type_id'] = $request->teaching_type_id;
            $ins['place_of_work_id'] = $request->place_of_work_id;
            $ins['joining_date'] = date('Y-m-d', strtotime($request->joining_date));
            $ins['salary_scale'] = $request->salary_scale;
            $ins['from_appointment'] = date('Y-m-d', strtotime($request->from_appointment));
            $ins['to_appointment'] = date('Y-m-d', strtotime($request->to_appointment));;
            $ins['appointment_order_model_id'] = $request->appointment_order_model_id;
            $ins['has_probation'] = $request->probation;
            $ins['probation_period'] = $request->probation == 'yes' ? $request->probation_period : null;

            if ($request->hasFile('appointment_order_doc')) {
    
                $files = $request->file('appointment_order_doc');
                $imageName = uniqid() . Str::replace(' ', "-", $files->getClientOriginalName());

                $directory = 'staff/' . $staff_info->emp_code . '/appointment';

                
                $all_files =   Storage::allFiles('public/'.$directory);
                Storage::delete($all_files);

                $filename  = $directory . '/' . $imageName;

                Storage::disk('public')->put($filename, File::get($files));
                $ins['appointment_doc'] = $filename;
            }

            $ins['status'] = 'active';
            
            StaffAppointmentDetail::updateOrCreate(['staff_id' => $staff_id], $ins);

            $error      = 0;
            $message    = '';
        } else {
            $error      = 1;
            $message    = $validator->errors()->all();
        }
        return response()->json(['error' => $error, 'message' => $message, 'id' => $id ?? '']);
    }
}
