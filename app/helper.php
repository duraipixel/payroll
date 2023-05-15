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

if (!function_exists('academicYearId')) {
    function academicYearId()
    {
        $data = AcademicYear::where('is_current', 1)->first();
        return $data->id;
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

}
