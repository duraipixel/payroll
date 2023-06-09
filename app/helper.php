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
use App\Models\Staff\StaffNominee;
use App\Models\Staff\StaffPersonalInfo;
use App\Models\Staff\StaffProfessionalData;
use App\Models\Staff\StaffStudiedSubject;
use App\Models\Staff\StaffTalent;
use App\Models\Staff\StaffWorkExperience;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use App\Models\Role\Permission;
use App\Helpers\AccessGuard;
use App\Models\AttendanceManagement\LeaveMapping;
use App\Models\Master\Institution;
use App\Models\PayrollManagement\StaffSalary;
use App\Models\PayrollManagement\StaffSalaryField;

if (!function_exists('academicYearId')) {
    function academicYearId()
    {
        $data = AcademicYear::where('is_current', 1)->first();
        if( session()->get('academic_id') && !empty( session()->get('academic_id') ) ) {
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
    function permissionCheckAll($role_id,$menu_type)
    {
        $check_array=[];
        foreach ($menu_type as $key => $value) {
            $menu_check = Permission::where('role_id', $role_id)->where('add_edit_menu','1')
            ->where('view_menu','1')->where('delete_menu','1')->where('export_menu','1')->where('route_name',$key)->first();   
            if($menu_check)
            {
                $check_array=1;
            }
            else
            {
                $check_array=0;
            }
        }
        return $check_array;
    }
}

if (!function_exists('permissionCheck')) {
    function permissionCheck($role_id,$key,$type)
    {
        if($type=='add_edit')
        {
            $menu_check = Permission::where('role_id', $role_id)->where('add_edit_menu','1')->where('route_name',$key)->first();            
        }
        else if($type=='view')
        {
            $menu_check = Permission::where('role_id', $role_id)->where('view_menu','1')->where('route_name',$key)->first(); 
        }
        else if($type=='delete')
        {
            $menu_check = Permission::where('role_id', $role_id)->where('delete_menu','1')->where('route_name',$key)->first(); 
        }
        else if($type=='export')
        {
            $menu_check = Permission::where('role_id', $role_id)->where('export_menu','1')->where('route_name',$key)->first();
        }
        else
        {
            return false; 
        }
        if($menu_check)            
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
            $appointment_data = StaffAppointmentDetail::where('staff_id', $staff_id)->first();
            if ($appointment_data) {
                $step = 7;
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

            $education = StaffEducationDetail::where(['staff_id' => $staff_id, 'status' => 'active'])->get();
            if (count($education) > 0) {
                $percentage += 10;
            }

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


if (!function_exists('getStudiedSubjects')) {
    function getStudiedSubjects($staff_id, $subject_id, $class_id = '')
    {
        return StaffStudiedSubject::where('staff_id', $staff_id)
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
    function generateLeaveForm($leave_id)
    {
        $leave_info = StaffLeave::find($leave_id);
        $data['institute_name'] = $leave_info->staff_info->institute->name;
        $data['application_no'] = $leave_info->application_no;
        $data['application_date'] = date('d/M/Y', strtotime($leave_info->created_at));
        $data['designation'] = $leave_info->designation;
        $data['place_of_work'] = $leave_info->place_of_work;
        $data['salary'] = $leave_info->salary;
        $data['date_requested'] = date('d/M/Y', strtotime($leave_info->from_date)) . ' - ' . date('d/M/Y', strtotime($leave_info->to_date));
        $data['no_of_days'] = $leave_info->no_of_days;
        $data['reason'] = $leave_info->reason ?? '';
        $data['address'] = $leave_info->address ?? '';
        $data['staff_name'] = $leave_info->staff_info->name;
        $data['staff_code'] = $leave_info->staff_info->institute_emp_code ?? $leave_info->staff_info->emp_code;
        $data['taken_leave'] = '';
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
        return true;
    }

    function buildTree( $reportee_id ) {
        
        $info = ReportingManager::where('reportee_id', $reportee_id)->where('is_top_level', 'no')->get();
        $tree_view = '';
        if( isset( $info ) && !empty( $info )) {
            $tree_view = '<ul class="active">';
            foreach ($info as $item_value) {
                
                $tree_view .= ' <li>
                                    <a href="javascript:void(0);">
                                        <div class="member-view-box">
                                            <div class="member-image">
                                                <img src="http://localhost/amalpayroll/assets/images/no_Image.jpg"
                                                    alt="Member">
                                                <div class="member-details">
                                                    <h3>'.$item_value->manager->name.'</h3>
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

    function buildChild( $reportee_id ) {
        
        $list  = '';
        $info = ReportingManager::where('reportee_id', $reportee_id)->where('is_top_level', 'no')->get();
        
        if( isset( $info ) && !empty( $info )) {
            $list = '<ul class="active">';
            foreach ($info as $item_value) {
                
                $list .= ' <li>
                                    <a href="javascript:void(0);">
                                        <div class="member-view-box">
                                            <div class="member-image">
                                                <img src="http://localhost/amalpayroll/assets/images/no_Image.jpg"
                                                    alt="Member">
                                                <div class="member-details">
                                                    <h3>'.$item_value->manager->name.'</h3>
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

    function getTotalExperience($staff_id) {
        return '1 year';//need to do calculation
    }

    function commonDateFormat( $date ){
        return date('d/m/Y', strtotime($date));
    }

    function getTotalLeaveCount($staff_id) {
        $staff_info = User::find($staff_id);
        $allocated_total_leave = 0;
        $taken_leave = 0;
        $balance_leave = 0;
        if( $staff_info->appointment->nature_of_employment_id ?? '' ){
            $total_leaves = LeaveMapping::selectRaw('sum(CAST(leave_mappings.leave_days AS DECIMAL(10, 2))) as total')->where('nature_of_employment_id', $staff_info->appointment->nature_of_employment_id)->where('status', 'active')->first();
            
            if( $total_leaves ) {
                $allocated_total_leave = $total_leaves->total;
            }
        }
        $leaves = StaffLeave::selectRaw('SUM(no_of_days) as taken_leave')->where('staff_id', $staff_id)
                    // ->where('status', 'approved')
                    ->first();
        if( $leaves ) {
            $taken_leave = $leaves->taken_leave ?? 0;
        }
        if( $allocated_total_leave >= $taken_leave ) {
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
        $date = '1/Jan/'.date('Y').' - 31/Dec/'.date('Y');
        return $date;
    }

    function getAllInstitute() {
        return Institution::where('status', 'active')->get();
    }

    function getInstituteInfo($id) {
        return Institution::find($id);
    }

    function getSalarySelectedFields($staff_id, $staff_salary_id, $field_id)
    {
        return StaffSalaryField::where('staff_id', $staff_id)->where('staff_salary_id', $staff_salary_id)
                ->where('field_id', $field_id)->first();
    }

}

if (!function_exists('getStaffVerificationStatus')) {
    function getStaffVerificationStatus($staff_id, $module)
    {

        $user_info = User::find( $staff_id );

        switch ($module) {
            case 'data_entry':
                $personalInfo = StaffPersonalInfo::where('staff_id', $staff_id)->first();
                $professional_data = StaffProfessionalData::where('staff_id', $staff_id)->first();
                $education = StaffEducationDetail::where(['staff_id' => $staff_id, 'status' => 'active'])->get();
                $family_members = StaffFamilyMember::where(['staff_id' => $staff_id, 'status' => 'active'])->get();
                $nominee = StaffNominee::where(['staff_id' => $staff_id])->get();
                $health_details = StaffHealthDetail::where('staff_id', $staff_id)->first();
                $expeince = StaffWorkExperience::where(['staff_id' => $staff_id, 'status' => 'active'])->get();
                $knownLanguages = StaffKnownLanguage::where(['staff_id' => $staff_id, 'status' => 'active'])->get();
                // $studienSubject = StaffStudiedSubject::where(['staff_id' => $staff_id, 'status' => 'active'])->get();
                $staffbank = StaffBankDetail::where(['staff_id' => $staff_id, 'status' => 'active'])->get();
                $return = false;
                
                if( $personalInfo && $professional_data && count( $education ) > 0 && count($family_members) > 0 && count($nominee) > 0 && $health_details && count($expeince) > 0 &&  count($knownLanguages) > 0 && count($staffbank) > 0  ){
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
                $education = StaffEducationDetail::where(['staff_id' => $staff_id, 'status' => 'active'])->get();
                $doc_education = StaffEducationDetail::where(['staff_id' => $staff_id, 'status' => 'active'])->whereNull('doc_file')->get();
                $expeince = StaffWorkExperience::where(['staff_id' => $staff_id, 'status' => 'active'])->get();
                $doc_expeince = StaffWorkExperience::where(['staff_id' => $staff_id, 'status' => 'active'])->whereNull('doc_file')->get();
                $personal_doc = StaffDocument::where(['staff_id' => $staff_id, 'status' => 'active'])->get();
                $return = false;
            
                if( count($education) > 0 && count($doc_education) == 0 && count( $expeince ) > 0 && count($doc_expeince) == 0 && count($personal_doc) > 0 ) {
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
                $education = StaffEducationDetail::where(['staff_id' => $staff_id, 'status' => 'active'])->get();
                $doc_education = StaffEducationDetail::where(['staff_id' => $staff_id,  'verification_status' => 'approved'])->whereNotNull('doc_file')->get();
                $expeince = StaffWorkExperience::where(['staff_id' => $staff_id, 'status' => 'active'])->get();
                $doc_expeince = StaffWorkExperience::where(['staff_id' => $staff_id,  'verification_status' => 'approved'])->whereNotNull('doc_file')->get();
                $personal_doc = StaffDocument::where(['staff_id' => $staff_id, 'status' => 'active'])->get();
                $count_personal_doc = StaffDocument::where(['staff_id' => $staff_id, 'verification_status' => 'approved'])->get();
                $return = false;
                if( count( $education ) > 0 &&  count($expeince) > 0 && count($personal_doc) > 0 ) {

                    if( ( count($education) == count($doc_education) )  && ( count( $expeince ) == count($doc_expeince) ) && count($personal_doc) == count($count_personal_doc) ) {
                        $return = true;
                    }
                }
                return $return;
                break;
            case 'salary_entry';
                $return = false;
                $staff_salaries = StaffSalary::where('staff_id', $staff_id)->where('status', 'active')->first();
                if( $staff_salaries ) {
                    $return = true;
                }
                return $return;
            break;
            default:
                return false;
                break;
        }
    }

    function canGenerateEmpCode($staff_id) {
        $personalInfo = StaffPersonalInfo::where('staff_id', $staff_id)->first();
        $professional_data = StaffProfessionalData::where('staff_id', $staff_id)->first();
        $education = StaffEducationDetail::where(['staff_id' => $staff_id, 'status' => 'active'])->get();
        $family_members = StaffFamilyMember::where(['staff_id' => $staff_id, 'status' => 'active'])->get();
        $nominee = StaffNominee::where(['staff_id' => $staff_id])->get();
        $health_details = StaffHealthDetail::where('staff_id', $staff_id)->first();
        $expeince = StaffWorkExperience::where(['staff_id' => $staff_id, 'status' => 'active'])->get();
        $knownLanguages = StaffKnownLanguage::where(['staff_id' => $staff_id, 'status' => 'active'])->get();
        $studienSubject = StaffStudiedSubject::where(['staff_id' => $staff_id, 'status' => 'active'])->get();
        $staffbank = StaffBankDetail::where(['staff_id' => $staff_id, 'status' => 'active'])->get();
        $personal_return = false;
        if( $personalInfo && $professional_data && count( $education ) > 0 && count($family_members) > 0 && count($nominee) > 0 && $health_details && count($expeince) > 0 &&  count($knownLanguages) > 0 && count($studienSubject) > 0 && count($staffbank) > 0  ){
            $personal_return = true;
        }

        $education = StaffEducationDetail::where(['staff_id' => $staff_id, 'status' => 'active'])->get();
        $doc_education = StaffEducationDetail::where(['staff_id' => $staff_id, 'status' => 'active'])->whereNull('doc_file')->get();
        $expeince = StaffWorkExperience::where(['staff_id' => $staff_id, 'status' => 'active'])->get();
        $doc_expeince = StaffWorkExperience::where(['staff_id' => $staff_id, 'status' => 'active'])->whereNull('doc_file')->get();
        $personal_doc = StaffDocument::where(['staff_id' => $staff_id, 'status' => 'active'])->get();
        $edu_return = false;
    
        if( count($education) > 0 && count($doc_education) == 0 && count( $expeince ) > 0 && count($doc_expeince) == 0 && count($personal_doc) > 0 ) {
          $edu_return = true;
        }

        $education = StaffEducationDetail::where(['staff_id' => $staff_id, 'status' => 'active'])->get();
        $doc_education = StaffEducationDetail::where(['staff_id' => $staff_id,  'verification_status' => 'approved'])->whereNotNull('doc_file')->get();
        $expeince = StaffWorkExperience::where(['staff_id' => $staff_id, 'status' => 'active'])->get();
        $doc_expeince = StaffWorkExperience::where(['staff_id' => $staff_id,  'verification_status' => 'approved'])->whereNotNull('doc_file')->get();
        $personal_doc = StaffDocument::where(['staff_id' => $staff_id, 'status' => 'active'])->get();
        $count_personal_doc = StaffDocument::where(['staff_id' => $staff_id, 'verification_status' => 'approved'])->get();
        $verified_return = false;
        if( ( count($education) == count($doc_education) )  && ( count( $expeince ) == count($doc_expeince) ) && count($personal_doc) == count($count_personal_doc) ) {
            $verified_return = true;
        }

        $is_return = false;
        if( $verified_return && $edu_return && $personal_return ){
            $is_return = true;
        }
        return $is_return;
    }
}