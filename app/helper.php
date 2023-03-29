<?php

use App\Models\AcademicYear;
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
        if( $info ) {
            $step = 1;

            $personalInfo = StaffPersonalInfo::where('staff_id', $staff_id)->first();
            if( $personalInfo ) {
                $step = 2;
            }

            $professional_data = StaffProfessionalData::where('staff_id', $staff_id)->first();
            if( $professional_data ) {
                $step = 3;
            }

            $step = 6;
            $appointment_data = StaffAppointmentDetail::where('staff_id', $staff_id)->first();
            if( $appointment_data ) {
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
        if( $info ) {
            $percentage = 10;

            $personalInfo = StaffPersonalInfo::where('staff_id', $staff_id)->first();
            if( $personalInfo ) {
                $percentage += 10;
            } //

            $professional_data = StaffProfessionalData::where('staff_id', $staff_id)->first();
            if( $professional_data ) {
                $percentage += 10;
            }

            $documents = StaffDocument::where(['staff_id' => $staff_id, 'status' => 'active'])->get();
            if( count( $documents ) > 0 ) {
                $percentage += 10;
            }

            $education = StaffEducationDetail::where(['staff_id' => $staff_id, 'status' => 'active'])->get();
            if( count( $education ) > 0 ) {
                $percentage += 10;
            }

            $family_members = StaffFamilyMember::where(['staff_id' => $staff_id, 'status' => 'active'])->get();
            if( count( $family_members ) > 0 ) {
                $percentage += 5;
            }

            $nominee = StaffNominee::where(['staff_id' => $staff_id])->get();
            if( count( $nominee ) > 0 ) {
                $percentage += 5;
            }
            //so far 60%
            $health_details = StaffHealthDetail::where('staff_id', $staff_id)->first();
            if( $health_details ) {
                $percentage += 5;
            }
            //65%
            $expeince = StaffWorkExperience::where(['staff_id' => $staff_id, 'status' => 'active'])->get();
            if( count( $expeince ) > 0 ) {
                $percentage += 5;
            } // 70%

            $knownLanguages = StaffKnownLanguage::where(['staff_id' => $staff_id, 'status' => 'active'])->get();
            if( count( $knownLanguages ) > 0 ) {
                $percentage += 5;
            } // 75%
            $studienSubject = StaffStudiedSubject::where(['staff_id' => $staff_id, 'status' => 'active'])->get();
            if( count( $studienSubject ) > 0 ) {
                $percentage += 5;
            } // 80%
            $staffbank = StaffBankDetail::where(['staff_id' => $staff_id, 'status' => 'active'])->get();
            if( count( $staffbank ) > 0 ) {
                $percentage += 5;
            } // 85%

            $appointment_data = StaffAppointmentDetail::where('staff_id', $staff_id)->first();
            if( $appointment_data ) {
                $percentage += 10;
            }

            if( $info->verification_status == 'approved') {
                //available status => ['approved', 'draft', 'rejected', 'cancelled', 'pending']
                $percentage = 100;
                
            }

        }
        return $percentage;

    }
}


if (!function_exists('getStudiedSubjects')) {
    function getStudiedSubjects( $staff_id, $subject_id, $class_id = '' )
    {
        return StaffStudiedSubject::where('staff_id', $staff_id)
                ->where('subject_id', $subject_id)
                ->when($class_id != '', function($q) use($class_id){
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






