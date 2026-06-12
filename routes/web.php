<?php


use App\Http\Controllers\backend\AcademicSessionController;
use App\Http\Controllers\backend\AttendanceController;
use App\Http\Controllers\backend\ClasseController;
use App\Http\Controllers\backend\ExamController;
use App\Http\Controllers\backend\FeeController;
use App\Http\Controllers\backend\FeePaymentController;
use App\Http\Controllers\backend\PromotionController;
use App\Http\Controllers\backend\ResultController;
use App\Http\Controllers\backend\RollAssignmentController;
use App\Http\Controllers\backend\SectionController;
use App\Http\Controllers\backend\StudentController;
use App\Http\Controllers\backend\StudentSessionController;
use App\Http\Controllers\backend\SubjectController;
use App\Http\Controllers\backend\TeacherAssignmentController;
use App\Http\Controllers\backend\TeacherController;
use App\Http\Controllers\rolepermission\PermissionController;
use App\Http\Controllers\rolepermission\RoleController;
use App\Http\Controllers\rolepermission\UserRoleController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



Auth::routes();

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


/*
|--------------------------------------------------------------------------
| AUTH MIDDLEWARE GROUP
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | ACADEMIC SETUP (ADMIN ONLY)
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:admin'])->group(function () {
        //Assign Role to User's
        Route::get('/users/roles', [UserRoleController::class, 'index'])->name('users.roles.index');
        Route::post('/users/roles/update/{id}', [UserRoleController::class, 'update'])->name('users.roles.update');
        //Assign permission to Role
        Route::get('roles/{role}/permissions', [RoleController::class, 'editPermissions'])->name('roles.permissions.edit');
        Route::post('roles/{role}/permissions', [RoleController::class, 'updatePermissions'])->name('roles.permissions.update');

        Route::resource('roles', RoleController::class);
        Route::resource('permissions', PermissionController::class);

        //academic Session
        Route::resource('AcademicSessions',AcademicSessionController::class);
        Route::put('AcademicSessions/{id}/active',[AcademicSessionController::class, 'active'])->name('AcademicSessions.active');






    });
    Route::middleware(['role:admin|teacher'])->group(function () {
    });
    /*
    |--------------------------------------------------------------------------
    | STUDENT MANAGEMENT (ADMIN + TEACHER)
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:admin|teacher|student'])->group(function () {
    });


    Route::middleware(['permission:Add student'])->group(function () {
        Route::get('/add-student', [\App\Http\Controllers\backend\StudentController::class, 'create'])->name('student.create');
        Route::post('/store-student', [\App\Http\Controllers\backend\StudentController::class, 'store'])->name('student.store');
    });


    Route::middleware(['permission:Manage students'])->group(function () {
        //Students
        Route::get('/All-student', [\App\Http\Controllers\backend\StudentController::class, 'index'])->name('student.index');
        Route::get('/edit-student/{id}', [\App\Http\Controllers\backend\StudentController::class, 'edit'])->name('student.edit');
        Route::post('/update-student/{id}', [\App\Http\Controllers\backend\StudentController::class, 'update'])->name('student.update');
        Route::delete('/delete-student/{id}', [\App\Http\Controllers\backend\StudentController::class, 'destroy'])->name('student.destroy');
        Route::get('/get-sections/{class_id}', [\App\Http\Controllers\backend\StudentController::class, 'getSections']);

        //Students Session
        Route::resource('StudentSessions',StudentSessionController::class);
    });


    Route::middleware(['permission:Add teacher'])->group(function () {
        Route::get('/add-teacher', [\App\Http\Controllers\backend\TeacherController::class, 'create'])->name('teacher.create');
        Route::post('/store-teacher', [\App\Http\Controllers\backend\TeacherController::class, 'store'])->name('teacher.store');
    });

    Route::middleware(['permission:Manage teacher'])->group(function () {
        // Teachers
        Route::get('/All-teacher', [\App\Http\Controllers\backend\TeacherController::class, 'index'])->name('teacher.index');
        // Teacher Assignment
        Route::resource('TeacherAssignments', \App\Http\Controllers\backend\TeacherAssignmentController::class);
        Route::get('/teacher/get-subjects/{class_id}', [\App\Http\Controllers\backend\TeacherAssignmentController::class, 'getSubjects']);

    });

    Route::middleware(['permission:Roll assignment'])->group(function () {
        Route::get('/roll-assignment', [\App\Http\Controllers\backend\RollAssignmentController::class, 'index'])
        ->name('roll.assignment');

        Route::post('/roll-assignment', [\App\Http\Controllers\backend\RollAssignmentController::class, 'store'])
        ->name('roll.assignment.store');
    });
    Route::middleware(['permission:Promotion'])->group(function () {
        Route::get('/promotions', [\App\Http\Controllers\backend\PromotionController::class, 'index'])
        ->name('promotions.index');

        Route::post('/promotions/process', [\App\Http\Controllers\backend\PromotionController::class, 'process'])
        ->name('promotions.process');
    });

    Route::middleware(['permission:Manage subject'])->group(function () {
        // Subjects
        Route::resource('subjects', \App\Http\Controllers\backend\SubjectController::class);
    });

    Route::middleware(['permission:Manage class'])->group(function () {
        //classes
        Route::get('/add-classe',[ClasseController::class,'create'])->name('classe.create');
        Route::get('/All-classe',[ClasseController::class,'index'])->name('classe.index');
        Route::post('/store-classe',[ClasseController::class,'store'])->name('classe.store');
        Route::get('/classes/edit/{id}', [ClasseController::class, 'edit'])->name('classe.edit');
        Route::post('/classes/update/{id}', [ClasseController::class, 'update'])->name('classe.update');
        Route::delete('/classe/delete/{id}', [ClasseController::class, 'destroy'])->name('classe.delete');
    });

    Route::middleware(['permission:Manage section'])->group(function () {
        // Sections
        Route::resource('sections', \App\Http\Controllers\backend\SectionController::class);
    });

    Route::middleware(['permission:Manage attendance'])->group(function () {
        Route::get('/attendance', [\App\Http\Controllers\backend\AttendanceController::class, 'create'])->name('attendance.create');
        Route::post('/attendance/store', [\App\Http\Controllers\backend\AttendanceController::class, 'store'])->name('attendance.store');
        Route::get('/attendance/report', [\App\Http\Controllers\backend\AttendanceController::class, 'report'])->name('attendance.report');
        Route::get('/attendance/edit', [\App\Http\Controllers\backend\AttendanceController::class, 'edit'])->name('attendance.edit');
        Route::get('/attendance/monthly-report', [\App\Http\Controllers\backend\AttendanceController::class, 'monthlyReport'])->name('attendance.monthlyReport');

        Route::get('/attendance/pdf', [\App\Http\Controllers\backend\AttendanceController::class, 'reportPdf'])->name('attendance.pdf');

        Route::get('/get-students/{class_id}/{section_id?}', [\App\Http\Controllers\backend\AttendanceController::class, 'getStudents']);
        Route::get('/get-students-edit/{class_id}/{section_id}/{date}', [\App\Http\Controllers\backend\AttendanceController::class, 'getStudentsForEdit']);
    });


    Route::middleware(['permission:View attendance'])->group(function () {
        Route::get('/attendance/calendar/{id?}', [\App\Http\Controllers\backend\AttendanceController::class, 'studentCalendar'])->name('attendance.calendar');
    });

    Route::middleware(['permission:Manage exam'])->group(function () {
        Route::resource('exams', \App\Http\Controllers\backend\ExamController::class);
    });

    Route::middleware(['permission:Manage result'])->group(function () {
        Route::resource('results', \App\Http\Controllers\backend\ResultController::class);
        Route::get('/get-exams/{class_id}', [\App\Http\Controllers\backend\ResultController::class, 'getExams']);
        Route::get('/get-subjects/{classId}/{examId}', [\App\Http\Controllers\backend\ResultController::class, 'getSubjects']);
        Route::get('/get-subjectsbyclass/{classId}', [\App\Http\Controllers\backend\ResultController::class, 'getSubjectsByClass']);
        Route::get('/get-students-result/{class_id}/{exam_id}/{subject_id}', [\App\Http\Controllers\backend\ResultController::class, 'getStudentsForResult']);
    });



    Route::middleware(['permission:View results'])->group(function () {

        Route::get('/result/marksheet', [\App\Http\Controllers\backend\ResultController::class, 'marksheet'])
            ->name('result.marksheet');
        Route::get('/get-exams/{class_id}', [\App\Http\Controllers\backend\ResultController::class, 'getExams']);
    });


    /*
    |--------------------------------------------------------------------------
    | FEES MODULE
    |--------------------------------------------------------------------------
    */
    Route::middleware(['permission:manage fees'])->group(function () {

        Route::resource('Fees', \App\Http\Controllers\backend\FeeController::class);

        Route::delete('/fees/bulk-delete', [\App\Http\Controllers\backend\FeeController::class, 'bulkDelete'])
            ->name('Fees.bulkDelete');
        Route::get('/fee-payments/create', [\App\Http\Controllers\backend\FeePaymentController::class, 'create'])->name('FeePayments.create');
        Route::post('/fee-payments/store', [\App\Http\Controllers\backend\FeePaymentController::class, 'store'])->name('FeePayments.store');
        Route::get('/fee-payments', [\App\Http\Controllers\backend\FeePaymentController::class, 'index'])->name('FeePayments.index');
        Route::get('/fee-payments/receipt/{receipt_no}', [\App\Http\Controllers\backend\FeePaymentController::class, 'receipt'])->name('FeePayments.receipt');

        Route::get('/get-student-fees', [\App\Http\Controllers\backend\FeePaymentController::class, 'getFees'])->name('FeePayments.getFees');
        Route::get('/student-ledger', [\App\Http\Controllers\backend\FeePaymentController::class, 'ledger'])->name('FeePayments.ledger');
    });

    Route::middleware(['permission:View ledger'])->group(function () {
        Route::get('/student-ledger', [\App\Http\Controllers\backend\FeePaymentController::class, 'ledger'])->name('FeePayments.ledger');
    });

    /*Route::get('/student-ledger', [\App\Http\Controllers\backend\FeePaymentController::class, 'ledger'])->name('FeePayments.ledger');
    |--------------------------------------------------------------------------
    | PROMOTION + ROLL ASSIGNMENT
    |--------------------------------------------------------------------------
    */




});

//students route
/*Route::get('/add-student',[StudentController::class,'create'])->name('student.create');
Route::get('/get-sections/{class_id}', [StudentController::class, 'getSections']);
Route::post('/store-student',[StudentController::class,'store'])->name('student.store');
Route::get('/All-student',[StudentController::class,'index'])->name('student.index');
Route::get('/edit-student/{id}', [StudentController::class,'edit'])->name('student.edit');
Route::post('/update-student/{id}', [StudentController::class,'update'])->name('student.update');
Route::delete('/delete-student/{id}', [StudentController::class,'destroy'])->name('student.destroy');

//Teachers route
Route::get('/add-teacher',[TeacherController::class,'create'])->name('teacher.create');
Route::post('/store-teacher',[TeacherController::class,'store'])->name('teacher.store');
Route::get('/All-teacher',[TeacherController::class,'index'])->name('teacher.index');


//subjects routes
Route::get('/add-subject',[SubjectController::class,'create'])->name('subject.create');
Route::get('/All-subject',[SubjectController::class,'index'])->name('subject.index');
Route::post('/store-subject',[SubjectController::class,'store'])->name('subject.store');
Route::get('/subject/edit/{id}', [SubjectController::class, 'edit'])->name('subject.edit');
Route::post('/subject/update/{id}', [SubjectController::class, 'update'])->name('subject.update');

//classes routes
Route::get('/add-classe',[ClasseController::class,'create'])->name('classe.create');
Route::get('/All-classe',[ClasseController::class,'index'])->name('classe.index');
Route::post('/store-classe',[ClasseController::class,'store'])->name('classe.store');
Route::get('/classes/edit/{id}', [ClasseController::class, 'edit'])->name('classe.edit');
Route::post('/classes/update/{id}', [ClasseController::class, 'update'])->name('classe.update');
Route::delete('/classe/delete/{id}', [ClasseController::class, 'destroy'])->name('classe.delete');

//Sections routes
Route::get('/add-Section',[SectionController::class,'create'])->name('section.create');
Route::get('/All-Section',[SectionController::class,'index'])->name('section.index');
Route::post('/store-Section',[SectionController::class,'store'])->name('section.store');
Route::get('/sections/edit/{id}', [SectionController::class, 'edit'])->name('section.edit');
Route::post('/sections/update/{id}', [SectionController::class, 'update'])->name('section.update');
Route::delete('/sections/delete/{id}', [SectionController::class, 'destroy'])->name('section.delete');


//Attendance routes
Route::get('/attendance', [AttendanceController::class, 'create'])->name('attendance.create');
Route::post('/attendance/store', [AttendanceController::class, 'store'])->name('attendance.store');

Route::get('/get-students/{class_id}/{section_id?}', [AttendanceController::class, 'getStudents']);
Route::get('/get-students-edit/{class_id}/{section_id}/{date}',[AttendanceController::class, 'getStudentsForEdit']);
Route::get('/attendance/report', [AttendanceController::class, 'report'])->name('attendance.report');
Route::get('/attendance/edit', [AttendanceController::class, 'edit'])->name('attendance.edit');
Route::get('/attendance/monthly-report', [AttendanceController::class, 'monthlyReport'])
    ->name('attendance.monthlyReport');
Route::get('/attendance/calendar/{id?}', [AttendanceController::class, 'studentCalendar'])
    ->name('attendance.calendar');
Route::get('/attendance/pdf', [AttendanceController::class, 'reportPdf'])
    ->name('attendance.pdf');


//Exams Routes
Route::resource('exams', ExamController::class);

//Result Routes
Route::get('/get-exams/{class_id}', [ResultController::class, 'getExams']);
Route::get('/get-subjects/{classId}/{examId}', [ResultController::class, 'getSubjects']);
Route::get('/get-subjectsbyclass/{classId}', [ResultController::class, 'getSubjectsByClass']);
Route::get('/get-students-result/{class_id}/{exam_id}/{subject_id}',
    [ResultController::class, 'getStudentsForResult']);
Route::resource('results', ResultController::class);
Route::get('/result/marksheet', [ResultController::class, 'marksheet'])->name('result.marksheet');



//Fees Routes
Route::resource('Fees', FeeController::class);
Route::delete('/fees/bulk-delete',[FeeController::class, 'bulkDelete'])->name('Fees.bulkDelete');



Route::get('/fee-payments/create',[FeePaymentController::class, 'create'])->name('FeePayments.create');

Route::post('/fee-payments/store',[FeePaymentController::class, 'store'])->name('FeePayments.store');

Route::get('/fee-payments',[FeePaymentController::class, 'index'])->name('FeePayments.index');
Route::get('/fee-payments/receipt/{receipt_no}',[FeePaymentController::class, 'receipt'])->name('FeePayments.receipt');
//get students fee
Route::get('/get-student-fees',[FeePaymentController::class, 'getFees'])->name('FeePayments.getFees');

Route::get('/student-ledger',[FeePaymentController::class, 'ledger'])->name('FeePayments.ledger');



//academic Session route
Route::resource('AcademicSessions',AcademicSessionController::class);
Route::put('AcademicSessions/{id}/active',[AcademicSessionController::class, 'active'])->name('AcademicSessions.active');

//Students Session route
Route::resource('StudentSessions',StudentSessionController::class);

//Teacher Assignment Session-wise route
Route::resource('TeacherAssignments', TeacherAssignmentController::class);
Route::get('/get-subjects/{class_id}', [TeacherAssignmentController::class, 'getSubjects']);


//Roll Assignment
Route::get('/roll-assignment', [RollAssignmentController::class, 'index'])->name('roll.assignment');
Route::post('/roll-assignment', [RollAssignmentController::class, 'store'])->name('roll.assignment.store');


//promotion routes
Route::get('/promotions', [PromotionController::class,'index'])->name('promotions.index');
Route::post('/promotions/process', [PromotionController::class,'process'])->name('promotions.process');
*/
