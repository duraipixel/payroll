<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Master\BoardController;
use App\Models\Master\AppointmentOrderModel;
use App\Models\Master\AttendanceScheme;
use App\Models\Master\Bank;
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
use App\Models\ReportingManager;
use App\Models\Staff\StaffAppointmentDetail;
use App\Models\Staff\StaffBankDetail;
use App\Models\Staff\StaffClass;
use App\Models\Staff\StaffDocument;
use App\Models\Staff\StaffEducationDetail;
use App\Models\Staff\StaffExperiencedSubject;
use App\Models\Staff\StaffFamilyMember;
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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use DataTables;
use Carbon\Carbon;
use PDF;

class StaffController extends Controller
{
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
        }

        $other_staff = User::with('institute')->where('status', 'active')
            ->where('is_super_admin', null)
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
        $other_schools = OtherSchool::where('status', 'active')->get();
        $mother_tongues = Language::where('status', 'active')->get();
        $nationalities = Nationality::where('status', 'active')->get();
        $places = OtherSchoolPlace::where('status', 'active')->get();
        $religions = Religion::where('status', 'active')->get();
        $castes = Caste::where('status', 'active')->get();
        $communities = Community::where('status', 'active')->get();
        $banks = Bank::where('status', 'active')->get();

        #phase3
        $designation = Designation::where('status', 'active')->get();
        $department = Department::where('status', 'active')->get();
        $subjects = Subject::where('status', 'active')->get();
        $scheme = AttendanceScheme::where('status', 'active')->get();
        $training_topics = TopicTraining::where('status', 'active')->get();

        #phase4
        $boards = Board::where('status', 'active')->get();
        $types = ProfessionType::where('status', 'active')->get();

        #phase5
        $relation_types = RelationshipType::where('status', 'active')->get();
        $blood_groups = BloodGroup::where('status', 'active')->get();
        $qualificaiton = Qualification::where('status', 'active')->get();

        #phase7
        $staff_category = StaffCategory::where('status', 'active')->get();
        $employments = NatureOfEmployment::where('status', 'active')->get();
        $teaching_types = TeachingType::where('status', 'active')->get();
        $place_of_works = PlaceOfWork::where('status', 'active')->get();
        $order_models = AppointmentOrderModel::where('status', 'active')->get();

        $step = getRegistrationSteps($id);

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
            'email' => 'required|string|unique:users,email,' . $id,
            'previous_code' => 'required'
            // 'previous_code' => 'required|string|unique:users,emp_code,'.$id,
        ]);

        if ($validator->passes()) {

            $academic_id = academicYearId();

            $ins['name'] = $request->name;
            $ins['email'] = $request->email;
            $ins['institute_id'] = $request->institute_name;
            $ins['academic_id'] = $academic_id;
            $ins['emp_code'] = $request->previous_code;
            $ins['locker_no'] = 'AMIDL' . $request->previous_code;
            $ins['first_name_tamil'] = $request->first_name_tamil;
            $ins['short_name'] = $request->short_name;
            // $ins['division_id'] = $request->division_id;
            $ins['reporting_manager_id'] = $request->reporting_manager_id;
            $ins['status'] = 'active';
            $ins['addedBy'] = auth()->id();



            $data = User::updateOrCreate(['emp_code' => $request->previous_code], $ins);

            if ($request->aadhar_name && !empty($request->aadhar_name)) {
                $aadhar_id = DocumentType::where('name', 'Adhaar')->first();
                $ins_aa = [];
                $ins_aa['academic_id'] = $academic_id;
                $ins_aa['staff_id'] = $data->id;
                $ins_aa['document_type_id'] = $aadhar_id->id;
                $ins_aa['description'] = $request->aadhar_name;
                $ins_aa['doc_number'] = $request->aadhar_no ?? null;
                $ins_aa['verification_status'] = 'pending';

                /** 
                 *  check file is exists
                 */
                if ($request->hasFile('aadhar')) {

                    $files = $request->file('aadhar');
                    $imageIns = [];
                    $iteration = 1;
                    foreach ($files as $file) {

                        $imageName = uniqid() . Str::replace(' ', "-", $file->getClientOriginalName());


                        $directory              = 'staff/' . $request->previous_code . '/aadhar';
                        $filename               = $directory . '/' . $imageName;

                        Storage::disk('public')->put($filename, File::get($file));

                        $imageIns[] = $filename;
                        $iteration++;
                    }
                    $file_name = $imageIns ? implode(',', $imageIns) : null;

                    $ins_aa['multi_file'] = $file_name;
                }
                StaffDocument::updateOrCreate(['staff_id' => $data->id, 'document_type_id' => $aadhar_id->id], $ins_aa);
            }

            if ($request->pancard_name && !empty($request->pancard_name)) {
                $pan_id = DocumentType::where('name', 'Pan Card')->first();
                $ins_aa = [];
                $ins_aa['academic_id'] = $academic_id;
                $ins_aa['staff_id'] = $data->id;
                $ins_aa['document_type_id'] = $pan_id->id;
                $ins_aa['description'] = $request->pancard_name;
                $ins_aa['doc_number'] = $request->pancard_no ?? null;
                $ins_aa['verification_status'] = 'pending';
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
                }

                StaffDocument::updateOrCreate(['staff_id' => $data->id, 'document_type_id' => $pan_id->id], $ins_aa);
            }

            if ($request->ration_card_name && !empty($request->ration_card_name)) {
                $ration_id = DocumentType::where('name', 'Ration Card')->first();
                $ins_aa = [];
                $ins_aa['academic_id'] = $academic_id;
                $ins_aa['staff_id'] = $data->id;
                $ins_aa['document_type_id'] = $ration_id->id;
                $ins_aa['description'] = $request->ration_card_name;
                $ins_aa['doc_number'] = $request->ration_card_number ?? null;
                $ins_aa['verification_status'] = 'pending';

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
                }

                StaffDocument::updateOrCreate(['staff_id' => $data->id, 'document_type_id' => $ration_id->id], $ins_aa);
            }

            if ($request->license_name && !empty($request->license_name)) {
                $license_id = DocumentType::where('name', 'Driving License')->first();
                $ins_aa = [];
                $ins_aa['academic_id'] = $academic_id;
                $ins_aa['staff_id'] = $data->id;
                $ins_aa['document_type_id'] = $license_id->id;
                $ins_aa['description'] = $request->license_name;
                $ins_aa['doc_number'] = $request->license_number ?? null;
                $ins_aa['verification_status'] = 'pending';

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
                }

                StaffDocument::updateOrCreate(['staff_id' => $data->id, 'document_type_id' => $license_id->id], $ins_aa);
            }

            if ($request->voter_name && !empty($request->voter_name)) {

                $voter_id = DocumentType::where('name', 'Voter ID')->first();
                $ins_aa = [];
                $ins_aa['academic_id'] = $academic_id;
                $ins_aa['staff_id'] = $data->id;
                $ins_aa['document_type_id'] = $voter_id->id;
                $ins_aa['description'] = $request->voter_name;
                $ins_aa['doc_number'] = $request->voter_number ?? null;
                $ins_aa['verification_status'] = 'pending';
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
                }

                StaffDocument::updateOrCreate(['staff_id' => $data->id, 'document_type_id' => $voter_id->id], $ins_aa);
            }

            if ($request->passport_name && !empty($request->passport_name)) {

                $passport_id = DocumentType::where('name', 'Passport')->first();
                $ins_aa = [];
                $ins_aa['academic_id'] = $academic_id;
                $ins_aa['staff_id'] = $data->id;
                $ins_aa['document_type_id'] = $passport_id->id;
                $ins_aa['description'] = $request->passport_name;
                $ins_aa['doc_number'] = $request->passport_number ?? null;
                $ins_aa['doc_date'] = $request->passport_valid_upto ? date('Y-m-d', strtotime($request->passport_valid_upto)) : null;
                $ins_aa['verification_status'] = 'pending';

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
        dd($staff_details);
    }

    public function insertKycData(Request $request)
    {

        $id = $request->outer_staff_id ?? '';
        $data = '';
        $validator      = Validator::make($request->all(), [
            'date_of_birth' => 'required',
            'gender' => 'required',
            'marital_status' => 'required',
            'marriage_date' => 'required_if:marital_status,==,married',
            'language_id' => 'required',
            'place_of_birth_id' => 'required',
            'nationality_id' => 'required',
            'religion_id' => 'required',
            'caste_id' => 'required',
            'community_id' => 'required',
            'phone_no' => 'required|numeric|digits:10',
            'emergency_no' => 'required|numeric|digits:10',
            'mobile_no_1' => 'nullable|numeric|digits:10',
            'mobile_no_2' => 'nullable|numeric|digits:10',
            'whatsapp_no' => 'nullable|numeric|digits:10',
            'contact_address' => 'required',
            'permanent_address' => 'required',
            'outer_staff_id' => 'required'
        ]);

        if ($validator->passes()) {
            $staff_info = User::find($id);
            $academic_id = academicYearId();
            /**
             * 1.insert in staff_personal_info
             * 2.insert in staff_bank_details
             * 3.insert in staff_pf_esi_details
             */
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

                $files = $request->file('profile_image');
                $imageName = uniqid() . Str::replace(' ', "-", $files->getClientOriginalName());

                $directory              = 'staff/' . $staff_info->emp_code . '/profile';
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
                $insEsi['location'] = $request->uan_area;
                $insEsi['status'] = 'active';
                StaffPfEsiDetail::updateOrCreate(['staff_id' => $id, 'type' => 'pf'], $insEsi);
            } else {
                StaffPfEsiDetail::where(['staff_id' => $id, 'type' => 'pf'])->delete();
            }

            if (!empty($request->esi_no) && $request->is_esi == 'yes') {

                $insEsi['academic_id'] = $academic_id;
                $insEsi['staff_id'] = $id;
                $insEsi['ac_number'] = $request->esi_no;
                $insEsi['type'] = 'esi';
                $insEsi['start_date'] = isset($request->esi_start_date) && !empty($request->esi_start_date) ? date('Y-m-d', strtotime($request->esi_start_date)) : null;
                $insEsi['end_date'] = isset($request->esi_end_date) && !empty($request->esi_end_date) ? date('Y-m-d', strtotime($request->esi_end_date)) : null;
                $insEsi['location'] = $request->esi_address;
                $insEsi['status'] = 'active';
                StaffPfEsiDetail::updateOrCreate(['staff_id' => $id, 'type' => 'esi'], $insEsi);
            } else {
                StaffPfEsiDetail::where(['staff_id' => $id, 'type' => 'esi'])->delete();
            }

            if ($request->bank_id) {

                $insBank['academic_id'] = $academic_id;
                $insBank['staff_id'] = $id;
                $insBank['bank_id'] = $request->bank_id;
                $insBank['bank_branch_id'] = $request->branch_id;
                $insBank['account_name'] = $request->account_name;
                $insBank['account_number'] = $request->account_no;
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
            'subject' => 'required',
            'scheme_id' => 'required',
            'class_id' => 'required',
            'division_id' => 'required',
        ];
        if ($global_is_teaching) {
            $validateArray = [
                'designation_id' => 'required',
                'department_id' => 'required',
                'scheme_id' => 'required',
                'division_id' => 'required',
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
            $ins['division_id'] = $request->division_id;
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

            if ($request->studied && !empty($request->studied)) {
                StaffStudiedSubject::where('staff_id', $id)->delete();
                foreach ($request->studied as $item) {
                    $ids = explode('_', $item);
                    $class_id = $ids[1];
                    $subject_id = $ids[0];
                    $ins2 = [];
                    $ins2['academic_id'] = $academic_id;
                    $ins2['staff_id'] = $id;
                    $ins2['subject_id'] = $subject_id;
                    $ins2['class_id'] = $class_id;
                    $ins2['status'] = 'active';
                    StaffStudiedSubject::create($ins2);
                }
            }

            if ($request->no_studied && !empty($request->no_studied)) {
                foreach ($request->no_studied as $item) {

                    $ins2 = [];
                    $ins2['academic_id'] = $academic_id;
                    $ins2['staff_id'] = $id;
                    $ins2['subject_id'] = $item;
                    $ins2['status'] = 'active';
                    StaffStudiedSubject::create($ins2);
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


            $data = User::select('users.*', 'institutions.name as institute_name')
                ->join('institutions', 'institutions.id', 'users.institute_id')
                ->when(!empty(session()->get('academic_id')), function ($query) {
                    $query->where('users.academic_id', session()->get('academic_id'));
                })->whereNull('is_super_admin');
 /*
            $subquery = User::select('users.*', 'institutions.name as institute_name')
                ->join('institutions', 'institutions.id', 'users.institute_id')
                ->where('users.academic_id', session()->get('academic_id'))
                ->whereNull('is_super_admin')
                ->getQuery();

            $countQuery = DB::table(DB::raw("({$subquery->toSql()}) as count_row_table"))
                ->select(DB::raw('count(*) as aggregate'))
                ->mergeBindings($subquery)
                ->first();

            $data = DB::table(DB::raw("({$subquery->toSql()}) as count_row_table"))
                ->select('count_row_table.*', 'count_row_table.institute_name')
                ->mergeBindings($subquery)
                ->orderBy('count_row_table.created_at', 'desc')
                ->get(); */

            $status = $request->get('status');
            $datatable_search = $request->datatable_search ?? '';
            $keywords = $datatable_search;
            $datatables =  Datatables::of($data)
                ->filter(function ($query) use ($keywords, $status) {

                    if ($keywords) {
                        $date = date('Y-m-d', strtotime($keywords));
                        return $query->where(function ($q) use ($keywords, $date) {

                            $q->where('users.name', 'like', "%{$keywords}%")
                                ->orWhere('users.status', 'like', "%{$keywords}%")
                                ->orWhere('users.email', 'like', "%{$keywords}%")
                                ->orWhere('users.emp_code', 'like', "%{$keywords}%")
                                ->orWhere('users.first_name_tamil', 'like', "%{$keywords}%")
                                ->orWhereDate("users.created_at", $date);
                        });
                    }
                })
                ->addIndexColumn()

                ->editColumn('verification_status', function ($row) {
                    $status = '
                            <div class="d-flex align-items-center w-100px w-sm-200px flex-column mt-3">
                                <div class="d-flex justify-content-between w-100 mt-auto">
                                    <span class="fw-semibold fs-6 text-gray-400">' . ucwords($row->verification_status) . '</span>
                                    <span class="fw-bold fs-6">' . getStaffProfileCompilation($row->id) . '%</span>
                                </div>
                                <div class="h-5px mx-3 w-100 bg-light">
                                    <div class="bg-success rounded h-5px" role="progressbar" aria-valuenow="' . getStaffProfileCompilation($row->id) . '" aria-valuemin="0" aria-valuemax="100" style="width: ' . getStaffProfileCompilation($row->id) . '%;"></div>
                                </div>
                            </div>';
                    return $status;
                })
                ->editColumn('status', function ($row) {
                    $status = '<a href="javascript:void(0);" class="badge badge-light-' . (($row->status == 'active') ? 'success' : 'danger') . '" tooltip="Click to ' . ucwords($row->status) . '" onclick="return staffChangeStatus(' . $row->id . ',\'' . ($row->status == 'active' ? 'inactive' : 'active') . '\')">' . ucfirst($row->status) . '</a>';
                    return $status;
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
                ->rawColumns(['action', 'status', 'verification_status']);
            return $datatables->make(true);


            /* $datatables = Datatables::of($data)
                ->with([
                    "recordsTotal" => $countQuery->aggregate,
                    "recordsFiltered" => $countQuery->aggregate
                ]);

            $status = $request->get('status');
            $datatable_search = $request->datatable_search ?? '';
            $keywords = $datatable_search;
            $datatables->filter(function ($query) use ($keywords, $status) {
                if ($keywords) {
                    $date = date('Y-m-d', strtotime($keywords));
                    return $query->where(function ($q) use ($keywords, $date) {

                        $q->where('users.name', 'like', "%{$keywords}%")
                            ->orWhere('users.status', 'like', "%{$keywords}%")
                            ->orWhere('users.email', 'like', "%{$keywords}%")
                            ->orWhere('users.emp_code', 'like', "%{$keywords}%")
                            ->orWhere('users.first_name_tamil', 'like', "%{$keywords}%")
                            ->orWhereDate("users.created_at", $date);
                    });
                }
            });

            $datatables->addIndexColumn()
                ->editColumn('verification_status', function ($row) {
                    $status = '
                            <div class="d-flex align-items-center w-100px w-sm-200px flex-column mt-3">
                                <div class="d-flex justify-content-between w-100 mt-auto">
                                    <span class="fw-semibold fs-6 text-gray-400">' . ucwords($row->verification_status) . '</span>
                                    <span class="fw-bold fs-6">' . getStaffProfileCompilation($row->id) . '%</span>
                                </div>
                                <div class="h-5px mx-3 w-100 bg-light">
                                    <div class="bg-success rounded h-5px" role="progressbar" aria-valuenow="' . getStaffProfileCompilation($row->id) . '" aria-valuemin="0" aria-valuemax="100" style="width: ' . getStaffProfileCompilation($row->id) . '%;"></div>
                                </div>
                            </div>';
                    return $status;
                })
                ->editColumn('status', function ($row) {
                    $status = '<a href="javascript:void(0);" class="badge badge-light-' . (($row->status == 'active') ? 'success' : 'danger') . '" tooltip="Click to ' . ucwords($row->status) . '" onclick="return staffChangeStatus(' . $row->id . ',\'' . ($row->status == 'active' ? 'inactive' : 'active') . '\')">' . ucfirst($row->status) . '</a>';
                    return $status;
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
                ->rawColumns(['action', 'status', 'verification_status']);

            return $datatables->make(true); */
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

        $info = $user;
        return view('pages.overview.index', compact('info', 'breadcrums'));
    }

    public function print(Request $request, User $user)
    {
        return view('pages.overview.print_view.print', compact('user'));
    }
}
