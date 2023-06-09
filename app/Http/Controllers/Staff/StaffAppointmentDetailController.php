<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use App\Models\Master\AppointmentOrderModel;
use App\Models\Master\PlaceOfWork;
use App\Models\Master\Society;
use App\Models\Staff\StaffAppointmentDetail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Filesystem\Filesystem;
use PDF;


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
            
            StaffAppointmentDetail::updateOrCreate(['staff_id' => $staff_id, 'academic_id' => $academic_id], $ins);

            if( canGenerateEmpCode($staff_id) ) {
                /**
                 * generate emp code   // society_emp_code, institute_emp_code
                 */
                if( !$staff_info->society_emp_code ) {

                    $staff_info->society_emp_code = getStaffEmployeeCode();
                    $staff_info->save();
                }
                if( !$staff_info->institute_emp_code ) {

                    $staff_info->institute_emp_code = getStaffInstitutionCode($staff_info->institute_id);
                    $staff_info->save();
                }
            }

            $error      = 0;
            $message    = '';
        } else {
            $error      = 1;
            $message    = $validator->errors()->all();
        }
        return response()->json(['error' => $error, 'message' => $message, 'id' => $id ?? '']);
    }

    public function generateModelPreview(Request $request)
    {

        $appointment_order_model_id = $request->appointment_order_model_id;

        /**
         * Get Appointment order details
         */       
        
        $model_info = AppointmentOrderModel::find($appointment_order_model_id);
        if( isset($model_info->document ) && !empty( $model_info->document ) ) {
            $document = $model_info->document;
            $user_info = User::find($request->staff_id);
            $society_info = Society::find(1);
            
            $place_of_work = PlaceOfWork::find($request->place_of_work_id);
            $staff_name = $user_info->personal->gender == 'male' ? 'Mr.' : 'Ms'; 
            $appointment_variables = array(
                'date' => date('d-m-Y'),        
                'appointment_order_no' => appointmentOrderNo($user_info->id),
                'appointment_date' => $request->from_appointment,
                'designation' => $user_info->position->designation->name ?? null,
                'staff_name' => $staff_name.$user_info->name,
                'institution_name' => $user_info->institute->name ?? null,
                'place' => $place_of_work->name ?? null,
                'salary' => $request->salary_scale,
                'date_of_completion' => '',
                'probation_completed_date' => '',
                'probation_order_date' => '',
                'society_name' => $society_info->name ?? null
            );

            foreach ($appointment_variables as $key => $value) {
                $document = str_replace('$'.$key, $value, $document);
            }

            $pdf = PDF::loadView('pages.masters.appointment_order_model.dynamic_pdf', [ 'data' => $document])->setPaper('a4', 'portrait');
            $path = 'public/order_preview';

            if (! File::exists($path)) {
                File::makeDirectory($path, $mode = 0777, true, true);
            }
            $fileName =  time().'.'. 'pdf' ;
            $pdf_path = 'public/order_preview/'.$fileName;
            $pdf->save($pdf_path);

            return asset($pdf_path);
            
            $error = 0;
            $message = 'Genereated success';
        } else {
            $error = 1;
            $message = 'Appointment Order Model does not upload document';
        }

        return array('error' => $error, 'message' => $message);
        
        

    }
   
}
