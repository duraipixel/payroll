<?php

use App\Models\AcademicYear;
use App\Models\Staff\StaffPersonalInfo;
use App\Models\Staff\StaffProfessionalData;
use App\Models\Staff\StaffStudiedSubject;
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

if (!function_exists('isKycWizardCompleted')) {
    function isKycWizardCompleted($staff_id)
    {
        
    }
}

if (!function_exists('isEmpPositionWizardCompleted')) {
    function isEmpPositionWizardCompleted($staff_id)
    {
        
    }
}

if (!function_exists('isFamilyInfoWizardCompleted')) {
    function isFamilyInfoWizardCompleted($staff_id)
    {
        
    }
}

if (!function_exists('isMedicInfoWizardCompleted')) {
    function isMedicInfoWizardCompleted($staff_id)
    {
        
    }
}

if (!function_exists('isAppointmentWizardCompleted')) {
    function isAppointmentWizardCompleted($staff_id)
    {
        
    }
}



