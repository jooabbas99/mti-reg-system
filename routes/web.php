<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CmsController;
use App\Http\Controllers\GoogleLoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\ModuleSettingController;

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

// Route::redirect('/', 'login');

Route::get('/login', function () {
    return view('dashboard.auth.login');
});



Auth::routes();
Route::group(['prefix' => '', 'middleware' => ['auth']], function () {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::get('/student/profile', [App\Http\Controllers\StudentController::class, 'profile'])->name('student.profile');
    Route::get('/student/available-courses', [App\Http\Controllers\StudentController::class, 'registerCourses'])->name('student.getAvailableCourses');
    
    Route::post('/student/available-courses/register', [App\Http\Controllers\StudentController::class, 'register'])->name('student.register');
    Route::get('/student/my-registrations', [App\Http\Controllers\StudentController::class, 'myRegistrations'])->name('student.myRegistrations');

    Route::get('/student/{id}/registrations/current', [App\Http\Controllers\StudentController::class, 'getCurrentRegistrations'])->name('student.getCurrentRegistrations');
    Route::get('/student/{id}/registrations/failed', [App\Http\Controllers\StudentController::class, 'getFailedRegistrations'])->name('student.getFailedRegistrations');
    Route::get('/student/{id}/registrations/all', [App\Http\Controllers\StudentController::class, 'getAllRegistrations'])->name('student.getAllRegistrations');
    Route::get('/student/{id}/courses/current-semester', [App\Http\Controllers\StudentController::class, 'getSemesterCourses'])->name('student.getSemesterCourses');

    // Route::get('/students/registrations', [App\Http\Controllers\StudentController::class, 'registrations'])->name('students.registrations');
    // Route::get('/students/clinics', [App\Http\Controllers\StudentController::class, 'clinics'])->name('students.clinics');
    // Route::post('/students/update/', [App\Http\Controllers\StudentController::class, 'update'])->name('students.update');
    // Route::get('/facilities', [App\Http\Controllers\FacilityController::class, 'index'])->name('facilities.index');

    // // faculty
    // Route::get('/faculties', [App\Http\Controllers\FacultiesController::class, 'index'])->name('faculties.index');
    // // Offers
    // Route::get('/offers', [App\Http\Controllers\FacilityController::class, 'index'])->name('offers.index');
    // Route::get('/offers/create', [App\Http\Controllers\FacilityController::class, 'create'])->name('offers.create');
    // Route::get('/offers/edit/{id}', [App\Http\Controllers\FacilityController::class, 'edit'])->name('offers.edit');
    // Route::post('/offers/update/', [App\Http\Controllers\FacilityController::class, 'update'])->name('offers.update');
    // Route::post('/offers/update/meta', [App\Http\Controllers\FacilityController::class, 'update_meta'])->name('offers.update-meta');
    // Route::post('/offers/store', [App\Http\Controllers\OfferController::class, 'store'])->name('offers.store');
    // Route::post('/offers/store/clinic', [App\Http\Controllers\OfferController::class, 'store_clinic'])->name('offers.store_clinic');
    // Route::post('/offers/destroy', [App\Http\Controllers\FacilityController::class, 'destroy'])->name('offers.destroy');
    // Route::post('/offers/facility-destroy', [App\Http\Controllers\FacilityController::class, 'destroy_offer'])->name('offers.facility_destroy');
    // Route::get('/durations', [App\Http\Controllers\DurationController::class, 'index'])->name('durations.index');

    // Route::get('/registrations', [App\Http\Controllers\RegistrationController::class, 'index'])->name('registrations.index');
    // Route::get('/registrations/clinics', [App\Http\Controllers\RegistrationController::class, 'index_clinic'])->name('registrations.index_clinic');
    // Route::get('/ajax/registrations', [App\Http\Controllers\RegistrationController::class, 'get_clinics'])->name('registrations.get_clinics');
    // Route::get('/registrations/create', [App\Http\Controllers\RegistrationController::class, 'create'])->name('registrations.create');
    // Route::get('/registrations/edit/{id}', [App\Http\Controllers\RegistrationController::class, 'edit'])->name('registrations.edit');
    // Route::post('/registrations/update/', [App\Http\Controllers\RegistrationController::class, 'update'])->name('registrations.update');
    // Route::post('/registrations/update/meta', [App\Http\Controllers\RegistrationController::class, 'update_meta'])->name('registrations.update-meta');
    // Route::post('/registrations/store', [App\Http\Controllers\RegistrationController::class, 'store'])->name('registrations.store');

    //enrollments 
    // Route::get('/enrollments', [App\Http\Controllers\EnrollmentsController::class, 'index'])->name('enrollments.index');

    // Route::get('/enrollments/my-enrollments/', [App\Http\Controllers\EnrollmentsController::class, 'get_student_registrations'])->name('enrollments.get_student_registrations');

    // Route::post('/enrollments/register', [App\Http\Controllers\EnrollmentsController::class, 'register'])->name('enrollments.register');
    // Route::get('/ajax/enrollments/detail', [App\Http\Controllers\EnrollmentsController::class, 'get_offers_details'])->name('enrollments.get_offers_details');
    // Route::get('/ajax/enrollments', [App\Http\Controllers\EnrollmentsController::class, 'get_offers'])->name('enrollments.get_offers');
    // Route::get('/enrollments/create', [App\Http\Controllers\EnrollmentsController::class, 'create'])->name('enrollments.create');
    // Route::get('/enrollments/edit/{id}', [App\Http\Controllers\EnrollmentsController::class, 'edit'])->name('enrollments.edit');
    // Route::post('/enrollments/update/', [App\Http\Controllers\EnrollmentsController::class, 'update'])->name('enrollments.update');
    // Route::post('/enrollments/update/meta', [App\Http\Controllers\EnrollmentsController::class, 'update_meta'])->name('enrollments.update-meta');
    // Route::post('/enrollments/store', [App\Http\Controllers\EnrollmentsController::class, 'store'])->name('enrollments.store');
});

Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'admin']], function () {
    Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');
    Route::get('/profile', [App\Http\Controllers\HomeController::class, 'profile'])->name('admin.profile');
    Route::post('/profile/store', [App\Http\Controllers\HomeController::class, 'storeProfile'])->name('admin.storeProfile');
    Route::get('/change_password', [App\Http\Controllers\HomeController::class, 'change_password'])->name('admin.change_password');

    Route::get('/modulesetting', [App\Http\Controllers\ModuleSettingController::class, 'index'])->name('modulesetting.index');
    Route::get('/modulesetting/create', [App\Http\Controllers\ModuleSettingController::class, 'create'])->name('modulesetting.create');
    Route::post('/modulesetting/store', [App\Http\Controllers\ModuleSettingController::class, 'store'])->name('modulesetting.store');
    Route::get('/modulesetting/edit/{id}', [App\Http\Controllers\ModuleSettingController::class, 'edit'])->name('modulesetting.edit');
    Route::post('/modulesetting/update/{id}', [App\Http\Controllers\ModuleSettingController::class, 'update'])->name('modulesetting.update');
    Route::delete('/modulesetting/destroy', [App\Http\Controllers\ModuleSettingController::class, 'destroy'])->name('modulesetting.destroy');
    Route::get('/modulesetting/editattribute/{id}', [App\Http\Controllers\ModuleSettingController::class, 'editattribute'])->name('modulesetting.editattribute');

    Route::get('/user', [App\Http\Controllers\UserController::class, 'index'])->name('user.index');
    Route::get('/user/create', [App\Http\Controllers\UserController::class, 'create'])->name('user.create');
    Route::post('/user/store', [App\Http\Controllers\UserController::class, 'store'])->name('user.store');
    Route::get('/user/edit/{id}', [App\Http\Controllers\UserController::class, 'edit'])->name('user.edit');
    Route::post('/user/update/{id}', [App\Http\Controllers\UserController::class, 'update'])->name('user.update');
    Route::get('/user/destroy/{id}', [App\Http\Controllers\UserController::class, 'destroy'])->name('user.destroy');
    Route::delete('/user/deleteAllUser', [App\Http\Controllers\UserController::class, 'deleteAllUser'])->name('user.delete-all');
    Route::get('/user/status/{id}/{status}', [App\Http\Controllers\UserController::class, 'status'])->name('user.status');

    Route::get('/student', [App\Http\Controllers\StudentController::class, 'index'])->name('student.index');
    Route::get('/student/create', [App\Http\Controllers\StudentController::class, 'create'])->name('student.create');
    Route::post('/student/store', [App\Http\Controllers\StudentController::class, 'store'])->name('student.store');
    Route::get('/student/{id}/profile', [App\Http\Controllers\StudentController::class, 'studentProfile'])->name('student.studentProfile');



    Route::get('/student/edit/{id}', [App\Http\Controllers\StudentController::class, 'edit'])->name('student.edit');
    Route::post('/student/update/{id}', [App\Http\Controllers\StudentController::class, 'update'])->name('student.update');
    Route::get('/student/destroy/{id}', [App\Http\Controllers\StudentController::class, 'destroy'])->name('student.destroy');
    Route::delete('/student/deleteAllStudent', [App\Http\Controllers\StudentController::class, 'deleteAllStudent'])->name('student.delete-all');
    Route::get('/student/status/{id}/{status}', [App\Http\Controllers\StudentController::class, 'status'])->name('student.status');


    
    Route::get('/supervisor/semesters/', [App\Http\Controllers\SupervisorMainController::class, 'index'])->name('supervisor.semestersIndex');
    Route::get('/supervisor/semesters/create', [App\Http\Controllers\SupervisorMainController::class, 'createNewSemester'])->name('supervisor.createNewSemester');
    Route::post('/supervisor/semesters/store', [App\Http\Controllers\SupervisorMainController::class, 'storeNewSemester'])->name('supervisor.storeNewSemester');
    Route::post('/supervisor/semesters/update/{id}', [App\Http\Controllers\SupervisorMainController::class, 'updateNewSemester'])->name('supervisor.updateNewSemester');
    Route::get('/supervisor/semesters/current', [App\Http\Controllers\SupervisorMainController::class, 'currentSemester'])->name('supervisor.currentSemester');
    Route::get('/supervisor/semesters/current-all', [App\Http\Controllers\SupervisorMainController::class, 'getAllCourses'])->name('supervisor.currentSemesterAll');
    Route::get('/supervisor/semesters/current-regular', [App\Http\Controllers\SupervisorMainController::class, 'getRecommendedCourses'])->name('supervisor.getRecommendedCourses');
    Route::get('/supervisor/semesters/current-irregular', [App\Http\Controllers\SupervisorMainController::class, 'getRecommendedCoursesIrregular'])->name('supervisor.getRecommendedCoursesIrregular');
    Route::post('/supervisor/courses/open/', [App\Http\Controllers\SupervisorMainController::class, 'openCourses'])->name('supervisor.openCourses');
    Route::get('/supervisor/courses/available/', [App\Http\Controllers\SupervisorMainController::class, 'getAllOpenedCourses'])->name('supervisor.getAllOpenedCourses');
    
    Route::get('/supervisor/registrations/', [App\Http\Controllers\SupervisorMainController::class, 'getRegistrations'])->name('supervisor.getRegistrations');
    Route::post('/supervisor/registrations/approve', [App\Http\Controllers\SupervisorMainController::class, 'approveRegistration'])->name('supervisor.approveRegistration');
    Route::post('/supervisor/registrations/cancel', [App\Http\Controllers\SupervisorMainController::class, 'cancelRegistration'])->name('supervisor.cancelRegistration');



    Route::get('/supervisor/edit/{id}', [App\Http\Controllers\SupervisorMainController::class, 'edit'])->name('supervisor.edit');
    Route::post('/supervisor/update/{id}', [App\Http\Controllers\SupervisorMainController::class, 'update'])->name('supervisor.update');
    Route::get('/supervisor/destroy/{id}', [App\Http\Controllers\SupervisorMainController::class, 'destroy'])->name('supervisor.destroy');
    Route::delete('/supervisor/supervisor', [App\Http\Controllers\SupervisorMainController::class, 'supervisor'])->name('supervisor.delete-all');
    Route::get('/supervisor/status/{id}/{status}', [App\Http\Controllers\SupervisorMainController::class, 'status'])->name('supervisor.status');




    Route::get('/settings', [App\Http\Controllers\SettingController::class, 'index'])->name('setting.index');
    Route::get('/settings/create', [App\Http\Controllers\SettingController::class, 'create'])->name('setting.create');
    Route::post('/settings/store', [App\Http\Controllers\SettingController::class, 'store'])->name('setting.store');
    Route::get('/settings/edit/{id}', [App\Http\Controllers\SettingController::class, 'edit'])->name('setting.edit');
    Route::post('/settings/update/{id}', [App\Http\Controllers\SettingController::class, 'update'])->name('setting.update');
    Route::get('/settings/destroy/{id}', [App\Http\Controllers\SettingController::class, 'destroy'])->name('setting.destroy');


});

// Route::get('auth/google', [App\Http\Controllers\GoogleLoginController::class, 'redirectToGoogle'])->name('google.login');
// Route::get('auth/google/callback', [App\Http\Controllers\GoogleLoginController::class, 'handleGoogleCallback']);
Route::get('/modulesetting/getattribute/{user}', [App\Http\Controllers\ModuleSettingController::class, 'getattribute'])->name('modulesetting.getattribute');
// Route::get('/admin/profile', [App\Http\Controllers\HomeController::class, 'profile'])->name('admin.profile');
// Route::get('/admin/change_password', [App\Http\Controllers\HomeController::class, 'change_password'])->name('admin.change_password');

// Route::get('/admin/user', [App\Http\Controllers\UserController::class, 'index'])->name('user.index');
// Route::get('/admin/user/create', [App\Http\Controllers\UserController::class, 'create'])->name('user.create');
// Route::post('/admin/user/store', [App\Http\Controllers\UserController::class, 'store'])->name('user.store');
// Route::get('/admin/user/edit/{id}', [App\Http\Controllers\UserController::class, 'edit'])->name('user.edit');
// Route::post('/admin/user/update/{id}', [App\Http\Controllers\UserController::class, 'update'])->name('user.update');
// Route::get('/admin/user/destroy/{id}', [App\Http\Controllers\UserController::class, 'destroy'])->name('user.destroy');
// Route::delete('/admin/user/deleteAllUser', [App\Http\Controllers\UserController::class, 'deleteAllUser'])->name('user.delete-all');
// Route::get('/admin/user/status/{id}/{status}', [App\Http\Controllers\UserController::class, 'status'])->name('user.status');

// Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');

// Route::get('/admin/cms', [App\Http\Controllers\CmsController::class, 'index'])->name('cms.index');
// Route::get('/admin/cms/create', [App\Http\Controllers\CmsController::class, 'create'])->name('cms.create');
// Route::post('/admin/cms/store', [App\Http\Controllers\CmsController::class, 'store'])->name('cms.store');
// Route::get('/admin/cms/edit/{id}', [App\Http\Controllers\CmsController::class, 'edit'])->name('cms.edit');
// Route::post('/admin/cms/update/{id}', [App\Http\Controllers\CmsController::class, 'update'])->name('cms.update');
// Route::get('/admin/cms/destroy/{id}', [App\Http\Controllers\CmsController::class, 'destroy'])->name('cms.destroy');
// Route::delete('/admin/cms/deleteAll', [App\Http\Controllers\CmsController::class, 'deleteAll'])->name('cms.delete-all');
// Route::get('/admin/cms/{slug}', [App\Http\Controllers\CmsController::class, 'preview'])->name('cms.preview');

// Route::get('/modulesetting', [App\Http\Controllers\ModuleSettingController::class, 'index'])->name('modulesetting.index');
// Route::get('/modulesetting/create', [App\Http\Controllers\ModuleSettingController::class, 'create'])->name('modulesetting.create');
// Route::post('/modulesetting/store', [App\Http\Controllers\ModuleSettingController::class, 'store'])->name('modulesetting.store');
// Route::get('/modulesetting/edit', [App\Http\Controllers\ModuleSettingController::class, 'edit'])->name('modulesetting.edit');
// Route::post('/modulesetting/update/{id}', [App\Http\Controllers\ModuleSettingController::class, 'update'])->name('modulesetting.update');
// Route::get('/modulesetting/destroy/{id}', [App\Http\Controllers\ModuleSettingController::class, 'destroy'])->name('modulesetting.destroy');

// Route::get('/settings', [App\Http\Controllers\SettingController::class, 'index'])->name('setting.index');
// Route::get('/settings/create', [App\Http\Controllers\SettingController::class, 'create'])->name('setting.create');
// Route::post('/settings/store', [App\Http\Controllers\SettingController::class, 'store'])->name('setting.store');
// Route::get('/settings/edit/{id}', [App\Http\Controllers\SettingController::class, 'edit'])->name('setting.edit');
// Route::post('/settings/update/{id}', [App\Http\Controllers\SettingController::class, 'update'])->name('setting.update');
// Route::get('/settings/destroy/{id}', [App\Http\Controllers\SettingController::class, 'destroy'])->name('setting.destroy');

// Route::get('auth/google', [App\Http\Controllers\GoogleLoginController::class, 'redirectToGoogle'])->name('google.login');
// Route::get('auth/google/callback', [App\Http\Controllers\GoogleLoginController::class, 'handleGoogleCallback']);
