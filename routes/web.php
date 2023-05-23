<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/test-appointment-pdf', [App\Http\Controllers\TestOneController::class, 'testAppointmentPdf']);

Route::get('/delete_preview_pdf', [App\Http\Controllers\TestOneController::class, 'deletePreviewPdf']);
Route::get('/leave-application', [App\Http\Controllers\LeaveFormGeneratorController::class, 'leaveApplication']);
Route::get('/el-application', [App\Http\Controllers\LeaveFormGeneratorController::class, 'earnedLeaveApplication']);
Route::get('/eol-application', [App\Http\Controllers\LeaveFormGeneratorController::class, 'eolApplication']);
Route::get('/ml-application', [App\Http\Controllers\LeaveFormGeneratorController::class, 'maternityLeaveApplication']);
Route::get('/permission-application', [App\Http\Controllers\LeaveFormGeneratorController::class, 'permissionApplication']);

Auth::routes();

Route::group(['middleware' => 'auth'],  function () {

    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::post('/set/academic/year', [App\Http\Controllers\HomeController::class, 'setAcademicYear'])->name('set.academic.year');
    Route::post('/open/modal', [App\Http\Controllers\CommonController::class, 'openAddModal'])->name('modal.open');

    Route::post('/get/institution/staff/code', [App\Http\Controllers\Master\InstitutionController::class, 'getInstituteStaffCode'])->name('institute.staff.code');
    
    Route::post('/get/branch', [App\Http\Controllers\Master\BankBranchController::class, 'getBankBranches'])->name('branch.all');
    Route::post('staff-leave-details', [App\Http\Controllers\AttendanceManagement\AttendanceManualEntryController::class, 'getStaffLeaveDetails'])->name('staff-leave-details');
    Route::post('/get/department', [App\Http\Controllers\Master\DepartmentController::class, 'getDepartment'])->name('get.department');
    Route::post('/list/subject/studied', [App\Http\Controllers\Master\SubjectController::class, 'getSubjectStudied'])->name('get.studied.subject');

    Route::prefix('invigilation')->group(function() {
        Route::post('/save', [App\Http\Controllers\Staff\InvigilationDutyController::class, 'save'])->name('save.invigilation');
        Route::post('/form/content', [App\Http\Controllers\Staff\InvigilationDutyController::class, 'formContent'])->name('form.invigilation.content');
        Route::post('/list', [App\Http\Controllers\Staff\InvigilationDutyController::class, 'getStaffInvigilationList'])->name('staff.invigilation.list');
        Route::post('/delete', [App\Http\Controllers\Staff\InvigilationDutyController::class, 'deleteStaffInvigilation'])->name('staff.invigilation.delete');
    });

    Route::prefix('training')->group(function() {
        Route::post('/save/topic', [App\Http\Controllers\Master\TrainingTopicController::class, 'save'])->name('save.training.topic');
        Route::post('/save/staff', [App\Http\Controllers\Staff\StaffTrainingController::class, 'save'])->name('save.staff.training');
        Route::post('/form/content', [App\Http\Controllers\Staff\StaffTrainingController::class, 'formContent'])->name('form.training.content');
        Route::post('/list', [App\Http\Controllers\Staff\StaffTrainingController::class, 'getStaffTrainingList'])->name('staff.training.list');
        Route::post('/delete', [App\Http\Controllers\Staff\StaffTrainingController::class, 'deleteStaffTraining'])->name('staff.training.delete');
    });

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

    Route::prefix('member')->group(function() {
        Route::post('/list', [App\Http\Controllers\Staff\StaffFamilyMemberController::class, 'list'])->name('staff.member.list');
        Route::post('/save', [App\Http\Controllers\Staff\StaffFamilyMemberController::class, 'save'])->name('staff.member.save');
        Route::post('/form/content', [App\Http\Controllers\Staff\StaffFamilyMemberController::class, 'formContent'])->name('form.family.content');
        Route::post('/delete', [App\Http\Controllers\Staff\StaffFamilyMemberController::class, 'deleteStaffFamilyMember'])->name('staff.family.delete');
    });

    //Bulk upload for staff information staff
    Route::get('/staff/bulk', [App\Http\Controllers\Staff\BulkUploadController::class, 'index'])->name('staff.bulk'); 
    Route::post('/bulk/save', [App\Http\Controllers\Staff\BulkUploadController::class, 'store'])->name('staff.save'); 
    Route::post('/bulk/save/old', [App\Http\Controllers\Staff\BulkUploadController::class, 'oldEntry'])->name('staff.old.save'); 
     //Bulk upload for staff information End
    Route::prefix('staff')->group(function() {

        Route::get('/register/{id?}', [App\Http\Controllers\StaffController::class, 'register'])->name('staff.register');
        Route::get('/view/{user}', [App\Http\Controllers\StaffController::class, 'view'])->name('staff.view');
        Route::post('/add/personal', [App\Http\Controllers\StaffController::class, 'insertPersonalData'])->name('staff.save.personal');
        Route::post('/add/kyc', [App\Http\Controllers\StaffController::class, 'insertKycData'])->name('staff.save.kyc');
        Route::post('/add/position', [App\Http\Controllers\StaffController::class, 'insertEmployeePosition'])->name('staff.save.employee_position');
        Route::post('/add/education', [App\Http\Controllers\StaffController::class, 'insertEducationDetails'])->name('staff.save.education_details');
        Route::post('/get/draftData', [App\Http\Controllers\StaffController::class, 'getStaffDraftData'])->name('staff.get.draft.data');
        Route::post('/add/familyData', [App\Http\Controllers\StaffController::class, 'checkFamilyData'])->name('staff.save.familyPhase');

        Route::prefix('nominee')->group(function() {
            Route::post('/get', [App\Http\Controllers\Staff\StaffNomineeController::class, 'getStaffNominee'])->name('staff.nominee.get');
            Route::post('/info', [App\Http\Controllers\Staff\StaffNomineeController::class, 'getStaffNomineeInfo'])->name('staff.nominee.info');
            Route::post('/save', [App\Http\Controllers\Staff\StaffNomineeController::class, 'save'])->name('staff.nominee.save');
            Route::post('/content/form', [App\Http\Controllers\Staff\StaffNomineeController::class, 'formContent'])->name('staff.nominee.form.content');
            Route::post('/list', [App\Http\Controllers\Staff\StaffNomineeController::class, 'list'])->name('staff.nominee.list');
            Route::post('/delete', [App\Http\Controllers\Staff\StaffNomineeController::class, 'deleteStaffNominee'])->name('staff.nominee.delete');
        });

        Route::prefix('workingrelation')->group(function() {
            Route::post('/save', [App\Http\Controllers\Staff\StaffWorkingRelationController::class, 'save'])->name('staff.save.working_relationship');
            Route::post('/list', [App\Http\Controllers\Staff\StaffWorkingRelationController::class, 'staffWorkingList'])->name('staff.working.relation.list');
            Route::post('/formcontent', [App\Http\Controllers\Staff\StaffWorkingRelationController::class, 'formContent'])->name('staff.working.relation.content');
            Route::post('/delete', [App\Http\Controllers\Staff\StaffWorkingRelationController::class, 'deleteStaffWorkingRelation'])->name('staff.relation.working.delete');
        });

        Route::post('/medical/save', [App\Http\Controllers\Staff\StaffHealthDetailController::class, 'save'])->name('staff.save.medical_information');
        Route::post('/medical/remark/save', [App\Http\Controllers\Staff\StaffMedicalRemarkController::class, 'save'])->name('save.medical.remarks');
        Route::post('/medical/remark/list', [App\Http\Controllers\Staff\StaffMedicalRemarkController::class, 'list'])->name('staff.medic.remarks.list');
        Route::post('/medical/remark/content', [App\Http\Controllers\Staff\StaffMedicalRemarkController::class, 'formContent'])->name('form.medic.remark.content');
        Route::post('/medical/remark/delete', [App\Http\Controllers\Staff\StaffMedicalRemarkController::class, 'deleteStaffMedcialRemarks'])->name('delete.medic.remark');
        
        Route::post('/category/save', [App\Http\Controllers\Master\StaffCategoryController::class, 'save'])->name('save.staff_category');
        Route::post('/nature/save', [App\Http\Controllers\Master\NatureOfEmploymentController::class, 'save'])->name('save.nature_of_employeement');
        Route::post('/teaching_type/save', [App\Http\Controllers\Master\TeachingTypeController::class, 'save'])->name('save.teaching_type');
        Route::post('/workplace/save', [App\Http\Controllers\Master\PlaceOfWorkController::class, 'save'])->name('save.work_place');
        Route::post('/ordermodel/save', [App\Http\Controllers\Master\AppointmentOrderModelController::class, 'save'])->name('save.order_model');
        Route::post('/appointment/save', [App\Http\Controllers\Staff\StaffAppointmentDetailController::class, 'save'])->name('staff.save.appointment');

        Route::post('/appointment/generate/preview', [App\Http\Controllers\Staff\StaffAppointmentDetailController::class, 'generateModelPreview'])->name('staff.appointment.preview');

    });

    Route::post('/blocks/save', [App\Http\Controllers\BlockController::class, 'save'])->name('save.blocks');
    Route::post('/salary-head/save', [App\Http\Controllers\PayrollManagement\SalaryHeadController::class, 'save'])->name('save.salary-head');

    // staff list
    Route::get('/staff/list', [App\Http\Controllers\StaffController::class, 'list'])->name('staff.list');
    Route::post('/staff/change/status', [App\Http\Controllers\StaffController::class, 'changeStatus'])->name('staff.change.status');
    Route::get('/staff/generate/overview', [App\Http\Controllers\StaffController::class, 'generateOverviewPdf'])->name('staff.generate.overview');

    Route::get('/leaves', [App\Http\Controllers\Leave\LeaveController::class, 'index'])->name('leaves.list'); 
    Route::get('/leaves/overview', [App\Http\Controllers\Leave\LeaveController::class, 'overview'])->name('leaves.overview'); 
    Route::post('/leaves/add', [App\Http\Controllers\Leave\LeaveController::class, 'addEditModal'])->name('leaves.add_edit'); 
    Route::post('/leaves/save', [App\Http\Controllers\Leave\LeaveController::class, 'saveLeaveRequest'])->name('save.leaves'); 
    Route::post('/get/staff/info', [App\Http\Controllers\CommonController::class, 'getStaffInfo'])->name('get.staff'); 
    Route::post('/get/staff/leaveinfo', [App\Http\Controllers\CommonController::class, 'getStaffLeaveInfo'])->name('get.staff.leave.info'); 
    Route::post('/get/leave/form', [App\Http\Controllers\CommonController::class, 'getLeaveForm'])->name('get.leave.form'); 

    Route::get('/reporting', [App\Http\Controllers\ReportingController::class, 'index'])->name('reporting.list'); 
    Route::post('/reporting/assign/toplevel', [App\Http\Controllers\ReportingController::class, 'openTopLevelManagerModal'])->name('reporting.assign.form'); 
    Route::post('/reporting/assign', [App\Http\Controllers\ReportingController::class, 'assignTopLevelManager'])->name('reporting.toplevel.assign'); 
    Route::post('/reporting/manager/modal', [App\Http\Controllers\ReportingController::class, 'openManagerModal'])->name('reporting.manager.modal'); 
    Route::post('/reporting/manager/assign', [App\Http\Controllers\ReportingController::class, 'assignManager'])->name('reporting.manager.assign'); 
    Route::post('/reporting/manager/change/modal', [App\Http\Controllers\ReportingController::class, 'openChangeManagerModal'])->name('reporting.manager.change.modal'); 
    
    //Document Locker Start    
    Route::get('/user/document_locker', [App\Http\Controllers\DocumentLocker\DocumentLockerController::class, 'index'])->name('user.document_locker'); 
    Route::get('autocomplete-search', [App\Http\Controllers\DocumentLocker\DocumentLockerController::class, 'autocompleteSearch'])->name('autocomplete-search'); 
    Route::get('/dl_view/{id?}', [App\Http\Controllers\DocumentLocker\DocumentLockerController::class, 'documentView'])->name('user.dl_view');
    Route::post('/document_status', [App\Http\Controllers\DocumentLocker\DocumentLockerController::class, 'changeDocumentStaus'])->name('document_status'); 
    //Document Locker End
    $routeArray = array(
        'institutions' => App\Http\Controllers\Master\InstitutionController::class,
        'class' => App\Http\Controllers\Master\ClassesController::class,
        'division' => App\Http\Controllers\Master\DivisionController::class, 
        'language' => App\Http\Controllers\Master\LanguageController::class,
        'place' => App\Http\Controllers\Master\PlaceController::class,
        'nationality' => App\Http\Controllers\Master\NationalityController::class,
        'religion' => App\Http\Controllers\Master\ReligionController::class,
        'caste' => App\Http\Controllers\Master\CasteController::class,
        'role' => App\Http\Controllers\Role\RoleController::class,
        'role-mapping' => App\Http\Controllers\Role\RoleMappingController::class,
        'community' => App\Http\Controllers\Master\CommunityController::class,
        'bank' => App\Http\Controllers\Master\BankController::class,
        'bank-branch' => App\Http\Controllers\Master\BankBranchController::class,
        'designation' => App\Http\Controllers\Master\DesignationController::class,
        'department' => App\Http\Controllers\Master\DepartmentController::class,
        'subject' => App\Http\Controllers\Master\SubjectController::class,
        'scheme' => App\Http\Controllers\Master\AttendanceSchemeController::class,
        'duty-class' => App\Http\Controllers\Master\DutyClassController::class,
        'duty-type' => App\Http\Controllers\Master\DutyTypeController::class,
        'other-school' => App\Http\Controllers\Master\OtherSchoolController::class,
        'training-topic' => App\Http\Controllers\Master\TrainingTopicController::class,
        'board' => App\Http\Controllers\Master\BoardController::class,        
        'blood_group' => App\Http\Controllers\Master\BloodGroupController::class,
        'document_type' => App\Http\Controllers\Master\DocumentTypeController::class,
        'professional_type' => App\Http\Controllers\Master\ProfessionTypeController::class,
        'nature-of-employeement' => App\Http\Controllers\Master\NatureOfEmploymentController::class,
        'workplace' => App\Http\Controllers\Master\PlaceOfWorkController::class,
        'qualification' => App\Http\Controllers\Master\QualificationController::class,
        'relationship' => App\Http\Controllers\Master\RelationshipTypeController::class,
        'staff-category' => App\Http\Controllers\Master\StaffCategoryController::class,
        'teaching-type' => App\Http\Controllers\Master\TeachingTypeController::class,
        'overview' => App\Http\Controllers\OverViewController::class,
        'block-classes' => App\Http\Controllers\BlockClassesController::class,
        'blocks' => App\Http\Controllers\BlockController::class,
        'leave-status' => App\Http\Controllers\AttendanceManagement\LeaveStatusController::class,
        'leave-head' => App\Http\Controllers\AttendanceManagement\LeaveHeadController::class,
        'holiday' => App\Http\Controllers\AttendanceManagement\HolidayController::class,
        'salary-head' => App\Http\Controllers\PayrollManagement\SalaryHeadController::class,
        'salary-field' => App\Http\Controllers\PayrollManagement\SalaryFieldController::class,
        'leave-mapping' => App\Http\Controllers\AttendanceManagement\LeaveMappingController::class,
        'att-manual-entry' => App\Http\Controllers\AttendanceManagement\AttendanceManualEntryController::class,        
    );
    foreach($routeArray as $key=>$value)
    {
        Route::prefix($key)->group(function() use($key,$value) {
            Route::get('/',[$value,'index'])->name($key)->middleware(['checkAccess:view']);
            Route::post('/edit',[$value,'add_edit'])->name($key.'.add_edit')->middleware(['checkAccess:add_edit']);
            Route::post('/change/status', [$value, 'changeStatus'])->name($key.'.change.status');
            Route::post('/change/delete', [$value, 'delete'])->name($key.'.delete')->middleware(['checkAccess:delete']);
            Route::get('/export', [$value, 'export'])->name($key.'.export')->middleware(['checkAccess:export']);
            Route::post('/save', [$value, 'save'])->name('save.'.$key);
        });

    }
    /**
     * ajax form data reload
     */
    Route::post('get/nationlity/list', [App\Http\Controllers\Master\NationalityController::class, 'getAjaxList'])->name('nationality.ajax.list');

    Route::post('get/head/fields', [App\Http\Controllers\PayrollManagement\SalaryFieldController::class, 'getHeadBasedFields'])->name('salary-field.head.fields');

    Route::get('appointment-order', [App\Http\Controllers\Master\AppointmentOrderModelController::class, 'index'])->name('appointment.orders');
    Route::get('appointment-order/add/{id?}', [App\Http\Controllers\Master\AppointmentOrderModelController::class, 'add_edit'])->name('appointment.orders.add');
    Route::post('appointment-order/save', [App\Http\Controllers\Master\AppointmentOrderModelController::class, 'save'])->name('appointment.orders.save');

    //permission routes start
    Route::get('/user/permission', [App\Http\Controllers\Permission\PermissionController::class, 'index'])->name('user.permission')->middleware(['checkAccess:view']); 
    Route::post('permission/save', [App\Http\Controllers\Permission\PermissionController::class, 'store'])->name('permission.save'); 
    Route::post('permission/menu-list', [App\Http\Controllers\Permission\PermissionController::class, 'menuList'])->name('permission.menu-list'); 
    Route::post('permission/check', [App\Http\Controllers\Permission\PermissionController::class, 'checkPermission'])->name('permission.check'); 

    //permission routes end 

   
    Route::post('overview',[App\Http\Controllers\OverViewController::class,'saveForm'])->name('overview.save');
    Route::prefix('logs')->group(function() {
        Route::get('/',[App\Http\Controllers\LogController::class,'index'])->name('logs');
        Route::post('/view',[App\Http\Controllers\LogController::class,'view'])->name('logs.view');
    });

    Route::get('salary/revision',[App\Http\Controllers\PayrollManagement\SalaryRevisionController::class,'index'])->name('salary.revision');
    Route::get('salary/creation',[App\Http\Controllers\PayrollManagement\SalaryCreationController::class,'index'])->name('salary.creation');

    Route::get('salary/loan',[App\Http\Controllers\PayrollManagement\BankLoanController::class,'index'])->name('salary.loan');
    Route::post('salary/save/loan',[App\Http\Controllers\PayrollManagement\BankLoanController::class,'save'])->name('save.loan');
    Route::post('salary/get/form/loan',[App\Http\Controllers\PayrollManagement\BankLoanController::class,'getFormAndList'])->name('ajax-view.loan');
    Route::post('salary/edit/form/loan',[App\Http\Controllers\PayrollManagement\BankLoanController::class,'editLoanForm'])->name('edit.loan');
    Route::post('salary/delete/loan',[App\Http\Controllers\PayrollManagement\BankLoanController::class,'deleteLoan'])->name('delete.loan');

    Route::get('salary/lic',[App\Http\Controllers\PayrollManagement\BankLoanController::class,'insurance'])->name('salary.lic');
    Route::post('salary/save/lic',[App\Http\Controllers\PayrollManagement\BankLoanController::class,'saveInsurance'])->name('save.lic');
    Route::post('salary/get/form/lic',[App\Http\Controllers\PayrollManagement\BankLoanController::class,'getFormAndListInsurance'])->name('ajax-view.lic');
    Route::post('salary/edit/form/lic',[App\Http\Controllers\PayrollManagement\BankLoanController::class,'editLicForm'])->name('edit.lic');
    Route::post('salary/delete/lic',[App\Http\Controllers\PayrollManagement\BankLoanController::class,'deleteLic'])->name('delete.lic');

    Route::get('professional/tax',[App\Http\Controllers\PayrollManagement\ProfessionTaxController::class,'index'])->name('professional-tax');
    Route::post('professional/tax/save',[App\Http\Controllers\PayrollManagement\ProfessionTaxController::class,'save'])->name('save.professional-tax');


    include 'crud.php';
    
});