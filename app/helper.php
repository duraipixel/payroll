<?php

use App\Models\AcademicYear;
use App\Models\Leave\StaffLeave;
use App\Models\ReportingManager;
use App\Models\Staff\StaffAppointmentDetail;
use App\Models\Staff\StaffBankDetail;
use App\Models\Staff\StaffDocument;
use App\Models\Staff\StaffEducationDetail;
use App\Models\Staff\StaffFamilyMember;
use App\Models\Staff\StaffHealthDetail;
use App\Models\Staff\StaffKnownLanguage;
use App\Models\Staff\StaffLeaveMapping;
use App\Models\Staff\StaffNominee;
use App\Models\Staff\StaffPersonalInfo;
use App\Models\Staff\StaffProfessionalData;
use App\Models\Staff\StaffSalaryPreDeduction;
use App\Models\Staff\StaffStudiedSubject;
use App\Models\Staff\StaffTalent;
use App\Models\Staff\StaffWorkExperience;
use App\Models\Master\PlaceOfWork;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use App\Models\Role\Permission;
use App\Helpers\AccessGuard;
use App\Models\Staff\StaffELEntry;
use App\Models\AttendanceManagement\AttendanceManualEntry;
use App\Models\AttendanceManagement\LeaveMapping;
use App\Models\ItTabulation;
use App\Models\Master\Institution;
use App\Models\PayrollManagement\ItStaffStatement;
use App\Models\PayrollManagement\OtherIncome;
use App\Models\PayrollManagement\PayrollPermission;
use App\Models\PayrollManagement\StaffSalary;
use App\Models\PayrollManagement\SalaryField;
use App\Models\PayrollManagement\StaffSalaryField;
use App\Models\PayrollManagement\StaffSalaryPattern;
use App\Models\PayrollManagement\StaffSalaryPatternField;
use App\Models\Staff\StaffBankLoan;
use App\Models\Staff\StaffDeduction;
use App\Models\Staff\StaffHandlingSubject;
use App\Models\Staff\StaffInsurance;
use App\Models\Staff\StaffOtherIncome;
use App\Models\Staff\StaffTaxSeperation;
use App\Models\Tax\TaxScheme;
use App\Models\Tax\TaxSection;
use App\Models\Tax\TaxSectionItem;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Models\Master\Department;
use App\Models\Staff\StaffSalaryPreEarning;

if (!function_exists('academicYearId')) {
    function academicYearId()
    {
        $data = AcademicYear::where('is_current', 1)->first();
        if (session()->get('academic_id') && !empty(session()->get('academic_id'))) {
            return session()->get('academic_id');
        }
        return $data->id;
    }
}

if (!function_exists('access')) {
    function access()
    {
        return new AccessGuard();
    }
}

if (!function_exists('dotReplaceUnderscore')) {
    function dotReplaceUnderscore($value)
    {
        $str = str_replace('.', '__', $value);
        return $str;
    }
}

if (!function_exists('permissionCheckAll')) {
    function permissionCheckAll($role_id, $menu_type)
    {
        $check_array = [];
        foreach ($menu_type as $key => $value) {
            $menu_check = Permission::where('role_id', $role_id)->where('add_edit_menu', '1')
                ->where('view_menu', '1')->where('delete_menu', '1')->where('export_menu', '1')->where('route_name', $key)->first();
            if ($menu_check) {
                $check_array = 1;
            } else {
                $check_array = 0;
            }
        }
        return $check_array;
    }
}

if (!function_exists('permissionCheck')) {
    function permissionCheck($role_id, $key, $type)
    {
        if ($type == 'add_edit') {
            $menu_check = Permission::where('role_id', $role_id)->where('add_edit_menu', '1')->where('route_name', $key)->first();
        } else if ($type == 'view') {
            $menu_check = Permission::where('role_id', $role_id)->where('view_menu', '1')->where('route_name', $key)->first();
        } else if ($type == 'delete') {
            $menu_check = Permission::where('role_id', $role_id)->where('delete_menu', '1')->where('route_name', $key)->first();
        } else if ($type == 'export') {
            $menu_check = Permission::where('role_id', $role_id)->where('export_menu', '1')->where('route_name', $key)->first();
        } else {
            return false;
        }
        if ($menu_check)
            return true;
        else
            return false;
    }
}

if (!function_exists('getRegistrationSteps')) {
    function getRegistrationSteps($staff_id)
    {
        $response = false;
        $info = User::find($staff_id);
        $step = 0;
        if ($info) {
            $step = 1;

            $personalInfo = StaffPersonalInfo::where('staff_id', $staff_id)->first();
            if ($personalInfo) {
                $step = 2;
            }

            $professional_data = StaffProfessionalData::where('staff_id', $staff_id)->first();
            if ($professional_data) {
                $step = 3;
            }

            $step = 6;
            $step = 7;
            $step = 8;
            $appointment_data = StaffAppointmentDetail::where('staff_id', $staff_id)->first();

            if ($appointment_data) {
                $step = 9;
            }
        }
        return $step;
    }
}

if (!function_exists('getStaffProfileCompilation')) {
    function getStaffProfileCompilation($staff_id)
    {
        $response = false;
        $info = User::find($staff_id);
        $percentage = 0;
        if ($info) {
            $percentage = 10;

            $personalInfo = StaffPersonalInfo::where('staff_id', $staff_id)->first();
            if ($personalInfo) {
                $percentage += 10;
            } //

            $professional_data = StaffProfessionalData::where('staff_id', $staff_id)->first();
            if ($professional_data) {
                $percentage += 10;
            }

            $documents = StaffDocument::where(['staff_id' => $staff_id, 'status' => 'active'])->get();
            if (count($documents) > 0) {
                $percentage += 10;
            }

            // $education = StaffEducationDetail::where(['staff_id' => $staff_id, 'status' => 'active'])->get();
            // if (count($education) > 0) {
            //     $percentage += 10;
            // }

            $family_members = StaffFamilyMember::where(['staff_id' => $staff_id, 'status' => 'active'])->get();
            if (count($family_members) > 0) {
                $percentage += 5;
            }

            $nominee = StaffNominee::where(['staff_id' => $staff_id])->get();
            if (count($nominee) > 0) {
                $percentage += 5;
            }
            //so far 60%
            $health_details = StaffHealthDetail::where('staff_id', $staff_id)->first();
            if ($health_details) {
                $percentage += 5;
            }
            //65%
            $expeince = StaffWorkExperience::where(['staff_id' => $staff_id, 'status' => 'active'])->get();
            if (count($expeince) > 0) {
                $percentage += 5;
            } // 70%

            $knownLanguages = StaffKnownLanguage::where(['staff_id' => $staff_id, 'status' => 'active'])->get();
            if (count($knownLanguages) > 0) {
                $percentage += 5;
            } // 75%
            $studienSubject = StaffStudiedSubject::where(['staff_id' => $staff_id, 'status' => 'active'])->get();
            if (count($studienSubject) > 0) {
                $percentage += 5;
            } // 80%
            $staffbank = StaffBankDetail::where(['staff_id' => $staff_id, 'status' => 'active'])->get();
            if (count($staffbank) > 0) {
                $percentage += 5;
            } // 85%

            $appointment_data = StaffAppointmentDetail::where('staff_id', $staff_id)->first();
            if ($appointment_data) {
                $percentage += 10;
            }

            if ($info->verification_status == 'approved') {
                //available status => ['approved', 'draft', 'rejected', 'cancelled', 'pending']
                $percentage = 100;
            }
        }
        return $percentage;
    }
}

if (!function_exists('getStaffProfileCompilationData')) {
    function getStaffProfileCompilationData($user_id, $type = '')
    {
        $response = false;
        $info = User::find($user_id);
        // with(['personal', 'position', 'StaffDocument', 'familyMembers', 'nominees', 'healthDetails', 'StaffWorkExperience', 'knownLanguages', 'studiedSubject', 'bank', 'appointment'])
                    
        $percentage = 0;
        if ($info) {
            $percentage = 10;
            if ($info->personal) {
                $percentage += 10;
            } //
            if ($info->position) {
                $percentage += 10;
            }
           
            if (count($info->StaffDocument) > 0) {
                $percentage += 10;
            }
            // if (count($info->StaffEducationDetail) > 0) {
            //     $percentage += 10;
            // }
            if (count($info->familyMembers) > 0) {
                $percentage += 5;
            }
            if (count($info->nominees) > 0) {
                $percentage += 5;
            }
            //so far 60%
            if ($info->healthDetails) {
                $percentage += 5;
            }

            //65%
            if (count($info->StaffWorkExperience) > 0) {
                $percentage += 5;
            } // 70%
            if (count($info->knownLanguages) > 0) {
                $percentage += 5;
            } // 75%
            if (count($info->studiedSubject) > 0) {
                $percentage += 5;
            } // 80%
            if ($info->bank) {
                $percentage += 5;
            } // 85%
            if ($info->appointment) {
                $percentage += 10;
            }
            if ($info->verification_status == 'approved') {
                //available status => ['approved', 'draft', 'rejected', 'cancelled', 'pending']
                $percentage = 100;
            }
        }
        return $percentage;
    }
}

if (!function_exists('getStudiedSubjects')) {
    function getStudiedSubjects($staff_id, $subject, $class = '')
    {
        return StaffStudiedSubject::where('staff_id', $staff_id)
            ->where('subjects', $subject)
            ->when($class != '', function ($q) use ($class) {
                return $q->where('classes', $class);
            })->first();
    }
}

if (!function_exists('getHandlingSubjects')) {
    function getHandlingSubjects($staff_id, $subject_id, $class_id = '')
    {
        return StaffHandlingSubject::where('staff_id', $staff_id)
            ->where('subject_id', $subject_id)
            ->when($class_id != '', function ($q) use ($class_id) {
                return $q->where('class_id', $class_id);
            })->first();
    }
}

if (!function_exists('getStaffKnownLanguages')) {
    function getStaffKnownLanguages($staff_id, $language_id, $type)
    {
        return StaffKnownLanguage::where('status', 'active')
            ->where('staff_id', $staff_id)
            ->where('language_id', $language_id)
            ->where($type, true)
            ->first();
    }
}

if (!function_exists('getTalents')) {
    function getTalents($staff_id, $talent_fields)
    {
        return StaffTalent::where('status', 'active')
            ->where('staff_id', $staff_id)
            ->where('talent_fields', $talent_fields)
            ->first();
    }
}

if (!function_exists('generateLeaveForm')) {
    function generateLeaveForm($leave_id,$type='leave')
    {  
        $leave_info = StaffLeave::find($leave_id);
        $leave_count=0;
        $taken_leave = StaffLeave::where('staff_id', $leave_info->staff_id)->where('from_date', '<', $leave_info->from_date)->get();
        foreach($taken_leave as $leave){
            $leave_count+=$leave->granted_days;

        }
        $data['institute_name'] = $leave_info->staff_info->institute->name;
        $data['application_no'] = $leave_info->application_no;
        $data['application_date'] = date('d/M/Y', strtotime($leave_info->created_at));
        $data['designation'] = $leave_info->designation;
        $data['place_of_work'] = $leave_info->place_of_work;
        $data['salary'] = $leave_info->salary;
        $data['date_requested'] = date('d/M/Y', strtotime($leave_info->from_date)) . ' - ' . date('d/M/Y', strtotime($leave_info->to_date));
        $data['no_of_days'] = $leave_info->no_of_days;
        $data['reason'] = $leave_info->reason ?? '';
        $data['status'] = $leave_info->status ?? '';
        $data['leave_days'] = $leave_info->leave_days ?? '';
        $data['address'] = $leave_info->address ?? '';
        $data['staff_name'] = $leave_info->staff_info->name;
        $data['staff_code'] = $leave_info->staff_info->institute_emp_code ?? $leave_info->staff_info->emp_code;
        $data['taken_leave'] =$leave_count;
        $data['holiday_date'] = $leave_info->holiday_date ? date('d/M/Y', strtotime($leave_info->holiday_date)) : '';
        $data['is_leave_granted'] = $leave_info->is_granted ? ucfirst($leave_info->is_granted) : '';
        $data['granted_days'] = $leave_info->granted_days ?? '';
        $data['remarks'] = $leave_info->remarks ?? null;
        $data['leave_granted_by'] = $leave_info->granted_info->name ?? '';
        $data['granted_designation'] = $leave_info->granted_designation ?? '';

        switch (strtolower($leave_info->leave_category)) {
            case 'cl':
                $data['form_title'] = 'LEAVE';
                $file_name = time() . $leave_info->application_no . '.pdf';

                $directory              = 'public/leave/' . $leave_info->application_no;
                $filename               = $directory . '/' . $file_name;

                $pdf = Pdf::loadView('leave_form.leave_application', $data)->setPaper('a4', 'portrait');
                Storage::put($filename, $pdf->output());
                $leave_info->document = $filename;
                $leave_info->save();

                break;
            case 'el':
                $data['form_title'] = 'EARNED LEAVE';
                $file_name = time() . $leave_info->application_no . '.pdf';

                $directory              = 'public/leave/' . $leave_info->application_no;
                $filename               = $directory . '/' . $file_name;

                $pdf = Pdf::loadView('leave_form.el', $data)->setPaper('a4', 'portrait');
                Storage::put($filename, $pdf->output());
                $leave_info->document = $filename;
                $leave_info->save();
                break;

            case 'eol':
                $data['form_title'] = 'EARNED OUT LEAVE';
                $file_name = time() . $leave_info->application_no . '.pdf';

                $directory              = 'public/leave/' . $leave_info->application_no;
                $filename               = $directory . '/' . $file_name;

                $pdf = Pdf::loadView('leave_form.el', $data)->setPaper('a4', 'portrait');
                Storage::put($filename, $pdf->output());
                $leave_info->document = $filename;
                $leave_info->save();
                break;
            case 'ml':

                $data['form_title'] = 'MATERNITY LEAVE';
                $file_name = time() . $leave_info->application_no . '.pdf';

                $directory              = 'public/leave/' . $leave_info->application_no;
                $filename               = $directory . '/' . $file_name;

                $pdf = Pdf::loadView('leave_form.el', $data)->setPaper('a4', 'portrait');
                Storage::put($filename, $pdf->output());
                $leave_info->document = $filename;
                $leave_info->save();
                break;

            default:
                $data['form_title'] = 'LEAVE';
                $file_name = time() . $leave_info->application_no . '.pdf';

                $directory              = 'public/leave/' . $leave_info->application_no;
                $filename               = $directory . '/' . $file_name;

                $pdf = Pdf::loadView('leave_form.leave_application', $data)->setPaper('a4', 'portrait');
                Storage::put($filename, $pdf->output());
                $leave_info->document = $filename;
                $leave_info->save();

                break;
        }
        if($type=='download'){
           $path=storage_path('app/'.$filename);
        return Response::download($path);
        }else{
            return true;
        }
        
    }

    function buildTree($reportee_id)
    {

        $info = ReportingManager::where('reportee_id', $reportee_id)->where('is_top_level', 'no')->get();
        $tree_view = '';
        if (isset($info) && !empty($info)) {
            $tree_view = '<ul class="active">';
            foreach ($info as $item_value) {


                if ( isset($item_value->manager->image) && !empty($item_value->manager->image)) {
                    $profile_image = Storage::url($item_value->manager->image);
                    $path = asset('public' . $profile_image);
                } else {
                    $path = asset('assets/images/no_Image.jpg');
                }

                $tree_view .= ' <li>
                                    <a href="javascript:void(0);">
                                        <div class="member-view-box">
                                            <div class="member-image">
                                                <img src="'.$path.'"
                                                    alt="Member">
                                                <div class="member-details">
                                                    <h3>' . $item_value->manager->name . '</h3>
                                                </div>
                                            </div>
                                        </div>
                                    </a>';

                $tree_view .= buildChild($item_value->manager_id);
                $tree_view .= '</li>';
            }
            $tree_view .= '</ul>';
        }

        echo $tree_view;
    }

    function buildChild($reportee_id)
    {

        $list  = '';
        $info = ReportingManager::where('reportee_id', $reportee_id)->where('is_top_level', 'no')->get();

        if (isset($info) && !empty($info)) {
            $list = '<ul class="active">';
            foreach ($info as $item_value) {

                
                if ( isset($item_value->manager->image) && !empty($item_value->manager->image)) {
                    $profile_image = Storage::url($item_value->manager->image);
                    $path = asset('public' . $profile_image);
                } else {
                    $path = asset('assets/images/no_Image.jpg');
                }

                $list .= ' <li>
                                    <a href="javascript:void(0);">
                                        <div class="member-view-box">
                                            <div class="member-image">
                                                <img src="'.$path.'"
                                                    alt="Member">
                                                <div class="member-details">
                                                    <h3>' . $item_value->manager->name . '</h3>
                                                </div>
                                            </div>
                                        </div>
                                    </a>';
                $list .= buildChild($item_value->manager_id);
                $list .= '</li>';
            }
            $list .= '</ul>';
        }

        return $list;
    }

    function getTotalExperience($staff_id)
    {
        return '1 year'; //need to do calculation
    }

    function commonDateFormat($date)
    {

        if ($date) {
            return date('d/m/Y', strtotime($date));
        }
    }

    function commonDateFormatAlt($date)
    {

        if ($date) {
            return date('d-m-Y', strtotime($date));
        }
    }

    function commonAmountFormat($amount)
    {

        return 'Rs.' . $amount ?? 0;
    }

    function getTotalLeaveCount($staff_id)
    {
        $staff_info = User::find($staff_id);
        $allocated_total_leave = 0;
        $taken_leave = 0;
        $balance_leave = 0;
        if ($staff_info->appointment->nature_of_employment_id ?? '') {
            if (isFemale($staff_id)) {

                $total_leaves = LeaveMapping::selectRaw('sum(CAST(leave_mappings.leave_days AS DECIMAL(10, 2))) as total')
                    ->where('nature_of_employment_id', $staff_info->appointment->nature_of_employment_id)
                    ->where('academic_id',academicYearId())
                    ->where('status', 'active')
                    ->first();
            } else {
                $total_leaves = LeaveMapping::selectRaw('sum(CAST(leave_mappings.leave_days AS DECIMAL(10, 2))) as total')
                    ->join('leave_heads', function ($join) {
                        $join->on('leave_heads.id', '=', 'leave_mappings.leave_head_id');
                        // $join->on('leave_heads.code', '!=', DB::raw('"ML"'));
                    })
                    ->where('nature_of_employment_id', $staff_info->appointment->nature_of_employment_id)
                    ->where('leave_mappings.academic_id',academicYearId())
                    ->where('leave_mappings.status', 'active')
                    ->where('leave_heads.code', '!=', 'ML')
                    ->first();
            }

            if ($total_leaves) {
                $allocated_total_leave = $total_leaves->total;
            }
        }
        $leaves = StaffLeave::selectRaw('SUM(no_of_days) as taken_leave')->where('staff_id', $staff_id)->where('academic_id',academicYearId())
            ->where('status', 'approved')
            ->first();
        if ($leaves) {
            $taken_leave = $leaves->taken_leave ?? 0;
        }
        if ($allocated_total_leave >= $taken_leave) {
            $balance_leave = $allocated_total_leave - $taken_leave;
        }
        return array(
            'allocated_total_leave' => $allocated_total_leave,
            'taken_leave' => $taken_leave,
            'balance_leave' => $balance_leave
        );
    }

    function attendanceYear()
    {
        $date = '1/Jan/' . date('Y') . ' - 31/Dec/' . date('Y');
        return $date;
    }

    function getAllInstitute()
    {
        return Institution::where('status', 'active')->get();
    }

    function getInstituteInfo($id)
    {
        return Institution::find($id);
    }
     function getInstituteName($id)
    {
        $instute=Institution::find($id);
        if($instute){
            return $instute->name;

        }
        return '';
    }
    function getMonthName($date)
    {
        return date('F', strtotime($date));
    }

    function getSalarySelectedFields($staff_id, $staff_salary_id, $field_id)
    {
        return StaffSalaryPatternField::where('staff_id', $staff_id)->where('staff_salary_pattern_id', $staff_salary_id)
            ->where('field_id', $field_id)->first();
    }
}

if (!function_exists('getStaffVerificationStatus')) {
    function getStaffVerificationStatus($staff_id, $module)
    {

        $user_info = User::find($staff_id);

        switch ($module) {
            case 'data_entry':
                $personalInfo = StaffPersonalInfo::where('staff_id', $staff_id)->first();
                $professional_data = StaffProfessionalData::where('staff_id', $staff_id)->first();
                // $education = StaffEducationDetail::where(['staff_id' => $staff_id, 'status' => 'active'])->get();
                $family_members = StaffFamilyMember::where(['staff_id' => $staff_id, 'status' => 'active'])->get();
                $nominee = StaffNominee::where(['staff_id' => $staff_id])->get();
                $health_details = StaffHealthDetail::where('staff_id', $staff_id)->first();
                // $expeince = StaffWorkExperience::where(['staff_id' => $staff_id, 'status' => 'active'])->get();
                $knownLanguages = StaffKnownLanguage::where(['staff_id' => $staff_id, 'status' => 'active'])->get();
                // $studienSubject = StaffStudiedSubject::where(['staff_id' => $staff_id, 'status' => 'active'])->get();
                // $staffbank = StaffBankDetail::where(['staff_id' => $staff_id, 'status' => 'active'])->get();
                $return = false;

                if ($personalInfo && $professional_data && count($family_members) > 0 && count($nominee) > 0 && $health_details && count($knownLanguages) > 0) {
                    $return = true;
                }
                return $return;
                break;

            case 'doc_uploaded':
                /**
                 * 1. education document 
                 * 2. experience document
                 * 3. Personal document
                 */
                // $education = StaffEducationDetail::where(['staff_id' => $staff_id, 'status' => 'active'])->get();
                // $doc_education = StaffEducationDetail::where(['staff_id' => $staff_id, 'status' => 'active'])->whereNull('doc_file')->get();
                // $expeince = StaffWorkExperience::where(['staff_id' => $staff_id, 'status' => 'active'])->get();
                // $doc_expeince = StaffWorkExperience::where(['staff_id' => $staff_id, 'status' => 'active'])->whereNull('doc_file')->get();
                $personal_doc = StaffDocument::where(['staff_id' => $staff_id, 'status' => 'active'])->get();
                $return = false;

                if (count($personal_doc) > 0) {
                    $return = true;
                }
                return $return;
                break;

            case 'doc_verified':
                /**
                 * 1. education document 
                 * 2. experience document
                 * 3. Personal document
                 */
                // $education = StaffEducationDetail::where(['staff_id' => $staff_id, 'status' => 'active'])->get();
                // $doc_education = StaffEducationDetail::where(['staff_id' => $staff_id,  'verification_status' => 'approved'])->whereNotNull('doc_file')->get();
                // $expeince = StaffWorkExperience::where(['staff_id' => $staff_id, 'status' => 'active'])->get();
                // $doc_expeince = StaffWorkExperience::where(['staff_id' => $staff_id,  'verification_status' => 'approved'])->whereNotNull('doc_file')->get();
                $personal_doc = StaffDocument::where(['staff_id' => $staff_id, 'status' => 'active'])->get();
                $count_personal_doc = StaffDocument::where(['staff_id' => $staff_id, 'verification_status' => 'approved'])->get();
                $return = false;
                if (count($personal_doc) > 0) {

                    if (count($personal_doc) == count($count_personal_doc)) {
                        $return = true;
                    }
                }
                return $return;
                break;

            case 'salary_entry';
                $return = false;
                $staff_salaries = StaffSalaryPattern::where('staff_id', $staff_id)->where('status', 'active')->first();
                if ($staff_salaries) {
                    $return = true;
                }
                return $return;
                break;
            default:
                return false;
                break;
        }
    }
}

function canGenerateEmpCode($staff_id)
{
    $personalInfo = StaffPersonalInfo::where('staff_id', $staff_id)->first();
    $professional_data = StaffProfessionalData::where('staff_id', $staff_id)->first();
    // $education = StaffEducationDetail::where(['staff_id' => $staff_id, 'status' => 'active'])->get();
    $family_members = StaffFamilyMember::where(['staff_id' => $staff_id, 'status' => 'active'])->get();
    $nominee = StaffNominee::where(['staff_id' => $staff_id])->get();
    $health_details = StaffHealthDetail::where('staff_id', $staff_id)->first();
    // $expeince = StaffWorkExperience::where(['staff_id' => $staff_id, 'status' => 'active'])->get();
    $knownLanguages = StaffKnownLanguage::where(['staff_id' => $staff_id, 'status' => 'active'])->get();
    // $studienSubject = StaffStudiedSubject::where(['staff_id' => $staff_id, 'status' => 'active'])->get();
    // $staffbank = StaffBankDetail::where(['staff_id' => $staff_id, 'status' => 'active'])->get();
    $personal_return = false;
    if ($personalInfo && $professional_data && count($family_members) > 0 && count($nominee) > 0 && $health_details && count($knownLanguages) > 0) {
        $personal_return = true;
    }

    // $education = StaffEducationDetail::where(['staff_id' => $staff_id, 'status' => 'active'])->get();
    // $doc_education = StaffEducationDetail::where(['staff_id' => $staff_id, 'status' => 'active'])->whereNull('doc_file')->get();
    // $expeince = StaffWorkExperience::where(['staff_id' => $staff_id, 'status' => 'active'])->get();
    // $doc_expeince = StaffWorkExperience::where(['staff_id' => $staff_id, 'status' => 'active'])->whereNull('doc_file')->get();
    $personal_doc = StaffDocument::where(['staff_id' => $staff_id, 'status' => 'active'])->get();
    $edu_return = false;

    if (count($personal_doc) > 0) {
        $edu_return = true;
    }

    // $education = StaffEducationDetail::where(['staff_id' => $staff_id, 'status' => 'active'])->get();
    // $doc_education = StaffEducationDetail::where(['staff_id' => $staff_id,  'verification_status' => 'approved'])->whereNotNull('doc_file')->get();
    // $expeince = StaffWorkExperience::where(['staff_id' => $staff_id, 'status' => 'active'])->get();
    // $doc_expeince = StaffWorkExperience::where(['staff_id' => $staff_id,  'verification_status' => 'approved'])->whereNotNull('doc_file')->get();
    $personal_doc = StaffDocument::where(['staff_id' => $staff_id, 'status' => 'active'])->get();
    $count_personal_doc = StaffDocument::where(['staff_id' => $staff_id, 'verification_status' => 'approved'])->get();
    $verified_return = false;
    if (count($personal_doc) == count($count_personal_doc)) {
        $verified_return = true;
    }

    $is_return = false;
    if ($verified_return && $edu_return && $personal_return) {
        $is_return = true;
    }
    return $is_return;
}

function getPercentageAmount($percentage, $amount)
{
    return ($percentage / 100) * $amount;
}

function previousSalaryData($pattern_id, $field_id)
{
    return StaffSalaryPatternField::where('staff_salary_pattern_id', $pattern_id)
        ->where('field_id', $field_id)->first();
}
function SalaryPrecentage($pattern_id, $field_id)
{
    $staff_sallary=StaffSalaryPatternField::where('staff_salary_pattern_id', $pattern_id)
        ->where('field_id', $field_id)->first();
        if($staff_sallary){
           return $staff_sallary->percentage??0;

        }
        return 0;
}

function getITSlabeInfo($from_amount, $to_amount, $slug)
{
    return ItTabulation::where(['from_amount' => $from_amount, 'to_amount' => $to_amount, 'slug' => $slug])->first();
}

function getItSlabInfo($slug)
{
    return ItTabulation::where(['slug' => $slug])->first();
}

function getProfessionTaxAmount($salary_pattern)
{
}

function getStaffOtherIncomeAmount($staff_id, $other_income_id)
{
    $academic_id = academicYearId();
    $info = StaffOtherIncome::where('academic_id', $academic_id)->where(['staff_id' => $staff_id, 'other_income_id' => $other_income_id, 'status' => 'active'])->first();
    return $info->amount ?? 0;
}

function getStaffDeductionAmount($staff_id, $slug)
{
    $academic_id = academicYearId();
    $info = StaffDeduction::selectRaw('sum(amount) as amount')->join('tax_sections', 'tax_sections.id', '=', 'staff_deductions.tax_section_id')
        ->where('tax_sections.slug', 'self-occupied-house')
        ->where('staff_deductions.staff_id', $staff_id)
        ->where('staff_deductions.status', 'active')->where('staff_deductions.academic_id', $academic_id)
        ->first();
    return $info->amount ?? 0;
}

function getStaffDeduction80CAmount($staff_id, $section_item_id)
{
    $academic_id = academicYearId();

    $info = StaffDeduction::where(['academic_id' => $academic_id, 'staff_id' => $staff_id, 'tax_section_item_id' => $section_item_id])->first();
    // dd( $info );
    return $info->amount ?? 0;
}

function getCurrentTaxSchemeId()
{
    $current_tax_schemes = TaxScheme::where('is_current', 'yes')->first();
    return $current_tax_schemes->id ?? '';
}

function roundOff($amount)
{
    $last_number = substr($amount, -1);
    if ($last_number > 0) {
        $amount  = $amount + 1;
    }
    return $amount;
}

function getTaxablePayAmountUsingSlabs($amount,$id=null)
{

    // $amount = '842500';
    $total_amount = $amount;
    $tax_amount = 0;
    $slab_details = ItTabulation::where('scheme_id',$id??1)->where('status', 'active')
        ->orderBy('from_amount')->get();
    $tax = [];
    if (isset($slab_details) && !empty($slab_details)) {
        foreach ($slab_details as $slab) {
            $tmp = [];
            $slab_amount = $slab->slab_amount ?? 0;

            if ($slab->to_amount <= $total_amount) {
                $amount = $amount - $slab_amount;
                $tmp['balance_amount'] = $amount;
                $tmp['percentage'] = $slab->percentage;
                $tmp['percentage_amount'] = getPercentageAmount($slab->percentage, $slab_amount);
                $tax_amount += $tmp['percentage_amount'];
            } else if ($slab->from_amount <= $total_amount && $slab->to_amount >= $total_amount) {
                $tmp['balance_amount'] = $amount;
                $tmp['percentage'] = $slab->percentage;
                $tmp['percentage_amount'] = getPercentageAmount($slab->percentage, $amount);
                $tax_amount += $tmp['percentage_amount'];
            }
            $tax[] = $tmp;
        }
    }

    return round($tax_amount);
}

function getHRAAmount($scheme_id, $staff_id, $salary_pattern)
{

    /**
     * 1. Get Actual HRA
     * 2. Get Rent Annual Amount
     * 3. Excess of  (BASIC + DA )*12 - ANNUAL_RENT_AMOUNT
     * 4. Find lowest value of these and return values;
     */

    $staff_info = User::find($staff_id);
    $actual_hra_amount = ($salary_pattern->hra->amount ?? 0) * 12;

    $rent_amount = $staff_info->staffRentByAcademic->annual_rent ?? 0;
    $basic = ($salary_pattern->basic->amount ?? 0) * 12;
    $da = ($salary_pattern->da->amount ?? 0) * 12;
    $excess_amount = getPercentageAmount(10, (($basic + $da) - $rent_amount));

    $hra_amount = $actual_hra_amount;
    if ($excess_amount < $actual_hra_amount) {
        $hra_amount = $excess_amount;
    }
    return $hra_amount;
}

function getTaxOtherSalaryCalulatedMonth($salary_pattern)
{
    $academic_info = AcademicYear::find(academicYearId());
    $start_year = $academic_info->from_year . '-03-01';
    $end_year = $academic_info->to_year . '-02-28';
    $s_date = date('Y-m-d', strtotime($start_year));
    $e_date = date('Y-m-d', strtotime($end_year));
    $payout_month = $salary_pattern->payout_month; //2022-04-01

    // dd( $payout_month );
    $payout_month = date('Y-m-d', strtotime($payout_month . '-1 month'));
    $counted_months = 12;
    if ($payout_month > $start_year && $payout_month < $e_date) {
        //find diff month
        $counted_months = findDiffMonth($payout_month, $e_date);
    }
    return $counted_months;
}

function findDiffMonth($date1, $date2)
{
    //$date1 must be small date and $date2 must be big date
    $ts1 = strtotime($date1);
    $ts2 = strtotime($date2);

    $year1 = date('Y', $ts1);
    $year2 = date('Y', $ts2);

    $month1 = date('m', $ts1);
    $month2 = date('m', $ts2);

    $diff = (($year2 - $year1) * 12) + ($month2 - $month1);
    return $diff + 1;
}

function generateIncomeTaxStatementPdfByStaff($statement_id)
{
    $info = ItStaffStatement::find($statement_id);

    $file_name = time() . '_ITStatement.pdf';

    $directory              = 'public/it/statement/' . $info->staff->society_emp_code;
    $filename               = $directory . '/' . $file_name;

    $sdate = $info->academic->from_year . '-' . $info->academic->from_month . '-01';
    $start_date = date('Y-m-d', strtotime($sdate));
    $edate = $info->academic->to_year . '-' . $info->academic->to_month . '-01';
    $end_date = date('Y-m-t', strtotime($edate));

    $salary_pattern = StaffSalaryPattern::where(['staff_id' => $info->staff_id, 'verification_status' => 'approved'])
        ->where(function ($q) use ($start_date, $end_date) {
            $q->where('payout_month', '>=', $start_date);
            $q->where('payout_month', '<=', $end_date);
        })
        ->where('is_current', 'yes')
        ->first();

    if (isset($salary_pattern) && !empty($salary_pattern)) {

        $salary_calculated_month = getTaxOtherSalaryCalulatedMonth($salary_pattern);
    }

    $current_tax_schemes = TaxScheme::where('is_current', 'yes')->first();
    $other_income = OtherIncome::where('status', 'active')->get();
    $deduction_80c = TaxSectionItem::select('tax_section_items.*')->join('tax_sections', 'tax_sections.id', '=', 'tax_section_items.tax_section_id')
        ->where('tax_sections.slug', '80c')
        ->where('tax_section_items.tax_scheme_id', $current_tax_schemes->id)->get();
    $deduction_80c_info = TaxSection::where('slug', '80c')->where('tax_scheme_id', $current_tax_schemes->id)->first();
    $medical_insurance = TaxSectionItem::select('tax_section_items.*', 'tax_sections.maximum_limit')->join('tax_sections', 'tax_sections.id', '=', 'tax_section_items.tax_section_id')
        ->where('tax_sections.slug', 'medical-insurance')
        ->where('tax_section_items.tax_scheme_id', $current_tax_schemes->id)->first();
    $bank_interest_80tta = TaxSectionItem::select('tax_section_items.*', 'tax_sections.maximum_limit')->join('tax_sections', 'tax_sections.id', '=', 'tax_section_items.tax_section_id')
        ->where('tax_sections.slug', '80tta')
        ->where('tax_section_items.tax_scheme_id', $current_tax_schemes->id)->first();

    $national_pension_80cc1b = TaxSectionItem::select('tax_section_items.*', 'tax_sections.maximum_limit')->join('tax_sections', 'tax_sections.id', '=', 'tax_section_items.tax_section_id')
        ->where('tax_sections.slug', '80-ccd-1b')
        ->where('tax_section_items.tax_scheme_id', $current_tax_schemes->id)->first();

    $params = array(
        'pf_data' => $pf_data ?? [],
        'other_income' => $other_income,
        'deduction_80c' => $deduction_80c,
        'deduction_80c_info' => $deduction_80c_info,
        'medical_insurance' => $medical_insurance,
        'bank_interest_80tta' => $bank_interest_80tta,
        'national_pension_80cc1b' => $national_pension_80cc1b,
        'salary_calculated_month' => $salary_calculated_month ?? 0,
        'info' => $info,
        'salary_pattern' => $salary_pattern
    );

    $pdf = PDF::loadView('pages.payroll_management.it_calculation._pdf_view', $params)->setPaper('a4', 'portrait');
    // return $pdf->stream('appointment.pdf');
    Storage::put($filename, $pdf->output());
    $info->document = $file_name;
    $info->save();
}

function getStaffPatterFieldAmount($staff_id, $salary_pattern_id, $field_id = '', $field_name = '', $reference_type = '', $short_name = '')
{
    // DB::beginTransaction();

    // try {
        $info = StaffSalaryPatternField::select('amount')->where('staff_id', $staff_id)->where('staff_salary_pattern_id', $salary_pattern_id)
            ->when(!empty($field_id), function ($query) use ($field_id) {
                $query->where('field_id', $field_id)->first();
            })
            ->where(function ($query) use ($short_name, $field_name) {
                $query->when(!empty($field_name), function ($query) use ($field_name) {
                    $query->where('field_name', $field_name);
                })->when(!empty($short_name), function ($query) use ($short_name) {
                    $query->orWhere('field_name', $short_name);
                });
            })
            ->when(!empty($reference_type), function ($query) use ($reference_type) {
                $query->where('reference_type', $reference_type);
            })
            ->first();

        // Commit the transaction
        // DB::commit();
    // } catch (\Exception $e) {
        // Something went wrong, rollback the transaction
        // DB::rollback();

        // Handle the exception (e.g., log it or throw a custom exception)
        // You might also want to continue the loop or stop entirely based on your use case
    // }


    return $info->amount ?? 0;
}

function staffMonthTax($staff_id, $month)
{
    // dd(strtolower($month));
    $info = StaffTaxSeperation::where('staff_id', $staff_id)->where('status', 'active')->where('academic_id', academicYearId())->first();
    if ($info) {
        $month = strtolower($month);
        return $info->$month ?? 0;
    }
    return 0;
}

function getHoursBetweenHours($from, $to)
{
    $time1 = strtotime($from);
    $time2 = strtotime($to);
    $difference = round(abs($time2 - $time1) / 3600, 2);
    return $difference;
}

function getStaffLeaveRequestStatus($staff_id, $date)
{
    // dump( $date );
    // dump( $staff_id );
   $info = StaffLeave::where('staff_id', $staff_id)
        ->where('from_date', '<=', $date)->where('to_date', '>=', $date)
        ->first();

     $status = '-';
    if ($info) {
        if ($info->status == 'pending') {
            $status = 'Pending';
        } else {
            $status  = 'Approved';
        }
    }
    return $status;
}
function getStaffLeaveRequestType($staff_id, $date)
{
    // dump( $date );
    // dump( $staff_id );
   $info = StaffLeave::where('staff_id', $staff_id)
        ->where('from_date', '<=', $date)->where('to_date', '>=', $date)
        ->first();

     $status = 'U/A';
    if ($info) {
            $status  = $info->leave_category;
        
    }
    return $status;
}
function getSortStaffLeaveType($staff_id, $date)
{
    // dump( $date );
    // dump( $staff_id );

   $info = StaffLeave::where('staff_id', $staff_id)
        ->where('from_date', '<=', $date)->where('to_date', '>=', $date)
        ->first();

     $status = '';
    if ($info) {
            $status  = formatWord($info->leave_category);
            
        
    }
    return $status;
}
function getGlobalAcademicYear()
{

    if (!session()->has('global_academic_year')) {
        $academic = AcademicYear::where('status', 'active')->orderBy('from_year', 'desc')->get();
        session()->put('global_academic_year', $academic);
    }
    return session()->get('global_academic_year');
}

function getStaffSalaryFieldAmount($staff_id, $salary_id, $field_id = '', $field_name = '', $reference_type = '')
{

    $info = StaffSalaryField::where('staff_id', $staff_id)->where('staff_salary_id', $salary_id)
        ->when(!empty($field_id), function ($query) use ($field_id) {
            $query->where('field_id', $field_id)->first();
        })
        ->when(!empty($field_name), function ($query) use ($field_name) {
            $query->where('field_name', $field_name);
        })
        ->when(!empty($reference_type), function ($query) use ($reference_type) {
            $query->where('reference_type', $reference_type);
        })
        ->first();
    return $info->amount ?? 0;
}
function getStaffSalaryPatternAmount($staff_id, $pattern_id,$pattern_type = '')
{

    $info = StaffSalaryField::where('staff_id', $staff_id)->where('staff_salary_id', $salary_id)
        ->when(!empty($field_id), function ($query) use ($field_id) {
            $query->where('field_id', $field_id)->first();
        })
        ->when(!empty($field_name), function ($query) use ($field_name) {
            $query->where('field_name', $field_name);
        })
        ->when(!empty($reference_type), function ($query) use ($reference_type) {
            $query->where('reference_type', $reference_type);
        })
        ->first();
    return $info->amount ?? 0;
}

function RsFormat($amount)
{
    return 'Rs ' . number_format($amount, 2);
}

function amountFormat($amount)
{
    return number_format($amount, 2);
}

function payrollCheck($month, $module)
{

    $month = date('Y-m-1', strtotime($month));
    $info = PayrollPermission::where('payout_month', $month)->first();
    if ($info) {
        if ($info->$module) {
            // dump( $info->$module );
            return $info->$module == 'lock' ? true : false;
        }
    }
    return false;
}

if (!function_exists('isFemale')) {
    function isFemale($id)
    {
        $info = User::find($id);

        if (isset($info->personal->gender) && $info->personal->gender == 'female') {
            return true;
        }
        return false;
    }
}

function getStaffImage($image_path)
{
    if (isset($image_path) && !empty($image_path)) {

        $profile_image = Storage::url($image_path);
        return asset('public' . $profile_image);
    } else {
        return false;
    }
}

function reportMenu()
{
    $customKey = 'is_menu';
    $customValue = true;
    $routes = Route::getRoutes();
    
    $filteredRoutesInfo = [];
    foreach ($routes as $route) {
        $action = $route->getAction();
        if (isset($action[$customKey]) && $action[$customKey] === $customValue) {
            $prefix = str_replace('/', '', $action['prefix']);
            $filteredRoutesInfo[] = [
                'route' => $action['as'],
                'prefix' => $prefix,
                'name' => ucfirst(str_replace('.', ' ', str_replace($prefix . '.', '', $action['as']))),
            ];
        }
    }

    // Group by the 'age' key
    $groupedData = array_reduce($filteredRoutesInfo, function ($result, $item) {
        $key = $item['prefix'];
        if (!isset($result[$key])) {
            $result[$key] = [];
        }
        $result[$key][] = $item;
        return $result;
    }, []);
    return $groupedData;
}

function monthDays($month,$year='')
{
    $year = ($year !='') ? $year : date('Y');
    $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
    return $daysInMonth;
}

function getStartAndEndDateOfMonth($month,$year='')
{
    $year      = ($year !='') ? $year : date('Y');
    $startDate = Carbon::createFromDate($year, $month, 1)->startOfMonth();
    $endDate   = Carbon::createFromDate($year, $month, 1)->endOfMonth();
    return [
        'start_date' => $startDate->format('Y-m-d'),
        'end_date' => $endDate->format('Y-m-d')
    ];
}
function getStartAndEndDateOfYear($year='')
{
    $year      = ($year !='') ? $year : date('Y');
    $startDate = Carbon::createFromDate($year,1, 1)->startOfMonth();
    $endDate   = Carbon::createFromDate($year,12, 1)->endOfMonth();
    return [
        'start_date' => $startDate->format('Y-m-d'),
        'end_date' => $endDate->format('Y-m-d')
    ];
}
function placeOfWork()
{
    return PlaceOfWork::latest()->get();
}

function Department(){
    return Department::select(['id','name'])->latest()->get();
}

function getAprilToMarch($payout_month)
{
    // $payout_month = date('Y-m-d', strtotime($payout_month.' - 1 month'));
    // dd( $payout_month );
    $startMonth = 'April';
    $startMonth = date('F', strtotime($payout_month));
    $endMonth = 'March';
    // Create DateTime objects for the start and end months
    $startDate = new DateTime($startMonth);
    $endDate = new DateTime($endMonth);

    // If the end month comes before the start month, it means we need to go to the next year
    if ($endDate < $startDate) {
        $endDate->modify('+1 year');
        // $endDate->modify('+1 month');
    }

    // Adjust the start month to the 1st of April of the current year
    $startDate->modify('first day of ' . $startMonth . ' this year');

    // Initialize an array to store the months
    $months = [];

    // Create a DatePeriod object to loop through the months
    $interval = new DateInterval('P1M');
    $dateRange = new DatePeriod($startDate, $interval, $endDate);
    // dd( $dateRange );
    // Loop through the months and store them in the array
    foreach ($dateRange as $date) {
        $months[] = strtolower($date->format('F')); // 'F' format returns the full month name
    }

    // Output the months
    return $months;
}


function getStaffLeaveDeductionAmount($staff_id, $date)
{

    $attendance_date = date('Y-m-d', strtotime($date . '-1 month'));
    $start_date = date('Y-m-1',  strtotime($attendance_date));
    $ends_date = date('Y-m-t',  strtotime($attendance_date));
    $attendance_status = 'Absence';

    $data = AttendanceManualEntry::select('attendance_manual_entries.*', 'users.name as staff_name', 'leave_statuses.name as leave_status_name')
        ->leftJoin('users', 'users.id', '=', 'attendance_manual_entries.employment_id')
        ->leftJoin('leave_statuses', 'leave_statuses.id', '=', 'attendance_manual_entries.attendance_status_id')
        ->where('attendance_date', '>=', $start_date)
        ->where('attendance_date', '<=', $ends_date)
        ->where('employment_id', $staff_id)
        ->when(!empty($attendance_status), function ($q) use ($attendance_status) {
            $q->where('attendance_status', $attendance_status);
        })->get();

    $deduction_day = 0;
  
    if (isset($data) && !empty($data)) {
        foreach ($data as $row) {
            $status = getStaffLeaveRequestStatus($row->employment_id, $row->attendance_date);

            if ($status != 'Leave Approved') {
                $deduction_day += 1;
            }
        }
    }
    // dump( $deduction_day );
    return $deduction_day;
}

function getDaySalaryAmount($gross, $month_length)
{
    return round($gross / $month_length);
}


function taxPaidPayroll($staff_id, $salary_pattern_id)
{
    /**
     *  get tax id 
     */
    $income_tax = SalaryField::where('short_name', 'IT')->first();
    $income_tax_id = $income_tax->id;

    $info = StaffSalary::select('staff_salary_fields.amount as incometax_amount')->join('staff_salary_fields', function ($join) use ($income_tax_id) {
        $join->on('staff_salary_fields.staff_salary_id', '=', 'staff_salaries.id')->where('field_id', $income_tax_id);
    })
        ->where('staff_salaries.staff_id', $staff_id)
        ->where('staff_salaries.salary_pattern_id', $salary_pattern_id)->get()->sum('incometax_amount');

    return $info ?? 0;
}

function getBankLoansAmount($staff_id, $date)
{

    $arr = [];
    $total_amount = 0;
    $loan_details = StaffBankLoan::where(['status' => 'active', 'staff_id' => $staff_id])->get();
    if (isset($loan_details) && !empty($loan_details)) {
        foreach ($loan_details as $item) {
            if (isset($item->emi) && count($item->emi) > 0) {
                foreach ($item->emi as $emi_item) {
                    $tmp = [];
                    if ($emi_item->emi_month == $date && $emi_item->status == 'active') {

                        $tmp['amount'] = $emi_item->amount;
                        $tmp['details'] = $emi_item;
                        $total_amount += $emi_item->amount ?? 0;

                        $arr[] = $tmp;
                    }
                }
            }
        }
    }

    return ['total_amount' => $total_amount, 'emi' => $arr];
}


function getInsuranceAmount($staff_id, $date)
{

    $arr = [];
    $total_amount = 0;
    $loan_details = StaffInsurance::where(['status' => 'active', 'staff_id' => $staff_id])->get();
    if (isset($loan_details) && !empty($loan_details)) {
        foreach ($loan_details as $item) {
            if (isset($item->emi) && count($item->emi) > 0) {
                foreach ($item->emi as $emi_item) {
                    $tmp = [];
                    if ($emi_item->emi_month == $date && $emi_item->status == 'active') {

                        $tmp['amount'] = $emi_item->amount;
                        $tmp['details'] = $emi_item;
                        $total_amount += $emi_item->amount ?? 0;

                        $arr[] = $tmp;
                    }
                }
            }
        }
    }

    return ['total_amount' => $total_amount, 'emi' => $arr];
}

function getEarningInfo( $staff_id, $earning_type, $date ) {

    $info = StaffSalaryPreEarning::where('salary_month', $date)
            ->where('earnings_type', $earning_type)
            ->where('staff_id', $staff_id)
            ->where('status', 'active')
            ->first();
    return $info ?? '';
}

function getDeductionInfo( $staff_id, $deduction_type, $date ) {
    
    $info = StaffSalaryPreDeduction::where('salary_month', $date)
            ->where('deduction_type', $deduction_type)
            ->where('staff_id', $staff_id)
            ->where('status', 'active')
            ->first();
    return $info ?? '';
}

function findMonthBetweenDates($start_date, $end_date) {

    $date1 = $start_date;
    $date2 = $end_date;
    $d1 = new DateTime($date2); 
    $d2 = new DateTime($date1);                                  
    $Months = $d2->diff($d1); 
    $howeverManyMonths = (($Months->y) * 12) + ($Months->m);
    return $howeverManyMonths;

}
if (!function_exists('formatWord')) {
    function formatWord($name)
    {
    $words = explode(' ', $name);
    $initials = [];
    foreach ($words as $word) {
    $initials[] = strtoupper(substr($word, 0, 1));
    }
    return implode('', $initials);
    }
}
if (!function_exists('leave_data')) {
    function leaveData($staff_id,$year,$leave_category)
    {
      $leave_datas=StaffLeave::where('staff_id',$staff_id)->where('leave_category',$leave_category)->whereYear('from_date',$year)->select(DB::raw('SUM(granted_days) as total_days'))
        ->groupBy('leave_category')->first();
            
    return $leave_datas->total_days??'0.00';
    }

    if (!function_exists('getLeaveDays')) {
    function getLeaveDays($leaves, $category)
    {
    $totalDays = 0;
    foreach ($leaves as $leave) {
        if ($leave->leave_category == $category) {
            $totalDays += $leave->granted_days;
        }
    }
    return $totalDays;
    }
   }
  if (!function_exists('getYearsBetween')) {
   function getYearsBetween($startYear, $endYear){
    $years = [];
    if ($startYear > $endYear) {
        return $years;
    }
    for ($year = $startYear; $year <= $endYear; $year++) {
        $years[] = $year;
    }
    return $years;
   }
  }
  if (!function_exists('getLeaveMapping')) {
   function getLeaveMapping($staff_id, $acadamic_id,$type){
    if($type=='cl'){
        $leave_head_id=1;
    }else if($type=='el'){
        $leave_head_id=2;
    }else if($type=='ml'){
        $leave_head_id=3;
    }else{
        $leave_head_id=5;
    }
    $data=StaffLeaveMapping::where('staff_id',$staff_id)->where('leave_head_id',$leave_head_id)->where('acadamic_id',$acadamic_id)->select('id','staff_id','leave_head_id','acadamic_id','no_of_leave  as leave_days','carry_forward_count','accumulated')->first();
    return $data;
  }
  }
  if (!function_exists('getLeaveELEntry')) {
   function getLeaveELEntry($staff_id, $academic_id,$fromDate,$toDate){
     $el_data=StaffELEntry::where('staff_id',$staff_id)->where('academic_id',$academic_id)->whereBetween('from_date', [$fromDate, $toDate])
        ->whereBetween('to_date', [$fromDate, $toDate])->select(DB::raw('SUM(leave_days) as total_days'))->first();
        return $el_data;
   }
   }
    if (!function_exists('StaffleaveAllocated')) {
   function StaffleaveAllocated($staff_id, $academic_id){
    $data=StaffLeaveMapping::where('staff_id',$staff_id)->where('acadamic_id',$academic_id)->get();
    return $data ??[];
   }
}
   


}


