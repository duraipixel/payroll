<?php

use App\Models\AcademicYear;
use App\Models\Staff\StaffKnownLanguage;
use App\Models\Staff\StaffPersonalInfo;
use App\Models\Staff\StaffProfessionalData;
use App\Models\Staff\StaffStudiedSubject;
use App\Models\Staff\StaffTalent;
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

        }
        return $step;

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






