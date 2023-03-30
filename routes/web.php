<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('layouts.template');
// });

Auth::routes();

Route::group(['middleware' => 'auth'],  function () {

    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::post('/open/modal', [App\Http\Controllers\CommonController::class, 'openAddModal'])->name('modal.open');

    Route::post('/save/institution', [App\Http\Controllers\Master\InstitutionController::class, 'save'])->name('save.institute');
    Route::post('/get/institution/staff/code', [App\Http\Controllers\Master\InstitutionController::class, 'getInstituteStaffCode'])->name('institute.staff.code');

    Route::post('/save/division', [App\Http\Controllers\Master\DivisionController::class, 'save'])->name('save.division');
    Route::post('/save/class', [App\Http\Controllers\Master\ClassesController::class, 'save'])->name('save.class');
    Route::post('/save/language', [App\Http\Controllers\Master\LanguageController::class, 'save'])->name('save.language');
    Route::post('/save/place', [App\Http\Controllers\Master\PlaceController::class, 'save'])->name('save.place');
    Route::post('/save/nationality', [App\Http\Controllers\Master\NationalityController::class, 'save'])->name('save.nationality');
    Route::post('/save/religion', [App\Http\Controllers\Master\ReligionController::class, 'save'])->name('save.religion');
    Route::post('/save/caste', [App\Http\Controllers\Master\CasteController::class, 'save'])->name('save.caste');
    Route::post('/save/community', [App\Http\Controllers\Master\CommunityController::class, 'save'])->name('save.community');
    Route::post('/save/bank', [App\Http\Controllers\Master\BankController::class, 'save'])->name('save.bank');
    Route::post('/save/branch', [App\Http\Controllers\Master\BankBranchController::class, 'save'])->name('save.branch');
    Route::post('/get/branch', [App\Http\Controllers\Master\BankBranchController::class, 'getBankBranches'])->name('branch.all');

    Route::get('staff/register/{id?}', [App\Http\Controllers\StaffController::class, 'register'])->name('staff.register');
    Route::post('staff/add/personal', [App\Http\Controllers\StaffController::class, 'insertPersonalData'])->name('staff.save.personal');
    Route::post('staff/add/kyc', [App\Http\Controllers\StaffController::class, 'insertKycData'])->name('staff.save.kyc');
    Route::post('staff/add/position', [App\Http\Controllers\StaffController::class, 'insertEmployeePosition'])->name('staff.save.employee_position');
    Route::post('staff/add/education', [App\Http\Controllers\StaffController::class, 'insertEducationDetails'])->name('staff.save.education_details');
    Route::post('staff/get/draftData', [App\Http\Controllers\StaffController::class, 'getStaffDraftData'])->name('staff.get.draft.data');
    Route::post('staff/add/familyData', [App\Http\Controllers\StaffController::class, 'checkFamilyData'])->name('staff.save.familyPhase');

    Route::post('/save/designation', [App\Http\Controllers\Master\DesignationController::class, 'save'])->name('save.designation');
    Route::post('/save/department', [App\Http\Controllers\Master\DepartmentController::class, 'save'])->name('save.department');
    Route::post('/save/subject', [App\Http\Controllers\Master\SubjectController::class, 'save'])->name('save.subject');
    Route::post('/list/subject/studied', [App\Http\Controllers\Master\SubjectController::class, 'getSubjectStudied'])->name('get.studied.subject');
    Route::post('/save/scheme', [App\Http\Controllers\Master\AttendanceSchemeController::class, 'save'])->name('save.scheme');
    Route::post('/save/duty/class', [App\Http\Controllers\Master\DutyClassController::class, 'save'])->name('save.duty.class');
    Route::post('/save/duty/type', [App\Http\Controllers\Master\DutyTypeController::class, 'save'])->name('save.duty.type');
    Route::post('/save/other/school', [App\Http\Controllers\Master\OtherSchoolController::class, 'save'])->name('save.other.school');

    Route::post('/save/invigilation', [App\Http\Controllers\Staff\InvigilationDutyController::class, 'save'])->name('save.invigilation');
    Route::post('/form/invigilation/content', [App\Http\Controllers\Staff\InvigilationDutyController::class, 'formContent'])->name('form.invigilation.content');
    Route::post('/invigilation/list', [App\Http\Controllers\Staff\InvigilationDutyController::class, 'getStaffInvigilationList'])->name('staff.invigilation.list');
    Route::post('/invigilation/delete', [App\Http\Controllers\Staff\InvigilationDutyController::class, 'deleteStaffInvigilation'])->name('staff.invigilation.delete');

    Route::post('/save/training/topic', [App\Http\Controllers\Master\TrainingTopicController::class, 'save'])->name('save.training.topic');
    Route::post('/save/staff/training', [App\Http\Controllers\Staff\StaffTrainingController::class, 'save'])->name('save.staff.training');
    Route::post('/form/training/content', [App\Http\Controllers\Staff\StaffTrainingController::class, 'formContent'])->name('form.training.content');
    Route::post('/training/list', [App\Http\Controllers\Staff\StaffTrainingController::class, 'getStaffTrainingList'])->name('staff.training.list');
    Route::post('/training/delete', [App\Http\Controllers\Staff\StaffTrainingController::class, 'deleteStaffTraining'])->name('staff.training.delete');

    Route::post('/save/board', [App\Http\Controllers\Master\BoardController::class, 'save'])->name('save.board');
    Route::post('/save/type', [App\Http\Controllers\Master\ProfessionTypeController::class, 'save'])->name('save.type');
    Route::post('/save/relationship', [App\Http\Controllers\Master\RelationshipTypeController::class, 'save'])->name('save.relationship');
    Route::post('/save/qualification', [App\Http\Controllers\Master\QualificationController::class, 'save'])->name('save.qualification');
    Route::post('/save/blood_group', [App\Http\Controllers\Master\BloodGroupController::class, 'save'])->name('save.blood_group');

    Route::post('/save/staff/education', [App\Http\Controllers\Staff\StaffEducationController::class, 'save'])->name('save.staff.course');
    Route::post('/save/list/course', [App\Http\Controllers\Staff\StaffEducationController::class, 'list'])->name('staff.course.list');
    Route::post('/form/content/course', [App\Http\Controllers\Staff\StaffEducationController::class, 'formContent'])->name('form.course.content');
    Route::post('/course/delete', [App\Http\Controllers\Staff\StaffEducationController::class, 'deleteStaffCourse'])->name('staff.course.delete');

    Route::post('/save/staff/experience', [App\Http\Controllers\Staff\StaffWorkExperienceController::class, 'save'])->name('save.staff.experience');
    Route::post('/save/list/experience', [App\Http\Controllers\Staff\StaffWorkExperienceController::class, 'getStaffExperienceList'])->name('staff.experience.list');
    Route::post('/form/content/experience', [App\Http\Controllers\Staff\StaffWorkExperienceController::class, 'formContent'])->name('form.experience.content');
    Route::post('/experience/delete', [App\Http\Controllers\Staff\StaffWorkExperienceController::class, 'deleteStaffExperience'])->name('staff.experience.delete');

    Route::post('/member/list', [App\Http\Controllers\Staff\StaffFamilyMemberController::class, 'list'])->name('staff.member.list');
    Route::post('/member/save', [App\Http\Controllers\Staff\StaffFamilyMemberController::class, 'save'])->name('staff.member.save');
    Route::post('/member/form/content', [App\Http\Controllers\Staff\StaffFamilyMemberController::class, 'formContent'])->name('form.family.content');
    Route::post('/member/delete', [App\Http\Controllers\Staff\StaffFamilyMemberController::class, 'deleteStaffFamilyMember'])->name('staff.family.delete');

    //Bulk upload for staff information staff
    Route::get('/staff/bulk', [App\Http\Controllers\Staff\BulkUploadController::class, 'index'])->name('staff.bulk'); 
    Route::post('/bulk/save', [App\Http\Controllers\Staff\BulkUploadController::class, 'store'])->name('staff.save'); 
     //Bulk upload for staff information End

    Route::post('/staff/nominee/get', [App\Http\Controllers\Staff\StaffNomineeController::class, 'getStaffNominee'])->name('staff.nominee.get');
    Route::post('/staff/nominee/info', [App\Http\Controllers\Staff\StaffNomineeController::class, 'getStaffNomineeInfo'])->name('staff.nominee.info');
    Route::post('/staff/nominee/save', [App\Http\Controllers\Staff\StaffNomineeController::class, 'save'])->name('staff.nominee.save');
    Route::post('/staff/content/nominee/form', [App\Http\Controllers\Staff\StaffNomineeController::class, 'formContent'])->name('staff.nominee.form.content');
    Route::post('/staff/nominee/list', [App\Http\Controllers\Staff\StaffNomineeController::class, 'list'])->name('staff.nominee.list');
    Route::post('/staff/nominee/delete', [App\Http\Controllers\Staff\StaffNomineeController::class, 'deleteStaffNominee'])->name('staff.nominee.delete');

    Route::post('/staff/workingrelation/save', [App\Http\Controllers\Staff\StaffWorkingRelationController::class, 'save'])->name('staff.save.working_relationship');
    Route::post('/staff/workingrelation/list', [App\Http\Controllers\Staff\StaffWorkingRelationController::class, 'staffWorkingList'])->name('staff.working.relation.list');
    Route::post('/staff/workingrelation/formcontent', [App\Http\Controllers\Staff\StaffWorkingRelationController::class, 'formContent'])->name('staff.working.relation.content');
    Route::post('/staff/workingrelation/delete', [App\Http\Controllers\Staff\StaffWorkingRelationController::class, 'deleteStaffWorkingRelation'])->name('staff.relation.working.delete');

    Route::post('/staff/medical/save', [App\Http\Controllers\Staff\StaffHealthDetailController::class, 'save'])->name('staff.save.medical_information');

    Route::post('/staff/medical/remark/save', [App\Http\Controllers\Staff\StaffMedicalRemarkController::class, 'save'])->name('save.medical.remarks');
    Route::post('/staff/medical/remark/list', [App\Http\Controllers\Staff\StaffMedicalRemarkController::class, 'list'])->name('staff.medic.remarks.list');
    Route::post('/staff/medical/remark/content', [App\Http\Controllers\Staff\StaffMedicalRemarkController::class, 'formContent'])->name('form.medic.remark.content');
    Route::post('/staff/medical/remark/delete', [App\Http\Controllers\Staff\StaffMedicalRemarkController::class, 'deleteStaffMedcialRemarks'])->name('delete.medic.remark');

    Route::post('/staff/category/save', [App\Http\Controllers\Master\StaffCategoryController::class, 'save'])->name('save.staff_category');
    Route::post('/staff/nature/save', [App\Http\Controllers\Master\NatureOfEmploymentController::class, 'save'])->name('save.nature_of_employeement');
    Route::post('/staff/teaching_type/save', [App\Http\Controllers\Master\TeachingTypeController::class, 'save'])->name('save.teaching_type');
    Route::post('/staff/workplace/save', [App\Http\Controllers\Master\PlaceOfWorkController::class, 'save'])->name('save.work_place');
    Route::post('/staff/ordermodel/save', [App\Http\Controllers\Master\AppointmentOrderModelController::class, 'save'])->name('save.order_model');

    Route::post('/staff/appointment/save', [App\Http\Controllers\Staff\StaffAppointmentDetailController::class, 'save'])->name('staff.save.appointment');

    // staff list
    Route::get('/staff/list', [App\Http\Controllers\StaffController::class, 'list'])->name('staff.list');
    Route::post('/staff/change/status', [App\Http\Controllers\StaffController::class, 'changeStatus'])->name('staff.change.status');
    Route::get('/staff/generate/overview', [App\Http\Controllers\StaffController::class, 'generateOverviewPdf'])->name('staff.generate.overview');

    //Page Permission Start 
    Route::get('/user/permission', [App\Http\Controllers\Permission\PermissionController::class, 'index'])->name('user.permission'); 
    //Page Permission End
    $routeArray = array(
        'institutions' => App\Http\Controllers\Master\InstitutionController::class,
        'class' => App\Http\Controllers\Master\ClassesController::class,
        'division' => App\Http\Controllers\Master\DivisionController::class,
    );
    foreach($routeArray as $key=>$value)
    {
        Route::prefix($key)->group(function() use($key,$value) {
            Route::get('/',[$value,'index'])->name($key);
            Route::post('/edit',[$value,'add_edit'])->name($key.'.add_edit');
            Route::post('/change/status', [$value, 'changeStatus'])->name($key.'.change.status');
            Route::post('/change/delete', [$value, 'delete'])->name($key.'.delete');
            Route::get('/export', [$value, 'export'])->name($key.'.export');
        });

    }

});
