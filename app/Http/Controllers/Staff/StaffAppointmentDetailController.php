<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use App\Models\Master\AppointmentOrderModel;
use App\Models\Master\Designation;
use App\Models\Master\NatureOfEmployment;
use App\Models\Master\PlaceOfWork;
use App\Models\Master\Society;
use App\Models\Master\StaffCategory;
use App\Models\Master\TeachingType;
use App\Models\Staff\StaffAppointmentDetail;
use App\Models\Staff\StaffProfessionalData;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Hash;
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
            'probation_order_no'=>'nullable',
            'probation_order_date'=>'nullable',

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
            $ins['probation_order_no'] = $request->probation_order_no ?? null;
             $ins['probation_order_date'] = $request->probation_order_date ?? null;

            $ins['previous_appointment_number'] = $request->previous_appointment_number;
            $ins['previous_appointment_date'] = $request->previous_appointment_date;
            $ins['previous_designation'] = $request->previous_designation;

            if ($request->hasFile('appointment_order_doc')) {

                $files = $request->file('appointment_order_doc');
                $imageName = uniqid() . Str::replace(' ', "-", $files->getClientOriginalName());

                $directory = 'staff/' . $staff_info->emp_code . '/appointment';

                $filename  = $directory . '/' . $imageName;

                Storage::disk('public')->put($filename, File::get($files));
                $ins['appointment_doc'] = $filename;
            }

            $ins['status'] = 'active';

            $appointment_info = StaffAppointmentDetail::updateOrCreate(['staff_id' => $staff_id, 'academic_id' => $academic_id], $ins);

            if (!$appointment_info->appointment_order_no) {
                $appointment_info->appointment_order_no = appointmentOrderNo($staff_id, $academic_id);
                $appointment_info->save();
            }
            if (canGenerateEmpCode($staff_id)) {
                /**
                 * generate emp code   // society_emp_code, institute_emp_code
                 */
                if (!$staff_info->society_emp_code) {

                    $staff_info->society_emp_code = getStaffEmployeeCode();
                    $staff_info->save();
                }
                if (!$staff_info->institute_emp_code) {

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
        $id = $request->id ?? '';

        if ($id) {
            $order_details = StaffAppointmentDetail::find($id);
           
        }
        /**
         * Get Appointment order details
         */

        $model_info = AppointmentOrderModel::find($appointment_order_model_id);
        //dd($model_info);

        if (isset($model_info->document) && !empty($model_info->document)) {
            $academic_id = $request->academic_id ?? academicYearId();
            $document = $model_info->document;
            $user_info = User::find($request->staff_id);
            $society_info = Society::find(1);
            if($id){
                $appointment_order_no=$order_details->appointment_order_no;
                $previous_appointment_number=$order_details->previous_appointment_number ?? null;
                $previous_appointment_date=$order_details->previous_appointment_date ? commonDateFormatAlt($order_details->previous_appointment_date) : null;
                $previous_designation=$order_details->previous_designation ?? null;
                 $probation_order_no=$order_details->probation_order_no ?? null;
                 $probation_order_date=$order_details->probation_order_date ?? null;
                 $probation_completed_date=$order_details->to_appointment ?? null;
                 $date_of_completion=$order_details->to_appointment ?? null;

           }else{
            
                $appointment_order_no=appointmentOrderNo($user_info->id, $academic_id);
                $previous_appointment_number = null;
                $previous_appointment_date = null;
                $previous_designation =null;
                $probation_order_no=null;

                $probation_order_date=null;
                $probation_completed_date=null;
                $date_of_completion=null;

       
               
           }

            $place_of_work = PlaceOfWork::find($request->place_of_work_id);
            $staff_name = $user_info->personal->gender == 'male' ? 'Mr.' : ($user_info->personal->marital_status == 'married' ? 'Mrs.' : 'Ms.');
            $appointment_variables = array(
                'date' => date('d-m-Y'),
                'appointment_order_no' =>$appointment_order_no ?? Null,
                'appointment_date' => commonDateFormat($request->from_appointment),
                'designation' => $user_info->position->designation->name ?? null,
                'staff_name' => $staff_name . $user_info->name,
                'institution_name' => $user_info->institute->name ?? null,
                'institution_address' => $user_info->institute->address,
                'place' => $place_of_work->name ?? null,
                'salary' => $request->salary_scale,
                'completion_date'=>$date_of_completion,
                'probation_completed_date' => $probation_completed_date,
                'probation_order_date' => $probation_order_date,
                'probation_order_no' => $probation_order_no,
                'society_name' => $society_info->name ?? null,

                'previous_appointment_number' => $previous_appointment_number,
                'previous_appointment_date' => $previous_appointment_date,
                'previous_designation' => $previous_designation
            );
           
            foreach ($appointment_variables as $key => $value) {

                    $document = str_replace('$' . $key, $value, $document);
                
            }


            $pdfConfig = [
                'margin_top' => 100,

            ];
            $pdf = PDF::loadView('pages.masters.appointment_order_model.dynamic_pdf', ['data' => $document])
                ->setPaper('legal', 'portrait')->setOptions($pdfConfig);

            $path = 'public/order_preview/' . $user_info->id;
            if (File::exists($path)) {
                File::deleteDirectory($path);
            }
            if (!File::exists($path)) {
                File::makeDirectory($path, $mode = 0777, true, true);
            }
            $fileName =  time() . '.' . 'pdf';
            $pdf_path = 'public/order_preview/' . $user_info->id . '/' . $fileName;
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

    public function delete(Request $request)
    {
        $id = $request->id;
        if ($id) {

            $details = StaffAppointmentDetail::find($id);
            $staff_details = User::find($details->staff_id);
            $details->delete();
            return view('pages.staff.registration.appointment.list', compact('staff_details'));
        }
    }

    public function updateAppointmentModal(Request $request)
    {
        $id = $request->id ?? '';
        if ($id) {

            $details = StaffAppointmentDetail::find($id);
            $title = 'Update Appointment Order';
        } else {
            $title = 'Add Appoinment Order';
        }
        $staff_category = StaffCategory::where('status', 'active')->get();
        $employments = NatureOfEmployment::where('status', 'active')->get();
        $teaching_types = TeachingType::where('status', 'active')->get();
        $place_of_works = PlaceOfWork::where('status', 'active')->get();
        $designation = Designation::where('status', 'active')->get();
        $order_models = AppointmentOrderModel::where('status', 'active')->get();

        $params = array(
            'details' => $details ?? [],
            'title' => $title,
            'staff_category' => $staff_category,
            'employments' => $employments,
            'teaching_types' => $teaching_types,
            'place_of_works' => $place_of_works,
            'order_models' => $order_models,
            'designation' => $designation
        );

       return view('pages.staff.registration.appointment.add_edit', $params);
    }

    public function doUpdateAppointmentModal(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'staff_category_id' => 'required',
            'nature_of_employment_id' => 'required',
            'teaching_type_id' => 'required',
            'place_of_work_id' => 'required',
            'joining_date' => 'required',
            'salary_scale' => 'required',
            'from_appointment' => 'required',
            'to_appointment' => 'required',
            'appointment_order_model_id' => 'required',
            'appointment_order_model_id' => 'required',
            'probation_order_no' => 'nullable',
            'probation_order_date'=>'nullable',
            'designation_id' => 'required'
        ]);

        if ($validator->passes()) {

            $id = $request->id;
            if ($id) {
                
                $info = StaffAppointmentDetail::find($id);
                $staff_info = User::find($info->staff_id);
                $professional_data = StaffProfessionalData::where('staff_id', $info->staff_id)->first();
                // dd( $request->all());
                $info->category_id = $request->staff_category_id;
                $info->nature_of_employment_id = $request->nature_of_employment_id;
                $info->teaching_type_id = $request->teaching_type_id;
                $info->place_of_work_id = $request->place_of_work_id;
                $info->joining_date = date('Y-m-d', strtotime($request->joining_date));
                $info->salary_scale = $request->salary_scale;
                $info->from_appointment = date('Y-m-d', strtotime($request->from_appointment));
                $info->to_appointment = date('Y-m-d', strtotime($request->to_appointment));;
                $info->appointment_order_model_id = $request->appointment_order_model_id;
                $info->has_probation = $request->probation_update;
                $info->probation_period = $request->probation_update == 'yes' ? $request->probation_period : null;
                $info->probation_order_no=$request->probation_order_no ?? NUll;
                 $info->probation_order_date=$request->probation_order_date ?? NUll;
                
                $info->is_till_active = $request->is_till_active;
                $info->designation_id = $request->designation_id;
                $info->institution_id = session()->get('staff_institute_id') ?? null;

                // Previous Appointment Info
                $info->previous_appointment_number = $request->previous_appointment_number ?? null;
                $info->previous_appointment_date = $request->previous_appointment_date ?? null;
                $info->previous_designation = $request->previous_designation ?? null;

                if ($request->is_till_active == 'yes') {

                    StaffAppointmentDetail::where('staff_id', $info->staff_id)->update(['is_till_active' => 'no']);
                    $professional_data->designation_id = $request->designation_id;
                    $professional_data->save();
                }
                if ($request->hasFile('appointment_order_doc')) {

                    $files = $request->file('appointment_order_doc');
                    $imageName = uniqid() . Str::replace(' ', "-", $files->getClientOriginalName());

                    $directory = 'staff/' . $staff_info->emp_code . '/appointment';

                    $filename  = $directory . '/' . $imageName;

                    Storage::disk('public')->put($filename, File::get($files));
                    $info->appointment_doc = $filename;
                }
                $staff_id = $info->staff_id;
                if (!$info->appointment_order_no) {
                    $info->appointment_order_no = appointmentOrderNo($staff_id, $info->academic_id);
                }

                $info->save();
            } else {

                $academic_id = $request->academic_id ?? academicYearId();

                $staff_id = $request->staff_id;
                $staff_info = User::find($staff_id);

                StaffAppointmentDetail::where('staff_id', $staff_id)->update(['is_till_active' => 'no']);

                $ins['academic_id'] = $academic_id;
                $ins['staff_id'] = $staff_id;
                $ins['institution_id'] = $staff_info->institute_id;
                $ins['category_id'] = $request->staff_category_id;
                $ins['nature_of_employment_id'] = $request->nature_of_employment_id;
                $ins['teaching_type_id'] = $request->teaching_type_id;
                $ins['place_of_work_id'] = $request->place_of_work_id;
                $ins['joining_date'] = date('Y-m-d', strtotime($request->joining_date));
                $ins['salary_scale'] = $request->salary_scale;
                $ins['from_appointment'] = date('Y-m-d', strtotime($request->from_appointment));
                $ins['to_appointment'] = date('Y-m-d', strtotime($request->to_appointment));;
                $ins['appointment_order_model_id'] = $request->appointment_order_model_id;
                $ins['has_probation'] = $request->probation_update;
                $ins['probation_period'] = $request->probation_update == 'yes' ? $request->probation_period : null;
                $ins['is_till_active'] = $request->is_till_active;
                $ins['designation_id'] = $request->designation_id;
                $ins['probation_order_no']=$request->probation_order_no ?? NUll;

                $ins['previous_appointment_number'] = $request->previous_appointment_number;
                $ins['previous_appointment_date'] = $request->previous_appointment_date;
                $ins['previous_designation'] = $request->previous_designation;

                if ($request->hasFile('appointment_order_doc')) {

                    $files = $request->file('appointment_order_doc');
                    $imageName = uniqid() . Str::replace(' ', "-", $files->getClientOriginalName());

                    $directory = 'staff/' . $staff_info->emp_code . '/appointment';

                    $filename  = $directory . '/' . $imageName;

                    Storage::disk('public')->put($filename, File::get($files));
                    $ins['appointment_doc'] = $filename;
                }

                $ins['status'] = 'active';

                $order_details = StaffAppointmentDetail::create($ins);

                $professional_data = StaffProfessionalData::where('staff_id', $staff_id)->first();
                $professional_data->designation_id = $request->designation_id;
                $professional_data->save();

                if (!$order_details->appointment_order_no) {
                    $order_details->appointment_order_no = appointmentOrderNo($staff_id, $academic_id);
                    $order_details->save();
                }

                if (canGenerateEmpCode($staff_id)) {
                    /**
                     * generate emp code   // society_emp_code, institute_emp_code
                     */
                    $staff_info = User::find($staff_id);
                    if (!$staff_info->society_emp_code) {

                        $staff_info->society_emp_code = getStaffEmployeeCode();
                        $staff_info->save();
                    }
                    if (!$staff_info->institute_emp_code) {

                        $staff_info->institute_emp_code = getStaffInstitutionCode($staff_info->institute_id);
                        $staff_info->save();
                    }
                }
            }
            $error      = 0;
            $message    = '';
        } else {
            $error      = 1;
            $message    = $validator->errors()->all();
        }
        return response()->json(['error' => $error, 'message' => $message, 'staff_id' => $staff_id ?? '']);
    }

    public function list(Request $request)
    {

        $staff_id = $request->staff_id;
        $staff_details = User::find($staff_id);
        return view('pages.staff.registration.appointment.list', compact('staff_details'));
    }

    public function verifyStaff(Request $request)
    {

        $staff_id = $request->id;
        $is_verified = true;
        if (!getStaffVerificationStatus($staff_id, 'doc_verified')) {
            $is_verified = false;
        }
        if (!getStaffVerificationStatus($staff_id, 'data_entry')) {
            $is_verified = false;
        }
        if (!getStaffVerificationStatus($staff_id, 'doc_uploaded')) {
            $is_verified = false;
        }
        if (!getStaffVerificationStatus($staff_id, 'salary_entry')) {
            $is_verified = false;
        }

        if ($is_verified) {
            //user can verify
            $error = 0;
            $message = 'Employee Verified Successfully';
            $staff_info = User::find($staff_id);
            $staff_info->verification_status = 'approved';
            if (empty($staff_info->password)) {
                $staff_info->password = Hash::make('12345678');
            }
            $staff_info->save();
        } else {
            //use cannot verify
            $error = 1;
            $message = 'Cannot Verify employee, Please complete all verification';
        }

        return array('error' => $error, 'message' => $message);
    }
}
