<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Master\BoardController;
use App\Models\Leave\StaffLeave;
use App\Models\Master\AppointmentOrderModel;
use App\Models\Master\AttendanceScheme;
use App\Models\Master\Bank;
use App\Models\Staff\StaffELEntry;
use App\Models\Staff\StaffLeaveMapping;
use App\Models\Master\BankBranch;
use App\Models\Master\BloodGroup;
use App\Models\Master\Board;
use App\Models\Master\Caste;
use App\Models\Master\Classes;
use App\Models\Master\Community;
use App\Models\Master\Department;
use App\Models\Master\Designation;
use App\Models\Master\Division;
use App\Models\Master\DocumentType;
use App\Models\Master\DutyClass;
use App\Models\Master\Institution;
use App\Models\Master\Language;
use App\Models\Master\Nationality;
use App\Models\Master\NatureOfEmployment;
use App\Models\Master\OtherSchool;
use App\Models\Master\OtherSchoolPlace;
use App\Models\Master\PlaceOfWork;
use App\Models\Master\ProfessionType;
use App\Models\Master\Qualification;
use App\Models\Master\RelationshipType;
use App\Models\Master\Religion;
use App\Models\Master\StaffCategory;
use App\Models\Master\Subject;
use App\Models\Master\TeachingType;
use App\Models\Master\TopicTraining;
use App\Models\Master\TypeOfDuty;
use App\Models\PayrollManagement\StaffSalary;
use App\Models\ReportingManager;
use App\Models\Staff\StaffAppointmentDetail;
use App\Models\Staff\StaffBankDetail;
use App\Models\Staff\StaffClass;
use App\Models\Staff\StaffDocument;
use App\Models\Staff\StaffEducationDetail;
use App\Models\Staff\StaffExperiencedSubject;
use App\Models\Staff\StaffFamilyMember;
use App\Models\Staff\StaffHandlingSubject;
use App\Models\Staff\StaffInvigilationDuty;
use App\Models\Staff\StaffKnownLanguage;
use App\Models\Staff\StaffMedicalRemark;
use App\Models\Staff\StaffNominee;
use App\Models\Staff\StaffPersonalInfo;
use App\Models\Staff\StaffPfEsiDetail;
use App\Models\Staff\StaffProfessionalData;
use App\Models\Staff\StaffStudiedSubject;
use App\Models\Staff\StaffTalent;
use App\Models\Staff\StaffTrainingDetail;
use App\Models\Staff\StaffWorkExperience;
use App\Models\Staff\StaffWorkingRelation;
use App\Models\User;
use App\Models\AttendanceManagement\LeaveMapping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\Tax\TaxScheme;
use DataTables;
use App\Models\AttendanceManagement\AttendanceManualEntry;
use Carbon\Carbon;
use PDF;
use App\Models\CalendarDays;
use App\Models\Staff\StaffBankLoan;
use App\Models\AcademicYear;
use App\Models\AttendanceManagement\LeaveHead;
class StaffController extends Controller
{
   public function StaffDocumentDelete(Request $request)
    { 
    $document=StaffDocument::find($request->id);
    $document->multi_file=Null;
    $document->update();
        return response()->json(['message' => "Document Removed", 'status' => 1,'type'=>$request->type]);

     }
    public function register(Request $request, $id = null)
    {

        $breadcrums = array(
            'title' => 'Staff Registration Wizard',
            'breadcrums' => array(
                array('link' => route('staff.list'), 'title' => 'Staff Management'),
                array('link' => '', 'title' => 'Staff Registration')
            )
        );
        $used_classes = [];
        $used_exp_subjects = [];
        if ($id) {
            $staff_details = User::find($id);
            if (isset($staff_details->staffClasses) && !empty($staff_details->staffClasses)) {
                foreach ($staff_details->staffClasses as $items) {
                    $used_classes[] = $items->class_id;
                }
            }
            if (isset($staff_details->experiencedSubject) && !empty($staff_details->experiencedSubject)) {
                foreach ($staff_details->experiencedSubject  as $item) {
                    $used_exp_subjects[] = $item->subject_id;
                }
            }
            if (isset($staff_details->bank->bank_branch_id) && !empty($staff_details->bank->bank_branch_id)) {
                $branch_details = BankBranch::where('bank_id', $staff_details->bank->bank_id)->get();
            }

            $invigilation_details = StaffInvigilationDuty::where('status', 'active')
                ->where('staff_id', $id)->get();
            $training_details = StaffTrainingDetail::where('status', 'active')->where('staff_id', $id)->get();
            $course_details = StaffEducationDetail::where('status', 'active')->where('staff_id', $id)->get();
            $experience_details = StaffWorkExperience::where('status', 'active')->where('staff_id', $id)->get();
            $known_languages = StaffKnownLanguage::where('status', 'active')->where('staff_id', $id)->get();
            $member_details = StaffFamilyMember::where('status', 'active')->where('staff_id', $id)->get();
            $nominee_details = StaffNominee::where('staff_id', $id)->get();
            $working_details = StaffWorkingRelation::where('status', 'active')->where('staff_id', $id)->get();
            $medical_remarks = StaffMedicalRemark::where('staff_id', $id)->get();

            $subject_handling = DB::select("SELECT 
                                    COUNT(*) AS subject_count,
                                    STUFF((
                                    SELECT ',' + CAST(subject_id AS VARCHAR(10))
                                    FROM staff_handling_subjects
                                    where staff_id = " . $id . "
                                    group by subject_id
                                    FOR XML PATH(''), TYPE
                                    ).value('.', 'NVARCHAR(MAX)'), 1, 1, '') AS concatenated_subjects
                                FROM staff_handling_subjects s ");

            if (isset($subject_handling[0]) && $subject_handling[0]->subject_count > 0) {

                $string_comes = $subject_handling[0]->concatenated_subjects;
                $string_comes = explode(",", $string_comes);
                $subject_details = Subject::whereIn('id', $string_comes)->get();
            }

            $class_handling = DB::select("SELECT 
                                    COUNT(*) AS class_count,
                                    STUFF((
                                    SELECT ',' + CAST(class_id AS VARCHAR(10))
                                    FROM staff_handling_subjects
                                    where staff_id = " . $id . "
                                    group by class_id
                                    FOR XML PATH(''), TYPE
                                    ).value('.', 'NVARCHAR(MAX)'), 1, 1, '') AS concatenated_subjects
                                FROM staff_handling_subjects s ");
            if (isset($class_handling[0]) && $class_handling[0]->class_count > 0) {

                $class_string = $class_handling[0]->concatenated_subjects;
                $class_string = explode(",", $class_string);
                $class_details = Classes::whereIn('id', $class_string)->get();
            }
        }

        $other_staff = User::with('institute')->where('status', 'active')
           
            ->when($id != null, function ($q) use ($id) {
                $q->where('id', '!=', $id);
            })
            ->get();

        $institutions = Institution::where('status', 'active')->get();
        $reporting_managers = ReportingManager::where('status', 'active')
            // ->where('is_top_level', 'no')
            ->get();
        $divisions = Division::where('status', 'active')->get();
        $classes = Classes::where('status', 'active')->get();
        $duty_classes = DutyClass::where('status', 'active')->get();
        $duty_types = TypeOfDuty::where('status', 'active')->get();
        $other_schools = OtherSchool::where('status', 'active')->orderBy('name', 'asc')->get();
        $mother_tongues = Language::where('status', 'active')->orderBy('name', 'asc')->get();
        $nationalities = Nationality::where('status', 'active')->orderBy('name', 'asc')->get();
        $places = OtherSchoolPlace::where('status', 'active')->orderBy('name', 'asc')->get();
        $religions = Religion::where('status', 'active')->orderBy('name', 'asc')->get();
        $castes = Caste::where('status', 'active')->orderBy('name', 'asc')->get();
        $communities = Community::where('status', 'active')->orderBy('name', 'asc')->get();
        $banks = Bank::where('status', 'active')->orderBy('name', 'asc')->get();

        #phase3
        $designation = Designation::where('status', 'active')->orderBy('name', 'asc')->get();
        $department = Department::where('status', 'active')->orderBy('name', 'asc')->get();
        $subjects = Subject::where('status', 'active')->orderBy('name', 'asc')->get();
        $scheme = AttendanceScheme::where('status', 'active')->orderBy('name', 'asc')->get();
        $training_topics = TopicTraining::where('status', 'active')->orderBy('name', 'asc')->get();

        #phase4
        $boards = Board::where('status', 'active')->orderBy('name', 'asc')->get();
        $types = ProfessionType::where('status', 'active')->get();

        #phase5
        $relation_types = RelationshipType::where('status', 'active')->get();
        $blood_groups = BloodGroup::where('status', 'active')->orderBy('name')->get();
        $qualificaiton = Qualification::where('status', 'active')->get();

        #phase7
        $staff_category = StaffCategory::where('status', 'active')->get();
        $employments = NatureOfEmployment::where('status', 'active')->get();
        $teaching_types = TeachingType::where('status', 'active')->get();
        $place_of_works = PlaceOfWork::where('status', 'active')->get();
        $order_models = AppointmentOrderModel::where('status', 'active')->get();

        $step = getRegistrationSteps($id);
        $tax_scheme=TaxScheme::where('status', 'active')->get();
        $leave_mapping=StaffLeaveMapping::where('staff_id',$id)->where('acadamic_id',academicYearId())->get();
        $first_appointment = StaffAppointmentDetail::where('staff_id', $id)->orderBy('staff_id', 'asc')->first();
    $el_count = StaffLeaveMapping::where('staff_id', $id)->where('leave_head_id', 2)->get();
        $params = array(
            'breadcrums' => $breadcrums,
            'institutions' => $institutions,
            'reporting_managers' => $reporting_managers,
            'divisions' => $divisions,
            'classes' => $classes,
            'staff_details' => $staff_details ?? '',
            'used_classes' => $used_classes,
            'mother_tongues' => $mother_tongues,
            'nationalities' => $nationalities,
            'religions' => $religions,
            'castes' => $castes,
            'communities' => $communities,
            'banks' => $banks,
            'places' => $places,
            'id' => $id,
            'step' => $step,
            'branch_details' => $branch_details ?? [],
            'designation' => $designation,
            'department' => $department,
            'subjects' => $subjects,
            'scheme' => $scheme,
            'duty_classes' => $duty_classes,
            'duty_types' => $duty_types,
            'other_schools' => $other_schools,
            'invigilation_details' => $invigilation_details ?? [],
            'duty_info' => '',
            'training_topics' => $training_topics ?? [],
            'training_details' => $training_details ?? [],
            'used_exp_subjects' => $used_exp_subjects,
            'boards' => $boards ?? [],
            'types' => $types ?? [],
            'course_details' => $course_details ?? [],
            'experience_details' => $experience_details ?? [],
            'known_languages' => $known_languages ?? [],
            'relation_types' => $relation_types ?? [],
            'blood_groups' => $blood_groups ?? [],
            'qualificaiton' => $qualificaiton ?? [],
            'member_details' => $member_details ?? [],
            'nominee_details' => $nominee_details ?? [],
            'other_staff' => $other_staff ?? [],
            'working_details' => $working_details ?? [],
            'medical_remarks' => $medical_remarks ?? [],
            'staff_category' => $staff_category ?? [],
            'employments' => $employments ?? [],
            'teaching_types' => $teaching_types ?? [],
            'place_of_works' => $place_of_works ?? [],
            'order_models' => $order_models ?? [],
            'class_details' => $class_details ?? [],
            'subject_details' => $subject_details ?? [],
            'tax_scheme'=>$tax_scheme??[],
            'leave_mappings'=>$leave_mapping??[],
            'first_appointment'=>$first_appointment,
            'el_count'=>$el_count
        );

        return view('pages.staff.registration.index', $params);
    }

    public function insertPersonalData(Request $request)
    {

        $id = $request->id ?? '';
        $data = '';
        $validator      = Validator::make($request->all(), [
            'institute_name' => 'required',
            'name' => 'required',
            // 'email' => 'required|string|unique:users,email,' . $id,
            // 'previous_code' => 'required'
            'previous_code' => 'required|string|unique:users,emp_code,'.$id.',id,deleted_at,NULL',
        ]);

        if ($validator->passes()) {

            $previous_code = $request->previous_code ?? date('dmyhis');
            
            $isExistUser = User::where('emp_code', $previous_code)->first();

            $academic_id = academicYearId();
            $ins['name'] = $request->name;
            $ins['email'] = $request->email;
            $ins['institute_id'] = $request->institute_name;
            $ins['academic_id'] = $academic_id;
            $ins['emp_code'] = $previous_code;
            $ins['locker_no'] = 'AMIDL' . $previous_code;
            $ins['first_name_tamil'] = $request->first_name_tamil;
            $ins['short_name'] = $request->short_name;
            $ins['reporting_manager_id'] = $request->reporting_manager_id;
            $ins['status'] = 'active';
            if ($isExistUser) {
                $ins['updatedBy'] = auth()->id();
            } else {
                $ins['addedBy'] = auth()->id();
            }

            $data = User::updateOrCreate(['emp_code' => $previous_code], $ins);

            if ($request->aadhar_type) {
                $aadhar_id = DocumentType::where('name', 'Adhaar')->orwhere('name', 'Aadhaar')->first();
                $ins_aa = [];
                $ins_aa['academic_id'] = $academic_id;
                $ins_aa['staff_id'] = $data->id;
                $ins_aa['document_type_id'] = $aadhar_id->id;
                $ins_aa['description'] = $request->aadhar_name;
                $ins_aa['doc_number'] = $request->aadhar_no ?? null;
               

                /** 
                 *  check file is exists
                 */
                if ($request->hasFile('aadhar')) {

                    $files = $request->file('aadhar');
                    $imageIns = [];
                    $iteration = 1;
                    foreach ($files as $file) {

                        $imageName = uniqid() . Str::replace(' ', "-", $file->getClientOriginalName());


                        $directory              = 'staff/' . $previous_code . '/aadhar';
                        $filename               = $directory . '/' . $imageName;

                        Storage::disk('public')->put($filename, File::get($file));

                        $imageIns[] = $filename;
                        $iteration++;
                    }
                    $file_name = $imageIns ? implode(',', $imageIns) : null;

                    $ins_aa['multi_file'] = $file_name;
                    $ins_aa['verification_status'] = 'pending';
                }
                StaffDocument::updateOrCreate(['staff_id' => $data->id, 'document_type_id' => $aadhar_id->id], $ins_aa);
            }

            if ($request->pancard_type) {
                $pan_id = DocumentType::where('name', 'Pan Card')->first();
                $ins_aa = [];
                $ins_aa['academic_id'] = $academic_id;
                $ins_aa['staff_id'] = $data->id;
                $ins_aa['document_type_id'] = $pan_id->id;
                $ins_aa['description'] = $request->pancard_name;
                $ins_aa['doc_number'] = $request->pancard_no ?? null;
              
                $file_name = null;
                /** 
                 *  check file is exists
                 */
                if ($request->hasFile('pancard')) {

                    $files = $request->file('pancard');
                    $imageIns = [];
                    $iteration = 1;
                    foreach ($files as $file1) {

                        $imageName = uniqid() . Str::replace(' ', "-", $file1->getClientOriginalName());

                        $directory              = 'staff/' . $request->previous_code . '/pancard';
                        $filename               = $directory . '/' . $imageName;

                        Storage::disk('public')->put($filename, File::get($file1));

                        $imageIns[] = $filename;
                        $iteration++;
                    }
                    $file_name = $imageIns ? implode(',', $imageIns) : null;

                    $ins_aa['multi_file'] = $file_name;
                  $ins_aa['verification_status'] = 'pending';
                }

                StaffDocument::updateOrCreate(['staff_id' => $data->id, 'document_type_id' => $pan_id->id], $ins_aa);
            }

            if ($request->ration_type) {
                $ration_id = DocumentType::where('name', 'Ration Card')->first();
                $ins_aa = [];
                $ins_aa['academic_id'] = $academic_id;
                $ins_aa['staff_id'] = $data->id;
                $ins_aa['document_type_id'] = $ration_id->id;
                $ins_aa['description'] = $request->ration_card_name;
                $ins_aa['doc_number'] = $request->ration_card_number ?? null;
                

                $file_name = null;
                /** 
                 *  check file is exists
                 */
                if ($request->hasFile('ration_card')) {

                    $files = $request->file('ration_card');
                    $imageIns = [];
                    $iteration = 1;
                    foreach ($files as $file2) {

                        $imageName = uniqid() . Str::replace(' ', "-", $file2->getClientOriginalName());


                        $directory              = 'staff/' . $request->previous_code . '/ration_card';
                        $filename               = $directory . '/' . $imageName;

                        Storage::disk('public')->put($filename, File::get($file2));

                        $imageIns[] = $filename;
                        $iteration++;
                    }
                    $file_name = $imageIns ? implode(',', $imageIns) : null;

                    $ins_aa['multi_file'] = $file_name;
                $ins_aa['verification_status'] = 'pending';
                }

                StaffDocument::updateOrCreate(['staff_id' => $data->id, 'document_type_id' => $ration_id->id], $ins_aa);
            }

            if ($request->licence_type) {
                $license_id = DocumentType::where('name', 'Driving License')->first();
                $ins_aa = [];
                $ins_aa['academic_id'] = $academic_id;
                $ins_aa['staff_id'] = $data->id;
                $ins_aa['document_type_id'] = $license_id->id;
                $ins_aa['description'] = $request->license_name;
                $ins_aa['doc_number'] = $request->license_number ?? null;
               

                $file_name = null;
                /* 
                 *  check file is exists
                 */
                if ($request->hasFile('driving_license')) {

                    $files = $request->file('driving_license');
                    $imageIns = [];
                    $iteration = 1;
                    foreach ($files as $file3) {

                        $imageName = uniqid() . Str::replace(' ', "-", $file3->getClientOriginalName());


                        $directory              = 'staff/' . $request->previous_code . '/driving_license';
                        $filename               = $directory . '/' . $imageName;

                        Storage::disk('public')->put($filename, File::get($file3));

                        $imageIns[] = $filename;
                        $iteration++;
                    }
                    $file_name = $imageIns ? implode(',', $imageIns) : null;

                    $ins_aa['multi_file'] = $file_name;
                 $ins_aa['verification_status'] = 'pending';
                }

                StaffDocument::updateOrCreate(['staff_id' => $data->id, 'document_type_id' => $license_id->id], $ins_aa);
            }

            if ($request->voter_type) {

                $voter_id = DocumentType::where('name', 'Voter ID')->first();
                $ins_aa = [];
                $ins_aa['academic_id'] = $academic_id;
                $ins_aa['staff_id'] = $data->id;
                $ins_aa['document_type_id'] = $voter_id->id;
                $ins_aa['description'] = $request->voter_name;
                $ins_aa['doc_number'] = $request->voter_number ?? null;
                
                $file_name = null;
                /** 
                 *  check file is exists
                 */
                if ($request->hasFile('voter')) {

                    $files = $request->file('voter');
                    $imageIns = [];
                    $iteration = 1;
                    foreach ($files as $file4) {

                        $imageName = uniqid() . Str::replace(' ', "-", $file4->getClientOriginalName());


                        $directory              = 'staff/' . $request->previous_code . '/voter';
                        $filename               = $directory . '/' . $imageName;

                        Storage::disk('public')->put($filename, File::get($file4));

                        $imageIns[] = $filename;
                        $iteration++;
                    }
                    $file_name = $imageIns ? implode(',', $imageIns) : null;

                    $ins_aa['multi_file'] = $file_name;
                $ins_aa['verification_status'] = 'pending';
                }

                StaffDocument::updateOrCreate(['staff_id' => $data->id, 'document_type_id' => $voter_id->id], $ins_aa);
            }

            if ($request->passport_type) {

                $passport_id = DocumentType::where('name', 'Passport')->first();
                $ins_aa = [];
                $ins_aa['academic_id'] = $academic_id;
                $ins_aa['staff_id'] = $data->id;
                $ins_aa['document_type_id'] = $passport_id->id;
                $ins_aa['description'] = $request->passport_name;
                $ins_aa['doc_number'] = $request->passport_number ?? null;
                $ins_aa['doc_date'] = $request->passport_valid_upto ? date('Y-m-d', strtotime($request->passport_valid_upto)) : null;
               

                $file_name = null;
                /** 
                 *  check file is exists
                 */
                if ($request->hasFile('passport')) {

                    $files = $request->file('passport');
                    $imageIns = [];
                    $iteration = 1;
                    foreach ($files as $file5) {

                        $imageName = uniqid() . Str::replace(' ', "-", $file5->getClientOriginalName());


                        $directory              = 'staff/' . $request->previous_code . '/passport';
                        $filename               = $directory . '/' . $imageName;

                        Storage::disk('public')->put($filename, File::get($file5));

                        $imageIns[] = $filename;
                        $iteration++;
                    }
                    $file_name = $imageIns ? implode(',', $imageIns) : null;

                    $ins_aa['multi_file'] = $file_name;
                 $ins_aa['verification_status'] = 'pending';
                }

                StaffDocument::updateOrCreate(['staff_id' => $data->id, 'document_type_id' => $passport_id->id], $ins_aa);
            }

            $error = 0;
            $message = 'Added successfully';
            $id = $data->id ?? '';
        } else {
            $error = 1;
            $message = $validator->errors()->all();
        }
        return response()->json(['error' => $error, 'message' => $message, 'id' => $id ?? '']);
    }

    public function getStaffDraftData(Request $request)
    {
        $code  = $request->code;

        $staff_details = User::where('verification_status', $code)
            ->where('emp_code', 'like', '%%')->get();
       return $staff_details;
       
    }
    function removeDirectory($path) {
        // Check if the path exists and is a directory
        if (file_exists($path) && is_dir($path)) {
            $files = scandir($path);
            foreach ($files as $file) {
                if ($file != '.' && $file != '..') {
                    $currentPath = $path . '/' . $file;
                    // Remove files or recursively remove directories
                    if (is_dir($currentPath)) {
                        removeDirectory($currentPath);
                    } else {
                        unlink($currentPath);
                    }
                }
            }
            // Remove the directory itself
            rmdir($path);
        }
    }
    public function insertKycData(Request $request)
    {

        $id = $request->outer_staff_id ?? '';
        $data = '';
        $validator      = Validator::make($request->all(), [
            'date_of_birth' => 'required|date_format:Y-m-d',
            'gender' => 'required',
            'marital_status' => 'required',
            'marriage_date' => 'required_if:marital_status,==,married',
            'language_id' => 'required',
            'place_of_birth_id' => 'required',
            'nationality_id' => 'required',
            'religion_id' => 'required',
            'caste_id' => 'required',
            'community_id' => 'required',
            'emergency_no' => 'required|numeric|digits:10',
            'mobile_no_1' => 'nullable|numeric|digits:10',
            'mobile_no_2' => 'nullable|numeric|digits:10',
            'whatsapp_no' => 'nullable|numeric|digits:10',
            'contact_address' => 'required',
            'permanent_address' => 'required',
            'outer_staff_id' => 'required',

        ]);

        if ($validator->passes()) {
            $staff_info = User::find($id);
            $academic_id = academicYearId();
            /**
             * 1.insert in staff_personal_info
             * 2.insert in staff_bank_details
             * 3.insert in staff_pf_esi_details
             */
            if(isset($request->status) && !empty($request->status)){
                $staff_info->status=$request->status;
            }
            $staff_info->is_super_admin=$request->is_super_admin;
            $staff_info->save();
            $ins['academic_id'] = $academic_id;
            $ins['staff_id'] = $id;
            $ins['dob'] = date('Y-m-d', strtotime($request->date_of_birth));
            $ins['mother_tongue'] = $request->language_id;
            $ins['gender'] = strtolower($request->gender);
            $ins['marital_status'] = strtolower($request->marital_status);
            $ins['marriage_date'] = $request->marital_status == 'married' ? date('Y-m-d', strtotime($request->marriage_date)) : null;
            $ins['phone_no'] = $request->phone_no;
            $ins['mobile_no1'] = $request->mobile_no_1;
            $ins['mobile_no2'] = $request->mobile_no_2;
            $ins['whatsapp_no'] = $request->whatsapp_no;
            $ins['pincode'] = $request->pincode ?? null;
            $ins['emergency_no'] = $request->emergency_no;
            $ins['birth_place'] = $request->place_of_birth_id;
            $ins['nationality_id'] = $request->nationality_id;
            $ins['religion_id'] = $request->religion_id;
            $ins['caste_id'] = $request->caste_id;
            $ins['community_id'] = $request->community_id;
            $ins['contact_address'] = $request->contact_address;
            $ins['permanent_address'] = $request->permanent_address;
            $ins['status'] = 'active';
           
            if ($request->hasFile('profile_image')) {
                $directory_path= storage_path('app/public/staff/' . $staff_info->emp_code . '/profile');
                if (file_exists($directory_path)) {
                    $this->removeDirectory($directory_path);
                }
                $files = $request->file('profile_image');
                $imageName =$staff_info->institute_emp_code.'.'.$files->getClientOriginalExtension();
                $directory='staff/' . $staff_info->emp_code . '/profile';
                $filename               = $directory . '/' . $imageName;
                Storage::disk('public')->put($filename, File::get($files));
                // $ins['image'] = $filename;
                $staff_info->image = $filename;
                $staff_info->save();
            }

            // profile_image
            StaffPersonalInfo::updateOrCreate(['staff_id' => $id], $ins);

            if (!empty($request->uan_no) && $request->is_uan == 'yes') {

                $insEsi['academic_id'] = $academic_id;
                $insEsi['staff_id'] = $id;
                $insEsi['ac_number'] = $request->uan_no;
                $insEsi['type'] = 'pf';
                $insEsi['start_date'] = $request->uan_start_date ? date('Y-m-d', strtotime($request->uan_start_date)) : null;
                $insEsi['name'] = $request->uan_name;
                $insEsi['status'] = 'active';

                if ($request->hasFile('uan_document')) {

                    $files = $request->file('uan_document');
                    $imageName = uniqid() . Str::replace(' ', "-", $files->getClientOriginalName());

                    $directory              = 'staff/' . $staff_info->emp_code . '/uan';
                    $filename               = $directory . '/' . $imageName;

                    Storage::disk('public')->put($filename, File::get($files));
                    // $ins['image'] = $filename;
                    $insEsi['document'] = $filename;
                }

                StaffPfEsiDetail::updateOrCreate(['staff_id' => $id, 'type' => 'pf'], $insEsi);
            } else {
                StaffPfEsiDetail::where(['staff_id' => $id, 'type' => 'pf'])->delete();
            }

            if (!empty($request->esi_no) && $request->is_esi == 'yes') {
                $insEsi = [];
                $insEsi['academic_id'] = $academic_id;
                $insEsi['staff_id'] = $id;
                $insEsi['ac_number'] = $request->esi_no;
                $insEsi['type'] = 'esi';
                $insEsi['start_date'] = isset($request->esi_start_date) && !empty($request->esi_start_date) ? date('Y-m-d', strtotime($request->esi_start_date)) : null;
                $insEsi['end_date'] = isset($request->esi_end_date) && !empty($request->esi_end_date) ? date('Y-m-d', strtotime($request->esi_end_date)) : null;
                $insEsi['location'] = $request->esi_address;
                $insEsi['name'] = $request->esi_name;
                $insEsi['status'] = 'active';

                if ($request->hasFile('esi_document')) {

                    $files = $request->file('esi_document');
                    $imageName = uniqid() . Str::replace(' ', "-", $files->getClientOriginalName());

                    $directory              = 'staff/' . $staff_info->emp_code . '/esi';
                    $filename               = $directory . '/' . $imageName;

                    Storage::disk('public')->put($filename, File::get($files));
                    // $ins['image'] = $filename;
                    $insEsi['document'] = $filename;
                }
                StaffPfEsiDetail::updateOrCreate(['staff_id' => $id, 'type' => 'esi'], $insEsi);
            } else {
                StaffPfEsiDetail::where(['staff_id' => $id, 'type' => 'esi'])->delete();
            }

            if ($request->bank_id) {

                $insBank['academic_id'] = $academic_id;
                $insBank['staff_id'] = $id;
                $insBank['bank_id'] = $request->bank_id;
                $insBank['bank_branch_id'] = $request->branch_id;
                $insBank['account_name'] = $request->account_name ??null;
                $insBank['account_number'] = $request->account_no ??null;
                /** 
                 *  check file is exists
                 */
                if ($request->hasFile('bank_passbook')) {

                    $files = $request->file('bank_passbook');
                    $imageName = uniqid() . Str::replace(' ', "-", $files->getClientOriginalName());

                    $directory              = 'staff/' . $staff_info->emp_code . '/bank';
                    $filename               = $directory . '/' . $imageName;

                    Storage::disk('public')->put($filename, File::get($files));
                    $insBank['passbook_image'] = $filename;
                }

                if ($request->hasFile('cancelled_cheque')) {

                    $files = $request->file('cancelled_cheque');
                    $imageName = uniqid() . Str::replace(' ', "-", $files->getClientOriginalName());

                    $directory              = 'staff/' . $staff_info->emp_code . '/bank';
                    $filename               = $directory . '/' . $imageName;

                    Storage::disk('public')->put($filename, File::get($files));
                    $insBank['cancelled_cheque'] = $filename;
                }
                $insBank['status'] = 'active';

                StaffBankDetail::updateOrCreate(['staff_id' => $id], $insBank);
            }

            $error      = 0;
            $message    = '';
        } else {
            $error      = 1;
            $message    = $validator->errors()->all();
        }
        return response()->json(['error' => $error, 'message' => $message, 'id' => $id ?? '']);
    }
   

    public function insertEmployeePosition(Request $request)
    {
        #subjectid_classid
        $id = $request->id ?? '';
        $global_is_teaching = $request->global_is_teaching;
        $data = '';
        $validateArray = [
            'designation_id' => 'required',
            'department_id' => 'required',
            // 'subject' => 'required',
            'scheme_id' => 'required',
            // 'class_id' => 'required',
            // 'division_id' => 'required',
        ];
        if ($global_is_teaching) {
            $validateArray = [
                'designation_id' => 'required',
                'department_id' => 'required',
                'scheme_id' => 'required',
                // 'division_id' => 'required',
            ];
        }

        $validator      = Validator::make($request->all(), $validateArray);

        if ($validator->passes()) {

            $academic_id = academicYearId();
            /***
             * 1. insert in staff_professional_datas
             * 2. insert in staff_experienced_subjects
             * 3. insert in staff_studied_subjects
             */
            $ins['academic_id'] = $academic_id;
            $ins['staff_id'] = $id;
            $ins['designation_id'] = $request->designation_id;
            $ins['department_id'] = $request->department_id;
            $ins['division_id'] = $request->division_id ?? null;
            $ins['attendance_scheme_id'] = $request->scheme_id;
            $ins['status'] = 'active';
            $ins['is_teaching_staff'] = $global_is_teaching ? 'no' : 'yes';
            StaffProfessionalData::updateOrCreate(['staff_id' => $id], $ins);

            $data = User::find($id);
            if ($request->class_id) {
                StaffClass::where('staff_id', $data->id)->delete();
                foreach ($request->class_id as $item) {
                    $cls = [];
                    $cls['staff_id'] = $data->id;
                    $cls['academic_id'] = $academic_id;
                    $cls['class_id'] = $item;
                    StaffClass::create($cls);
                }
            }

            if ($request->subject && !empty($request->subject)) {
                StaffExperiencedSubject::where('staff_id', $id)->delete();
                foreach ($request->subject as $items) {
                    $ins1 = [];
                    $ins1['academic_id'] = $academic_id;
                    $ins1['staff_id'] = $id;
                    $ins1['subject_id'] = $items;
                    $ins1['status'] = 'active';
                    StaffExperiencedSubject::create($ins1);
                }
            }

            if ($request->handled && !empty($request->handled)) {
                StaffHandlingSubject::where('staff_id', $id)->delete();
                foreach ($request->handled as $item) {
                    $ids = explode('_', $item);
                    $class_id = $ids[1];
                    $subject_id = $ids[0];
                    $ins2 = [];
                    $ins2['academic_id'] = $academic_id;
                    $ins2['staff_id'] = $id;
                    $ins2['subject_id'] = $subject_id;
                    $ins2['class_id'] = $class_id;
                    $ins2['status'] = 'active';
                    StaffHandlingSubject::create($ins2);
                }
            }

            StaffStudiedSubject::where('staff_id', $id)->delete();
            if (config('constant.staff_studied_subjects')) {

                foreach (config('constant.staff_studied_subjects') as $sitems) {

                    if ($_POST['studied_' . $sitems] ?? '') {
                        $sub_data = explode('_', $_POST['studied_' . $sitems]);
                        $ins2 = [];
                        $ins2['academic_id'] = $academic_id;
                        $ins2['staff_id'] = $id;
                        $ins2['subjects'] = $sitems;
                        $ins2['classes'] = end($sub_data);
                        $ins2['status'] = 'active';
                        StaffStudiedSubject::create($ins2);
                    }
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

    public function insertEducationDetails(Request $request)
    {
        /**
         * 1. insert known languages
         */
        $staff_id = $request->id;
        $academic_id = academicYearId();
        StaffKnownLanguage::where('staff_id', $staff_id)->delete();
        if ($request->speak && !empty($request->speak)) {
            foreach ($request->speak as $item) {
                $ins = [];
                $ins['academic_id'] = $academic_id;
                $ins['staff_id'] = $staff_id;
                $ins['language_id'] = $item;
                $ins['speak'] = true;
                $ins['status'] = 'active';

                StaffKnownLanguage::updateOrCreate(['staff_id' => $staff_id, 'language_id' => $item], $ins);
            }
        }


        if ($request->read && !empty($request->read)) {
            foreach ($request->read as $item) {
                $ins = [];
                $ins['academic_id'] = $academic_id;
                $ins['staff_id'] = $staff_id;
                $ins['language_id'] = $item;
                $ins['read'] = true;
                $ins['status'] = 'active';

                StaffKnownLanguage::updateOrCreate(['staff_id' => $staff_id, 'language_id' => $item], $ins);
            }
        }

        if ($request->write && !empty($request->write)) {
            foreach ($request->write as $item) {
                $ins = [];
                $ins['academic_id'] = $academic_id;
                $ins['staff_id'] = $staff_id;
                $ins['language_id'] = $item;
                $ins['write'] = true;
                $ins['status'] = 'active';

                StaffKnownLanguage::updateOrCreate(['staff_id' => $staff_id, 'language_id' => $item], $ins);
            }
        }

        $sports = $request->sports;
        $fine_arts = $request->fine_arts;
        $vocational = $request->vocational;
        $others = $request->others;

        $ins1['academic_id'] = $academic_id;
        $ins1['staff_id'] = $staff_id;
        $ins1['status'] = 'active';

        if (isset($sports) && !empty($sports)) {
            $ins1['talent_fields'] = 'sports';
            $ins1['talent_descriptions'] = $request->sports;
            StaffTalent::updateOrCreate(['staff_id' => $staff_id, 'talent_fields' => 'sports'], $ins1);
        }

        if (isset($fine_arts) && !empty($fine_arts)) {
            $ins1['talent_fields'] = 'fine_arts';
            $ins1['talent_descriptions'] = $request->fine_arts;
            StaffTalent::updateOrCreate(['staff_id' => $staff_id, 'talent_fields' => 'fine_arts'], $ins1);
        }

        if (isset($vocational) && !empty($vocational)) {
            $ins1['talent_fields'] = 'vocational';
            $ins1['talent_descriptions'] = $request->vocational;
            StaffTalent::updateOrCreate(['staff_id' => $staff_id, 'talent_fields' => 'vocational'], $ins1);
        }

        if (isset($others) && !empty($others)) {
            $ins1['talent_fields'] = 'others';
            $ins1['talent_descriptions'] = $request->others;
            StaffTalent::updateOrCreate(['staff_id' => $staff_id, 'talent_fields' => 'others'], $ins1);
        }

        return response()->json(['error' => 0, 'message' => 'Added success']);
    }

    public function checkFamilyData(Request $request)
    {
        $staff_id = $request->staff_id;

        $members = StaffFamilyMember::where('status', 'active')->where('staff_id', $staff_id)->get();
        $nominees = StaffNominee::where('staff_id', $staff_id)->get();

        if (isset($members) && count($members) > 0 && isset($nominees) && count($nominees) > 0) {
            $error = '0';
            $message = 'Added Success';
        } else {
            $error = '1';
            $message = 'Family Details and Nominee Details are required';
        }

        return response()->json(['error' => $error, 'message' => [$message]]);
    }

    public function list(Request $request)
    {

        $breadcrums = array(
            'title' => 'Staff Management',
            'breadcrums' => array(
                array(
                    'link' => '', 'title' => 'Staff List'
                ),
            )
        );
        if ($request->ajax()) {
            $staff_datable_search = $request->staff_datable_search;

            $totalFilteredRecord = $totalDataRecord = $draw_val = "";
            $columns_list = array(
                0 => 'name',
                1 => 'society_code',
                2 => 'institute_code',
                3 => 'verification_status',
            );

            $verification_status = $request->verification_status ?? '';
            $datatable_institute_id = $request->datatable_institute_id ?? '';

            $totalDataRecord = User::select('users.*', 'institutions.name as institute_name')
                ->leftJoin('institutions', 'institutions.id', 'users.institute_id')
                ->with([
                    'personal',
                    'position',
                    'StaffDocument',
                    'StaffEducationDetail',
                    'familyMembers',
                    'nominees',
                    'healthDetails',
                    'StaffWorkExperience',
                    'knownLanguages',
                    'studiedSubject',
                    'bank',
                    'appointment'
                ])
                ->when(!empty( $verification_status ), function($q) use($verification_status){
                    $q->where('users.verification_status', $verification_status);
                })
                ->when(!empty( $datatable_institute_id ), function($q) use($datatable_institute_id){
                    $q->where('users.institute_id', $datatable_institute_id);
                })
                ->InstituteBased()
                ->where('users.status', 'active')
                ->count();

            $totalFilteredRecord = $totalDataRecord;

            $limit_val = $request->input('length');
            $start_val = $request->input('start');
            $order_val = $columns_list[$request->input('order.0.column')];
            $dir_val = $request->input('order.0.dir');

            $search_text = $staff_datable_search;
           

            $post_data = User::select('users.*', 'institutions.name as institute_name','society_emp_code as society_code','institute_emp_code as institute_code')
                ->leftJoin('institutions', 'institutions.id', 'users.institute_id')
                ->with([
                    'personal',
                    'position',
                    'StaffDocument',
                    'StaffEducationDetail',
                    'familyMembers',
                    'nominees',
                    'healthDetails',
                    'StaffWorkExperience',
                    'knownLanguages',
                    'studiedSubject',
                    'bank',
                    'appointment'
                ])
               
                ->when(!empty($staff_datable_search), function ($q) use ($search_text) {
                    $q->where('users.id',$search_text);
                    // $q->where('users.name', 'like', "%{$search_text}%")
                        // ->orWhere('users.status', 'like', "%{$search_text}%")
                        // ->orWhere('users.email', 'like', "%{$search_text}%")
                        // ->orWhere('users.emp_code', 'like', "%{$search_text}%")
                        // ->orWhere('users.society_emp_code', 'like', "%{$search_text}%")
                        // ->orWhere('users.institute_emp_code', 'like', "%{$search_text}%")
                        // ->orWhere('users.first_name_tamil', 'like', "%{$search_text}%");
                })
                ->when(!empty( $verification_status ), function($q) use($verification_status){
                    $q->where('users.verification_status', $verification_status);
                })
                ->when(!empty( $datatable_institute_id ), function($q) use($datatable_institute_id){
                    $q->where('users.institute_id', $datatable_institute_id);
                })
            ->InstituteBased()
                ->orderBy($order_val,$dir_val);
            
           
            if ($limit_val > 0) {
                $post_data = $post_data->offset($start_val)->limit($limit_val)->get();
            } else {
                $post_data = $post_data->get();
            }

            if (!empty($staff_datable_search)) {

                $totalFilteredRecord = User::select('users.*', 'institutions.name as institute_name')
                    ->leftJoin('institutions', 'institutions.id', 'users.institute_id')
                    ->with([
                        'personal',
                        'position',
                        'StaffDocument',
                        'StaffEducationDetail',
                        'familyMembers',
                        'nominees',
                        'healthDetails',
                        'StaffWorkExperience',
                        'knownLanguages',
                        'studiedSubject',
                        'bank',
                        'appointment'
                    ])
                   
                    ->when(!empty($staff_datable_search), function ($q) use ($search_text) {
                    $q->where('users.name', 'like', "%{$search_text}%")
                        ->orWhere('users.status', 'like', "%{$search_text}%")
                        ->orWhere('users.email', 'like', "%{$search_text}%")
                        ->orWhere('users.emp_code', 'like', "%{$search_text}%")
                        ->orWhere('users.society_emp_code', 'like', "%{$search_text}%")
                        ->orWhere('users.institute_emp_code', 'like', "%{$search_text}%")
                        ->orWhere('users.first_name_tamil', 'like', "%{$search_text}%");
                })
                ->when(!empty( $verification_status ), function($q) use($verification_status){
                    $q->where('users.verification_status', $verification_status);
                })
                ->when(!empty( $datatable_institute_id ), function($q) use($datatable_institute_id){
                    $q->where('users.institute_id', $datatable_institute_id);
                })
                    ->InstituteBased()
                    
                    ->count();
                    

            }


            $data_val = array();
            if (!empty($post_data)) {
                foreach ($post_data as $post_val) {

                    $edit_btn = $view_btn = $print_btn = $del_btn = '';

                    $completed_percentage = getStaffProfileCompilationData($post_val->id, 'object');
                    // dump( $completed_percentage );
                    $profile_status = '
                            <div class="d-flex align-items-center w-100px w-sm-200px flex-column mt-3">
                                <div class="d-flex justify-content-between w-100 mt-auto">
                                    <span class="fw-semibold fs-6 text-gray-400">' . ucwords($post_val->verification_status) . '</span>
                                    <span class="fw-bold fs-6">' . $completed_percentage . '%</span>
                                </div>
                                <div class="h-5px mx-3 w-100 bg-light">
                                    <div class="bg-success rounded h-5px" role="progressbar" aria-valuenow="' . $completed_percentage . '" aria-valuemin="0" aria-valuemax="100" style="width: ' . $completed_percentage . '%;"></div>
                                </div>
                            </div>';

                    $route_name = request()->route()->getName();
                    if (access()->buttonAccess($route_name, 'add_edit') && $post_val->status != 'transferred') {
                        $edit_btn = '<a href="' . route('staff.register', ['id' => $post_val->id]) . '"  class="btn btn-icon btn-active-primary btn-light-primary mx-1 w-30px h-30px" > 
                        <i class="fa fa-edit"></i>
                        </a>';
                    }
                    if (access()->buttonAccess($route_name, 'delete') && $post_val->status != 'transferred') {
                        $del_btn = '<a href="javascript:void(0);" onclick="deleteStaff(' . $post_val->id . ')" class="btn btn-icon btn-active-danger btn-light-danger mx-1 w-30px h-30px" > 
                        <i class="fa fa-trash"></i></a>';
                    }

                    $view_btn = '<a href="' . route('staff.view', ['user' => $post_val->id]) . '"  class="btn btn-icon btn-active-info btn-light-info mx-1 w-30px h-30px" > 
                                    <i class="fa fa-eye"></i>
                                </a>';

                    $print_btn = '<a target="_blank" href="' . route('staff.print', ['user' => $post_val->id]) . '"  class="btn btn-icon btn-active-info btn-light-dark mx-1 w-30px h-30px" > 
                                    <i class="fa fa-print"></i>
                                </a>';
                 $route_name = request()->route()->getName();
                   
                    if( access()->buttonAccess($route_name, 'add_edit') &&  $post_val->transfer_status == 'active' ){
                        $status_class = ($post_val->status == 'active') ? 'success' :
                        (in_array($post_val->status, ['resigned', 'retired', 'expired']) ? 'danger' :
                        ($post_val->status == 'transferred' ? 'primary' : 'warning'));
                        $status_btn = '<a href="javascript:void(0);" class="badge badge-light-' . $status_class . '" tooltip="Click to ' . ucwords($post_val->status) . '"';
                        if ($post_val->status == 'active' || $post_val->status == 'inactive') {
                            $status_btn .= ' onclick="return staffChangeStatus(' . $post_val->id . ', \'' . ($post_val->status == 'active' ? 'inactive' : 'active') . '\')"';
                        }
                        $status_btn .= '>' . ucfirst($post_val->status) . '</a>';
                    } else {
                        $edit_btn = '';
                        $del_btn = '';
                        $status_btn = '<a href="javascript:void(0);" class="badge badge-light-success" ">' . ucfirst($post_val->transfer_status) . '</a>';

                    }
                                
                    $postnestedData['checkbox'] = '<input type="checkbox" role="button" name="staff_ids_action[]" class="revision_check" value="' . $post_val->id . '">';
                    $postnestedData['name'] = $post_val->name;
                    $postnestedData['society_code'] = $post_val->society_emp_code;
                    $postnestedData['institute_code'] = $post_val->institute_emp_code;
                    $postnestedData['profile'] = $profile_status;
                    $postnestedData['status'] = $status_btn;
                    $postnestedData['actions'] = '<div class="w-100 text-end">' . $edit_btn . $view_btn . $print_btn . $del_btn . '</div>';
                    $data_val[] = $postnestedData;
                }
            }
            $draw_val = $request->input('draw');
            
            $get_json_data = array(
                "draw"            => intval($draw_val),
                "recordsTotal"    => intval($totalDataRecord),
                "recordsFiltered" => intval($totalFilteredRecord),
                "data"            => $data_val
            );

            return json_encode($get_json_data);
        }
        $users=User::where('institute_id', $datatable_institute_id)->get();
        $institutions = Institution::where('status', 'active')->get();
        return view('pages.staff.list', compact('breadcrums', 'institutions','users'));
    }

    public function list1(Request $request)
    {

        $breadcrums = array(
            'title' => 'Staff Management',
            'breadcrums' => array(
                array(
                    'link' => '', 'title' => 'Staff List'
                ),
            )
        );
        if ($request->ajax()) {

            $query = User::select('users.*', 'institutions.name as institute_name')
                ->leftJoin('institutions', 'institutions.id', 'users.institute_id')
                ->with([
                    'personal',
                    'position',
                    'StaffDocument',
                    'StaffEducationDetail',
                    'familyMembers',
                    'nominees',
                    'healthDetails',
                    'StaffWorkExperience',
                    'knownLanguages',
                    'studiedSubject',
                    'bank',
                    'appointment'
                ]);
               

            $data = $query->get()->sortByDesc('society_emp_code')->values();

            $status = $request->get('status');
            $datatable_search = $request->datatable_search ?? '';
            $keywords = $datatable_search;
            $datatables = Datatables::of($data)
                ->filter(function ($query) use ($keywords, $status) {
                    if ($keywords) {
                        $date = date('Y-m-d', strtotime($keywords));
                        return $query->where(function ($q) use ($keywords, $date) {

                            $q->where('users.name', 'like', "%{$keywords}%")
                                ->orWhere('users.status', 'like', "%{$keywords}%")
                                ->orWhere('users.email', 'like', "%{$keywords}%")
                                ->orWhere('users.emp_code', 'like', "%{$keywords}%")
                                ->orWhere('users.society_emp_code', 'like', "%{$keywords}%")
                                ->orWhere('users.institute_emp_code', 'like', "%{$keywords}%")
                                ->orWhere('users.first_name_tamil', 'like', "%{$keywords}%")
                                ->orWhereDate("users.created_at", $date);
                        });
                    }
                })
                ->addIndexColumn()
                ->editColumn('verification_status', function ($row) {
                    // $completed_percentage = getStaffProfileCompilationData($row);
                    $completed_percentage = 0;
                    $status = '
                            <div class="d-flex align-items-center w-100px w-sm-200px flex-column mt-3">
                                <div class="d-flex justify-content-between w-100 mt-auto">
                                    <span class="fw-semibold fs-6 text-gray-400">' . ucwords($row->verification_status) . '</span>
                                    <span class="fw-bold fs-6">' . $completed_percentage . '%</span>
                                </div>
                                <div class="h-5px mx-3 w-100 bg-light">
                                    <div class="bg-success rounded h-5px" role="progressbar" aria-valuenow="' . $completed_percentage . '" aria-valuemin="0" aria-valuemax="100" style="width: ' . $completed_percentage . '%;"></div>
                                </div>
                            </div>';
                    return $status ?? '';
                })
                ->editColumn('status', function ($row) {
                    $status = '<a href="javascript:void(0);" class="badge badge-light-' . (($row->status == 'active') ? 'success' : 'danger') . '" tooltip="Click to ' . ucwords($row->status) . '" onclick="return staffChangeStatus(' . $row->id . ',\'' . ($row->status == 'active' ? 'inactive' : 'active') . '\')">' . ucfirst($row->status) . '</a>';
                    return $status;
                })
                ->editColumn('name', function ($row) {
                    // return $row->name.' <i class="fas fa-certificate text-success"></i>';
                    return $row->name;
                })
                ->editColumn('institute_name', function ($row) {
                    return $row->institute->name ?? '';
                })
                ->editColumn('created_at', function ($row) {
                    $created_at = Carbon::createFromFormat('Y-m-d H:i:s', $row->created_at)->format('d-m-Y');
                    return $created_at;
                })
                ->addColumn('action', function ($row) {
                    $route_name = request()->route()->getName();
                    if (access()->buttonAccess($route_name, 'add_edit')) {
                        $edit_btn = '<a href="' . route('staff.register', ['id' => $row->id]) . '"  class="btn btn-icon btn-active-primary btn-light-primary mx-1 w-30px h-30px" > 
                        <i class="fa fa-edit"></i>
                        </a>';
                    } else {
                        $edit_btn = '';
                    }
                    if (access()->buttonAccess($route_name, 'delete')) {
                        $del_btn = '<a href="javascript:void(0);" onclick="deleteStaff(' . $row->id . ')" class="btn btn-icon btn-active-danger btn-light-danger mx-1 w-30px h-30px" > 
                        <i class="fa fa-trash"></i></a>';
                    } else {
                        $del_btn = '';
                    }

                    $view_btn = '<a href="' . route('staff.view', ['user' => $row->id]) . '"  class="btn btn-icon btn-active-info btn-light-info mx-1 w-30px h-30px" > 
                                    <i class="fa fa-eye"></i>
                                </a>';

                    $print_btn = '<a target="_blank" href="' . route('staff.print', ['user' => $row->id]) . '"  class="btn btn-icon btn-active-info btn-light-dark mx-1 w-30px h-30px" > 
                                    <i class="fa fa-print"></i>
                                </a>';

                    return $edit_btn . $view_btn . $print_btn . $del_btn;
                })
                ->rawColumns(['action', 'status', 'verification_status', 'name']);

            return $datatables->make(true);
        }
        return view('pages.staff.list', compact('breadcrums'));
    }

    public function changeStatus(Request $request)
    {
        $id             = $request->id;
        $status         = $request->status;
        $info           = User::find($id);
        $info->status   = $status;
        $info->update();
        return response()->json(['message' => "You changed the Staff status!", 'status' => 1]);
    }

    public function generateOverviewPdf(Request $request)
    {
        // retreive all records from db
        $data = User::all();
        $pdf = PDF::loadView('pages.staff.pdf.staff_overview', array('data' => $data))->setPaper('a4', 'landscape');
        // download PDF file with download method
        return $pdf->download('pdf_file.pdf');
    }

    public function view(Request $request, User $user)
    {

        $breadcrums = array(
            'title' => 'Staff Details',
            'breadcrums' => array(
                array('link' => route('staff.list'), 'title' => 'Staff Management'),
                array('link' => '', 'title' => 'Staff Details')
            )
        );

        $staff_id = $user->status == 'transferred' ? $user->refer_user_id : $user->id;
        $personal_doc    = StaffDocument::where('staff_id', $staff_id)->get();
        $education_doc   = StaffEducationDetail::where('staff_id', $staff_id)->get();
        $experince_doc   = StaffWorkExperience::where('staff_id', $staff_id)->get();
        $other_docs    = StaffDocument::whereNotIn('document_type_id',[1,2,3,4,5,6])->where('staff_id',$staff_id)->get();
        $acadamic_id     = academicYearId();
        $leave_doc       = StaffLeave::where('staff_id', $staff_id)->where('academic_id', $acadamic_id)->get();
        $appointment_doc = StaffAppointmentDetail::where('staff_id', $staff_id)->get();
        $salary_doc      = StaffSalary::where('staff_id', $staff_id)->get();
        $from_view = 'user';
        $info = User::find( $user->id);

        $from_year=AcademicYear::find(academicYearId());
        $year=$from_year->from_year;
        $firstDayOfYear = date("$year-01-01"); 
        $lastDayOfYear = date("$year-12-31");
        $total_year = (strtotime($lastDayOfYear) - strtotime($firstDayOfYear)) / (60 * 60 * 24) + 1;
        $loans=StaffBankLoan::with('emi','paid_emi')->where('staff_id',$user->id)->where('status','active')->get();
        $working_days=CalendarDays::where('days_type','working_day')->where('academic_id', $acadamic_id)->count();
        $present=AttendanceManualEntry::where('employment_id',$user->id)->where('academic_id', $acadamic_id)
                ->where('attendance_status', 'Present')->where('status','active')->count();
        $absence=AttendanceManualEntry::where('employment_id',$user->id)->where('academic_id', $acadamic_id)
                ->where('attendance_status', 'Absence')->where('status','active')->count();

        return view('pages.overview.index', compact('info', 'breadcrums', 'user', 'personal_doc', 'salary_doc', 'education_doc', 'experince_doc', 'leave_doc', 'appointment_doc', 'from_view','total_year','loans','working_days','present','absence','other_docs'));

    }

    public function print(Request $request, User $user)
    {
        $classes = Classes::where('status', 'active')->get();
        $subjects = Subject::where('status', 'active')->get();
        $joining = StaffAppointmentDetail::selectRaw('min(joining_date) as joining_date')->where('staff_id', $user->id)->first();
        $studied_subjects = DB::select('select count(*), subject_id from staff_studied_subjects where staff_id = ' . $user->id . ' group by subject_id');

        $subject_handling = DB::select("SELECT 
                                    COUNT(*) AS subject_count,
                                    STUFF((
                                    SELECT ',' + CAST(subject_id AS VARCHAR(10))
                                    FROM staff_handling_subjects
                                    where staff_id = " . $user->id . "
                                    group by subject_id
                                    FOR XML PATH(''), TYPE
                                    ).value('.', 'NVARCHAR(MAX)'), 1, 1, '') AS concatenated_subjects
                                FROM staff_handling_subjects s ");

        if (isset($subject_handling[0]) && $subject_handling[0]->subject_count > 0) {

            $string_comes = $subject_handling[0]->concatenated_subjects;
            $string_comes = explode(",", $string_comes);
            $subject_details = Subject::whereIn('id', $string_comes)->get();
        }

        $class_handling = DB::select("SELECT 
                                    COUNT(*) AS class_count,
                                    STUFF((
                                    SELECT ',' + CAST(class_id AS VARCHAR(10))
                                    FROM staff_handling_subjects
                                    where staff_id = " . $user->id . "
                                    group by class_id
                                    FOR XML PATH(''), TYPE
                                    ).value('.', 'NVARCHAR(MAX)'), 1, 1, '') AS concatenated_subjects
                                FROM staff_handling_subjects s ");
        if (isset($class_handling[0]) && $class_handling[0]->class_count > 0) {

            $class_string = $class_handling[0]->concatenated_subjects;
            $class_string = explode(",", $class_string);
            $class_details = Classes::whereIn('id', $class_string)->get();
        }

        $params = array(
            'user' => $user,
            'joining' => $joining,
            'subjects' => $subjects,
            'classes' => $classes,
            'class_details' => $class_details ?? [],
            'subject_details' => $subject_details ?? []
        );

        return view('pages.overview.print_view.print', $params);
    }

    public function getStaffHandlingDetails(Request $request)
    {

        $class_handling = $request->class_handling;
        $subject_handling = $request->subject_handling;
        $subject_details = [];
        $class_details = [];
        $staff_id = $request->staff_id;
        $staff_details = User::find($staff_id);
        if (!empty($subject_handling)) {
            $subject_details = Subject::whereIn('id', $subject_handling)->get();
        }

        if (!empty($class_handling)) {
            $class_details = Classes::whereIn('id', $class_handling)->get();
        }

        return view('pages.staff.registration.emp_position._handling_subject', compact('subject_details', 'class_details', 'staff_details'));

    }

    public function deleteStaff(Request $request) {

        $staff_id = $request->id;

        User::where('id', $staff_id)->delete();

        return response()->json(['message' => "You deleted", 'status' => 1]);
        
    }

    public function generateEmployeeCode(Request $request) {

        $staff_id = $request->staff_id;
        $error = 0;
        $message = 'Successfully Generated';
        if (canGenerateEmpCode($staff_id)) {
            /**
             * generate emp code   // society_emp_code, institute_emp_code
             */
            $staff_info = User::find($staff_id);
            $staff_info->is_super_admin=$request->is_super_admin ?? Null;
            $staff_info->update();
            if (!$staff_info->society_emp_code) {

                $staff_info->society_emp_code = getStaffEmployeeCode();
                $staff_info->save();
            }
            if (!$staff_info->institute_emp_code) {

                $staff_info->institute_emp_code = getStaffInstitutionCode($staff_info->institute_id);
                $staff_info->save();
            }
        } else {
            $error = 1;
            $message = 'Please complete Data entry, Document upload and Verification';
        }

        return array('error' => $error, 'message' => $message );
    }
     public function Information_add_edit(Request $request)
    {
        $id = $request->id;
        $info = [];
        $title = 'Edit Leave Mapping';
        $teaching_types=[];
        $employment_nature = [];
       
        if(isset($id) && !empty($id))
        {
            $info = StaffLeaveMapping::find($id);
            $title = 'Update Leave Mapping';
            $leave_head=LeaveHead::find($info->leave_head_id);
        }

         $content = view('pages.staff.registration.other_information.add_edit_form',compact('info','title','leave_head'));
         return view('layouts.modal.dynamic_modal', compact('content', 'title','leave_head'));
    }
     public function UpdateLeaveMapping(Request $request)
    {    
         $id=$request->id;
         if($id){
         $info = StaffLeaveMapping::find($id);
         $info->no_of_leave=$request->no_of_leave;
         $info->save();
         $error = 0;

         $message = 'Updated successfully';
         }else {
            $error = 1;
            $message = 'Data Not Found';
        }
    return array('error' => $error, 'message' => $message );
    }
}
