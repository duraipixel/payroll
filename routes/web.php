<?php
include('reports.php');

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/test-appointment-pdf', [App\Http\Controllers\TestOneController::class, 'testAppointmentPdf']);
Route::get('/test-salary-pdf', [App\Http\Controllers\TestOneController::class, 'testSalaryPdf']);
Route::get('/test-assign-orderno', [App\Http\Controllers\TestOneController::class, 'assignAppointmentOrder']);
Route::get('/sample-it-statement', [App\Http\Controllers\TestOneController::class, 'sampleITStatement']);

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
    Route::post('/get/dashboard/view', [App\Http\Controllers\HomeController::class, 'getDashboardView'])->name('get.dashboard.view');
    Route::post('/set/institution', [App\Http\Controllers\HomeController::class, 'setInstitution'])->name('set.institution');
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
        Route::get('/print/{user}', [App\Http\Controllers\StaffController::class, 'print'])->name('staff.print');
        Route::post('/add/personal', [App\Http\Controllers\StaffController::class, 'insertPersonalData'])->name('staff.save.personal');
        Route::post('/add/kyc', [App\Http\Controllers\StaffController::class, 'insertKycData'])->name('staff.save.kyc');
        Route::post('/add/position', [App\Http\Controllers\StaffController::class, 'insertEmployeePosition'])->name('staff.save.employee_position');
        Route::post('/add/education', [App\Http\Controllers\StaffController::class, 'insertEducationDetails'])->name('staff.save.education_details');
        Route::post('/get/draftData', [App\Http\Controllers\StaffController::class, 'getStaffDraftData'])->name('staff.get.draft.data');
        Route::post('/add/familyData', [App\Http\Controllers\StaffController::class, 'checkFamilyData'])->name('staff.save.familyPhase');
        Route::post('/get/staff/handling', [App\Http\Controllers\StaffController::class, 'getStaffHandlingDetails'])->name('get.staff.handling.details');

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
        Route::post('/appointment/delete', [App\Http\Controllers\Staff\StaffAppointmentDetailController::class, 'delete'])->name('staff.delete.appointment');
        Route::post('/appointment/update', [App\Http\Controllers\Staff\StaffAppointmentDetailController::class, 'updateAppointmentModal'])->name('staff.add_edit.appointment');
        Route::post('/appointment/update/do', [App\Http\Controllers\Staff\StaffAppointmentDetailController::class, 'doUpdateAppointmentModal'])->name('staff.update.appointment');

        Route::post('/appointment/generate/preview', [App\Http\Controllers\Staff\StaffAppointmentDetailController::class, 'generateModelPreview'])->name('staff.appointment.preview');
        Route::post('/appointment/list', [App\Http\Controllers\Staff\StaffAppointmentDetailController::class, 'list'])->name('staff.appointment.list');
        Route::post('/staff/verify', [App\Http\Controllers\Staff\StaffAppointmentDetailController::class, 'verifyStaff'])->name('staff.verify');

    });

    Route::post('/blocks/save', [App\Http\Controllers\BlockController::class, 'save'])->name('save.blocks');
    Route::post('/salary-head/save', [App\Http\Controllers\PayrollManagement\SalaryHeadController::class, 'save'])->name('save.salary-head');

    // staff list
    Route::get('/staff/list', [App\Http\Controllers\StaffController::class, 'list'])->name('staff.list');
    Route::post('/staff/change/status', [App\Http\Controllers\StaffController::class, 'changeStatus'])->name('staff.change.status');
    Route::post('/staff/delete', [App\Http\Controllers\StaffController::class, 'deleteStaff'])->name('staff.delete');
    Route::get('/staff/generate/overview', [App\Http\Controllers\StaffController::class, 'generateOverviewPdf'])->name('staff.generate.overview');
    Route::post('/staff/generate/employee_code', [App\Http\Controllers\StaffController::class, 'generateEmployeeCode'])->name('staff.generate.code');

    Route::get('/leaves', [App\Http\Controllers\Leave\LeaveController::class, 'index'])->name('leaves.list')->middleware(['checkAccess:view']); 
    Route::get('/leaves/overview', [App\Http\Controllers\Leave\LeaveController::class, 'overview'])->name('leaves.overview')->middleware(['checkAccess:view']); 
    Route::post('/leaves/staff/info', [App\Http\Controllers\Leave\LeaveController::class, 'getStaffLeaveInfo'])->name('leaves.staff.info'); 
    Route::get('/working/days', [App\Http\Controllers\Leave\LeaveController::class, 'setWorkingDays'])->name('leaves.set.workingday'); 
    Route::post('/leaves/add', [App\Http\Controllers\Leave\LeaveController::class, 'addEditModal'])->name('leaves.add_edit'); 
    Route::post('/leaves/save', [App\Http\Controllers\Leave\LeaveController::class, 'saveLeaveRequest'])->name('save.leaves'); 
    Route::post('/leaves/delete', [App\Http\Controllers\Leave\LeaveController::class, 'deleteLeave'])->name('delete.leaves'); 
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
    Route::get('/user/document-locker', [App\Http\Controllers\DocumentLocker\DocumentLockerController::class, 'index'])->name('user.document_locker')->middleware(['checkAccess:view']); 
    Route::get('/user/document-locker/show/{id}', [App\Http\Controllers\DocumentLocker\DocumentLockerController::class, 'documentView'])->name('user.dl_view');
    Route::post('/user/search-staff', [App\Http\Controllers\DocumentLocker\DocumentLockerController::class, 'searchData'])->name('user.search_staff'); 
    Route::post('/user/show-options', [App\Http\Controllers\DocumentLocker\DocumentLockerController::class, 'showOptions'])->name('user.show_options'); 
    Route::get('autocomplete-search', [App\Http\Controllers\DocumentLocker\DocumentLockerController::class, 'autocompleteSearch'])->name('autocomplete-search'); 
    Route::post('/document-status', [App\Http\Controllers\DocumentLocker\DocumentLockerController::class, 'changeDocumentStaus'])->name('document_status'); 

    //Document Locker End
    Route::post('/scheme_view', [App\Http\Controllers\Master\AttendanceSchemeController::class, 'schemeView'])->name('scheme.view');
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
        'announcement' => App\Http\Controllers\Announcement\AnnouncementController::class,        
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
    Route::post('appointment-order/view', [App\Http\Controllers\Master\AppointmentOrderModelController::class, 'appointmentOrderView'])->name('appointment.orders.view');
    
    Route::get('scheme/add/{id?}', [App\Http\Controllers\Master\AttendanceSchemeController::class, 'add_edit'])->name('attendance.scheme.add');
    //staff transfer
    Route::get('/staff/transfer', [App\Http\Controllers\Staff\StaffTransferController::class, 'index'])->name('staff.transfer')->middleware(['checkAccess:view']); 
    Route::get('/staff/transfer/add', [App\Http\Controllers\Staff\StaffTransferController::class, 'add'])->name('staff.transfer.add')->middleware(['checkAccess:view']); 
    Route::any('/staff/get/institution', [App\Http\Controllers\Staff\StaffTransferController::class, 'getInstitutionStaff'])->name('get.institute.staff')->middleware(['checkAccess:view']); 
    Route::post('/staff/transfer/do', [App\Http\Controllers\Staff\StaffTransferController::class, 'doTransferStaff'])->name('staff.transfer.do')->middleware(['checkAccess:view']); 
    Route::post('/staff/transfer/modal', [App\Http\Controllers\Staff\StaffTransferController::class, 'openTransferStatusModal'])->name('staff.transfer.modal')->middleware(['checkAccess:view']); 
    Route::post('/staff/transfer/status/change', [App\Http\Controllers\Staff\StaffTransferController::class, 'changeStatus'])->name('staff.transfer.status')->middleware(['checkAccess:view']); 

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
    // Settings Start
    Route::get('account/settings',[App\Http\Controllers\Account\SettingsController::class,'index'])->name('account.settings');
    #Attendance 
    Route::get('attendance/overview',[App\Http\Controllers\AttendanceManagement\OverviewController::class,'index'])->name('attendance.overview');

    Route::any('attendance/ajax/view', [App\Http\Controllers\AttendanceManagement\AttendanceManualEntryController::class, 'ajax_view'])->name('attendance.ajax.view');
    Route::any('attendance/ajax/datatable', [App\Http\Controllers\AttendanceManagement\AttendanceManualEntryController::class, 'ajaxDatatable'])->name('attendance.ajax.datatable');

    Route::get('payroll/overview',[App\Http\Controllers\PayrollManagement\OverviewController::class,'index'])->name('payroll.overview');
    Route::post('payroll/overview/month',[App\Http\Controllers\PayrollManagement\OverviewController::class,'getMonthData'])->name('payroll.get.month.chart');
    Route::post('payroll/set/permission',[App\Http\Controllers\PayrollManagement\OverviewController::class,'setPermission'])->name('payroll.set.permission');
    Route::post('payroll/permission/modal',[App\Http\Controllers\PayrollManagement\OverviewController::class,'openPermissionModal'])->name('payroll.open.permission');
    Route::post('payroll/create',[App\Http\Controllers\PayrollManagement\OverviewController::class,'createPayroll'])->name('payroll.create');
    Route::post('payroll/process/modal',[App\Http\Controllers\PayrollManagement\OverviewController::class,'processPayrollModal'])->name('payroll.process.modal');
    Route::post('payroll/processing',[App\Http\Controllers\PayrollManagement\OverviewController::class,'setPayrollProcessing'])->name('payroll.set.processing');
    Route::post('payroll/processing/continue',[App\Http\Controllers\PayrollManagement\OverviewController::class,'continuePayrollProcessing'])->name('payroll.continue.processing');
    Route::post('payroll/completed',[App\Http\Controllers\PayrollManagement\OverviewController::class,'doPayrollProcessing'])->name('payroll.do.processing');
    Route::get('payroll/statement/{id}',[App\Http\Controllers\PayrollManagement\OverviewController::class,'payrollStatement'])->name('payroll.statement');
    Route::post('payroll/statement/list',[App\Http\Controllers\PayrollManagement\OverviewController::class,'payrollStatementList'])->name('payroll.statement.list');
    Route::get('payroll/statement/export/{payroll_id}/{staff_id?}',[App\Http\Controllers\PayrollManagement\OverviewController::class,'exportStatement'])->name('payroll.statement.export');

    Route::get('payroll/list',[App\Http\Controllers\PayrollManagement\PayrollController::class,'index'])->name('payroll.list');
    Route::post('payroll/processed/list',[App\Http\Controllers\PayrollManagement\PayrollController::class,'processedList'])->name('payroll.processed.list');
    Route::post('payroll/ajax/list',[App\Http\Controllers\PayrollManagement\PayrollController::class,'getAjaxProcessedList'])->name('payroll.ajax.list');

    #salary revision approval
    Route::get('salary/revision',[App\Http\Controllers\PayrollManagement\SalaryRevisionController::class,'index'])->name('salary.revision');
    Route::post('salary/revision/status/change/modal',[App\Http\Controllers\PayrollManagement\SalaryRevisionController::class,'changeStatusModal'])->name('salary.revision.status.modal');
    Route::post('salary/revision/status/change',[App\Http\Controllers\PayrollManagement\SalaryRevisionController::class,'changeStatus'])->name('salary.revision.status.change');
    #Other Income Section
    Route::get('other-income',[App\Http\Controllers\PayrollManagement\OtherIncomeController::class,'index'])->name('other-income');
    Route::post('other-income/add',[App\Http\Controllers\PayrollManagement\OtherIncomeController::class,'add_edit'])->name('other-income.add_edit');
    Route::post('other-income/save',[App\Http\Controllers\PayrollManagement\OtherIncomeController::class,'save'])->name('other-income.save');
    Route::post('other-income/status/change',[App\Http\Controllers\PayrollManagement\OtherIncomeController::class,'changeStatus'])->name('other-income.change.status');
    Route::post('other-income/delete',[App\Http\Controllers\PayrollManagement\OtherIncomeController::class,'delete'])->name('other-income.delete');
    Route::get('other-income/export',[App\Http\Controllers\PayrollManagement\OtherIncomeController::class,'export'])->name('other-income.export');
    #Income Tax Calculations
    Route::get('it/tabulation',[App\Http\Controllers\PayrollManagement\ItTabulationController::class,'index'])->name('it.tabulation');
    Route::post('it/tabulation/add_edit',[App\Http\Controllers\PayrollManagement\ItTabulationController::class,'addEditModal'])->name('it.tabulation.modal');
    Route::post('it/tabulation/save',[App\Http\Controllers\PayrollManagement\ItTabulationController::class,'save'])->name('it.tabulation.save');
    Route::post('it/tabulation/change/status',[App\Http\Controllers\PayrollManagement\ItTabulationController::class,'changeStatus'])->name('it.tabulation.status.change');
    #Tax Schemes
    Route::get('taxscheme',[App\Http\Controllers\Tax\TaxSchemeController::class,'index'])->name('taxscheme');
    Route::post('taxscheme/add',[App\Http\Controllers\Tax\TaxSchemeController::class,'add_edit'])->name('taxscheme.add_edit');
    Route::post('taxscheme/save',[App\Http\Controllers\Tax\TaxSchemeController::class,'save'])->name('taxscheme.save');
    Route::post('taxscheme/status/change',[App\Http\Controllers\Tax\TaxSchemeController::class,'changeStatus'])->name('taxscheme.change.status');
    Route::post('taxscheme/delete',[App\Http\Controllers\Tax\TaxSchemeController::class,'delete'])->name('taxscheme.delete');
    Route::get('taxscheme/export',[App\Http\Controllers\Tax\TaxSchemeController::class,'export'])->name('taxscheme.export');
    Route::post('taxscheme/set/current',[App\Http\Controllers\Tax\TaxSchemeController::class,'setCurrent'])->name('taxscheme.set.current');
    #Tax Scheme Section
    Route::get('taxsection',[App\Http\Controllers\Tax\TaxSchemeSectionController::class,'index'])->name('taxsection');
    Route::post('taxsection/add',[App\Http\Controllers\Tax\TaxSchemeSectionController::class,'add_edit'])->name('taxsection.add_edit');
    Route::post('taxsection/save',[App\Http\Controllers\Tax\TaxSchemeSectionController::class,'save'])->name('taxsection.save');
    Route::post('taxsection/status/change',[App\Http\Controllers\Tax\TaxSchemeSectionController::class,'changeStatus'])->name('taxsection.change.status');
    Route::post('taxsection/delete',[App\Http\Controllers\Tax\TaxSchemeSectionController::class,'delete'])->name('taxsection.delete');
    Route::get('taxsection/export',[App\Http\Controllers\Tax\TaxSchemeSectionController::class,'export'])->name('taxsection.export');
    #Tax Scheme Section Items
    Route::get('taxsection-item',[App\Http\Controllers\Tax\TaxSchemeSectionItemController::class,'index'])->name('taxsection-item');
    Route::post('taxsection-itemadd',[App\Http\Controllers\Tax\TaxSchemeSectionItemController::class,'add_edit'])->name('taxsection-item.add_edit');
    Route::post('taxsection-itemsave',[App\Http\Controllers\Tax\TaxSchemeSectionItemController::class,'save'])->name('taxsection-item.save');
    Route::post('taxsection-itemstatus/change',[App\Http\Controllers\Tax\TaxSchemeSectionItemController::class,'changeStatus'])->name('taxsection-item.change.status');
    Route::post('taxsection-itemdelete',[App\Http\Controllers\Tax\TaxSchemeSectionItemController::class,'delete'])->name('taxsection-item.delete');
    Route::get('taxsection-itemexport',[App\Http\Controllers\Tax\TaxSchemeSectionItemController::class,'export'])->name('taxsection-item.export');
    #income tax
    Route::get('it',[App\Http\Controllers\PayrollManagement\IncomeTaxController::class,'index'])->name('it');
    Route::post('it/tab',[App\Http\Controllers\PayrollManagement\IncomeTaxController::class,'getTab'])->name('it.tab');
    Route::post('it/deduction/row',[App\Http\Controllers\PayrollManagement\IncomeTaxController::class,'getDeductionRow'])->name('it.deduction.row');
    Route::post('it/deduction/save',[App\Http\Controllers\PayrollManagement\IncomeTaxController::class,'saveDeduction'])->name('it.deduction.save');
    Route::post('it/other/income/row',[App\Http\Controllers\PayrollManagement\IncomeTaxController::class,'getOtherIncomeRow'])->name('it.other.income.row');
    Route::post('it/other/income/save',[App\Http\Controllers\PayrollManagement\IncomeTaxController::class,'saveOtherIncome'])->name('it.other.income.save');
    Route::post('it/rent/add',[App\Http\Controllers\PayrollManagement\IncomeTaxController::class,'rentModal'])->name('it.rent.add');
    Route::post('it/rent/save',[App\Http\Controllers\PayrollManagement\IncomeTaxController::class,'saveRent'])->name('staff.rent.save');
    Route::post('it/rent/list',[App\Http\Controllers\PayrollManagement\IncomeTaxController::class,'rentList'])->name('it.rent.list');
    Route::post('it/rent/delete',[App\Http\Controllers\PayrollManagement\IncomeTaxController::class,'rentDelete'])->name('it.rent.delete');
    Route::post('it/tax/add',[App\Http\Controllers\PayrollManagement\IncomeTaxController::class,'addTax'])->name('it.tax.add');

    #income tax calculation
    Route::get('it-calculation',[App\Http\Controllers\PayrollManagement\IncomeTaxCalculationController::class,'index'])->name('it-calculation');
    Route::get('it-calculation/generate/pdf',[App\Http\Controllers\PayrollManagement\IncomeTaxCalculationController::class,'generatePdf'])->name('it-calculation.generate.pdf');
    Route::post('it-calculation/get/calculation/form',[App\Http\Controllers\PayrollManagement\IncomeTaxCalculationController::class,'getCalculationForm'])->name('it-calculation.calculation.form');
    Route::post('it-calculation/get/tax/calculation',[App\Http\Controllers\PayrollManagement\IncomeTaxCalculationController::class,'ajaxTaxCalculation'])->name('it-calculation.calculation.ajax');
    Route::post('it-calculation/save/statement',[App\Http\Controllers\PayrollManagement\IncomeTaxCalculationController::class,'saveItStatement'])->name('it-calculation.save.statement');
    Route::post('it-calculation/generate/newstatement',[App\Http\Controllers\PayrollManagement\IncomeTaxCalculationController::class,'generateNewStatement'])->name('it-calculation.generate.statement');
    Route::post('it-calculation/generate/statement/all',[App\Http\Controllers\PayrollManagement\IncomeTaxCalculationController::class,'generateAllStatement'])->name('it-calculation.generate.all');
    Route::post('it-calculation/list',[App\Http\Controllers\PayrollManagement\IncomeTaxCalculationController::class,'list'])->name('it-calculation.list');

    ## salary creation & update & revison
    Route::get('salary/creation/{staff_id?}',[App\Http\Controllers\PayrollManagement\SalaryCreationController::class,'index'])->name('salary.creation');
    Route::post('salary/creation_add',[App\Http\Controllers\PayrollManagement\SalaryCreationController::class,'salaryAdd'])->name('salary.creation_add');
    Route::post('salary/update/pattern',[App\Http\Controllers\PayrollManagement\SalaryCreationController::class,'updateSalaryPattern'])->name('salary.update.pattern');
    Route::post('salary/delete/pattern',[App\Http\Controllers\PayrollManagement\SalaryCreationController::class,'deleteSalaryPattern'])->name('salary.delete.pattern');
    Route::post('salary/update/month/pattern',[App\Http\Controllers\PayrollManagement\SalaryCreationController::class,'updateCurrentSalaryPattern'])->name('salary.update.current.pattern');
    Route::post('salary/get/staff',[App\Http\Controllers\PayrollManagement\SalaryCreationController::class,'getStaffSalaryInfo'])->name('salary.get.staff');
    Route::post('salary/get/epf/amount',[App\Http\Controllers\PayrollManagement\SalaryCreationController::class,'getStaffEpfAmount'])->name('salary.get.epf.amount');
    Route::post('salary/pattern/list',[App\Http\Controllers\PayrollManagement\SalaryCreationController::class,'getStaffSalaryPattern'])->name('salary.pattern.list');
    Route::post('salary/get/field/amount',[App\Http\Controllers\PayrollManagement\SalaryCreationController::class,'getAmountBasedField'])->name('salary.get.field.amount');
    Route::post('salary/get/view',[App\Http\Controllers\PayrollManagement\SalaryCreationController::class,'salaryModalView'])->name('salary.modal.view');
    Route::get('salary/download/preview/{staff_id}',[App\Http\Controllers\PayrollManagement\SalaryCreationController::class,'downloadSalaryPreviewPdf'])->name('salary.preview.pdf');
    Route::post('salary/get/others/info',[App\Http\Controllers\PayrollManagement\SalaryCreationController::class,'getOthersData'])->name('show.loans.info');
    Route::post('salary/pattern/delete',[App\Http\Controllers\PayrollManagement\SalaryCreationController::class,'deleteSalaryPattern'])->name('salary.pattern.delete');
    
    Route::get('salary/loan',[App\Http\Controllers\PayrollManagement\BankLoanController::class,'index'])->name('salary.loan');
    Route::post('salary/save/loan',[App\Http\Controllers\PayrollManagement\BankLoanController::class,'save'])->name('save.loan');
    Route::post('salary/get/form/loan',[App\Http\Controllers\PayrollManagement\BankLoanController::class,'getFormAndList'])->name('ajax-view.loan');
    Route::post('salary/edit/form/loan',[App\Http\Controllers\PayrollManagement\BankLoanController::class,'editLoanForm'])->name('edit.loan');
    Route::post('salary/delete/loan',[App\Http\Controllers\PayrollManagement\BankLoanController::class,'deleteLoan'])->name('delete.loan');
    Route::post('salary/get/emi/details',[App\Http\Controllers\PayrollManagement\BankLoanController::class,'getEmiDetails'])->name('emi.loan');

    Route::get('salary/lic',[App\Http\Controllers\PayrollManagement\BankLoanController::class,'insurance'])->name('salary.lic');
    Route::post('salary/save/lic',[App\Http\Controllers\PayrollManagement\BankLoanController::class,'saveInsurance'])->name('save.lic');
    Route::post('salary/get/form/lic',[App\Http\Controllers\PayrollManagement\BankLoanController::class,'getFormAndListInsurance'])->name('ajax-view.lic');
    Route::post('salary/edit/form/lic',[App\Http\Controllers\PayrollManagement\BankLoanController::class,'editLicForm'])->name('edit.lic');
    Route::post('salary/delete/lic',[App\Http\Controllers\PayrollManagement\BankLoanController::class,'deleteLic'])->name('delete.lic');
    Route::post('salary/lic/emi/details',[App\Http\Controllers\PayrollManagement\BankLoanController::class,'getInsuranceEmiDetails'])->name('emi.lic');

    Route::get('professional/tax',[App\Http\Controllers\PayrollManagement\ProfessionTaxController::class,'index'])->name('professional-tax');
    Route::post('professional/tax/save',[App\Http\Controllers\PayrollManagement\ProfessionTaxController::class,'save'])->name('save.professional-tax');
    /**
     * Hold salary routes
     */
    Route::get('holdsalary',[App\Http\Controllers\PayrollManagement\HoldSalaryController::class,'index'])->name('holdsalary');
    Route::post('holdsalary/add',[App\Http\Controllers\PayrollManagement\HoldSalaryController::class,'addEdit'])->name('holdsalary.add_edit');
    Route::post('holdsalary/save',[App\Http\Controllers\PayrollManagement\HoldSalaryController::class,'save'])->name('holdsalary.save');
    Route::any('holdsalary/view',[App\Http\Controllers\PayrollManagement\HoldSalaryController::class,'view'])->name('holdsalary.view');
    Route::post('holdsalary/delete',[App\Http\Controllers\PayrollManagement\HoldSalaryController::class,'delete'])->name('holdsalary.delete');
    /**
     *  Set working day calendar 
     */
    Route::post('/calendar/event/add', [App\Http\Controllers\AttendanceManagement\CalendarController::class, 'setEvent'])->name('calender.event.add'); 
    Route::any('/calendar/event/get', [App\Http\Controllers\AttendanceManagement\CalendarController::class, 'getEvent'])->name('calender.event.get'); 
    Route::post('/calendar/get/days', [App\Http\Controllers\AttendanceManagement\CalendarController::class, 'getDaysCount'])->name('calender.get.count'); 

    include 'crud.php';
    
});

// Route::fallback(function () {   // if you want to override 404 page you can use
//     echo 'tsing';
// });