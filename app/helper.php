<?php

use App\Models\AcademicYear;
use App\Models\User;

if (!function_exists('academicYearId')) {
    function academicYearId()
    {
        $data = AcademicYear::where('is_current', 1)->first();
        return $data->id;
    }
}

if (!function_exists('isPersonalWizardCompleted')) {
    function isPersonalWizardCompleted($staff_id)
    {
        $response = false;
        $info = User::find($staff_id);
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


