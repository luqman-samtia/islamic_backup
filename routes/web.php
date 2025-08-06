<?php
use App\Http\Controllers\StudentController;

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


// Student Login Routes
Route::post('student/register', [StudentController::class, 'register'])->name('student.register');
Route::post('student/login', [StudentController::class, 'login'])->name('student.login');
// If using web routes
Route::post('/forgot-password', [StudentController::class, 'forgotPasswordRequest'])->name('student.forgotPassword');
Route::get('/reset-password/{token}', [StudentController::class, 'showResetForm'])->name('password.reset.form');
Route::post('/password-reset', [StudentController::class, 'submitResetPassword'])->name('password.reset.submit');

Route::post('student/logout', [StudentController::class, 'logout'])->name('student.logout');


Route::get('admin/verify-student/{id}', [StudentController::class, 'verifyStudent'])->name('admin.verifyStudent');
Route::get('admin/verify/student/{id}', [StudentController::class, 'adminVerifyStudent'])->name('admin.adminVerifyStudent');
Route::get('admin/disable/student/{id}', [StudentController::class, 'adminDisableStudent'])->name('admin.adminDisableStudent');
Route::get('admin/check-student-status/{id}', [StudentController::class, 'checkStudentStatus']);
Route::get('admin/check-student-disable/{id}', [StudentController::class, 'checkStudentDisable']);


// END
Route::get('/', 'PublicController@index')->name('site');
Route::match(['GET', 'POST'],'/contactUs', 'PublicController@contactUs')->name('contactUs');
Route::get('/page/{slug}', 'PublicController@page')->middleware('student.auth')->name('page');
Route::get('/quran', 'PublicController@quran')->middleware('student.auth')->name('quranPage');
Route::prefix('quran')->middleware('student.auth')->group(function(){
    Route::prefix('{surat}')->middleware('student.auth')->group(function(){
        Route::get('/', 'PublicController@quranSurat')->name('quranSurat');
        Route::get('page/{page}', 'PublicController@quranSuratPage')->name('quranSurat.page');
    });
});

Route::prefix('tajweed-quran')->middleware('student.auth')->group(function(){
    Route::get('search', 'PublicController@tajweedQuranSearch')->name('tajweedQuranSearch');
    Route::get('/', 'PublicController@tajweedQuran')->name('tajweedQuran');
   

    Route::prefix('{surat}')->middleware('student.auth')->group(function(){
        Route::get('/', 'PublicController@tajweedQuranSurat')->name('tajweedQuranSurat');
        Route::get('page/{page}', 'PublicController@tajweedQuranSuratPage')->name('tajweedQuranSurat.page');
    });
});

Route::get('/faq', 'PublicController@faq')->name('faq');
Route::get('/charges', 'PublicController@charges')->name('charges');
Route::get('/islamicmedia/{slug}', 'PublicController@media')->middleware('student.auth')->name('islamicmedia');
Route::get('/terms', 'PublicController@terms')->name('terms');
Route::get('/article/{slug}', 'PublicController@artical')->name('artical');
Route::get('/search', 'PublicController@search')->middleware('student.auth')->name('search');

Auth::routes();

Route::middleware('auth')->prefix('admin')->group(function(){

    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/pages', 'HomeController@pages')->name('pages');
    Route::get('/emails', 'HomeController@emails')->name('emails');
    
    // Students>>>>>>>>
    Route::get('/students', 'StudentController@students')->name('admin.student');
    // Assign scholar to student   
    Route::get('/student/{id}', 'StudentController@getStudent')->name('admin.student.get');
    Route::post('/students/assign-scholar', 'StudentController@assignScholar')->name('admin.student.assign-scholar');
    // end>>>>>>>>>>
    Route::post('/students/destroy', 'StudentController@students_destroy')->name('admin.student.destroy');
    Route::get('/student/add-links/{id}','StudentController@showAddLinksForm')->name('admin.student.addLinks');


    Route::post('/student/update-links', 'StudentController@update')->name('admin.student.update');
    Route::post('/student/remove-student-item', 'StudentController@removeStudentItem')->name('information.student-item.destroy');
    Route::get('/student/show/info', 'StudentController@StudentDataShow')->name('information.student-data.show');
    Route::get('/student/update/password',  function () {
        return view('admin.students.updatepassword');
    })->name('student.update-password');
    Route::post('/student/update-password', 'StudentController@StudentUpdatePassword')->name('information.student.update-password');
    // Route::get('/student/submit-feedback', function(){
    //     $feedback = Feedback::where('user_id', Auth::id())->first();
    //     return view('admin.students.feedback',compact('feedback'));
    // })->name('student.feedback.submit');

    // crud feedback
    Route::get('/student/submit/feedback','StudentController@showFeedback')->name('student.feedback.submit');
    Route::match(['GET', 'POST'], '/student/submit-feedback/add', 'StudentController@addFeedback')->name('feedback.add');
    Route::match(['GET', 'POST'], '/student/submit-feedback/{testimonial}/edit', 'StudentController@editFeedback')->name('feedback.edit');
    Route::post('/student/submit-feedback/delete', 'StudentController@deleteFeedback')->name('feedback.delete');
    // end crud feedback
    // Route::post('/student/submit-feedback','StudentController@submitFeedback')->name('feedback.submit');
    Route::get('/feedback/{id}', 'StudentController@getFeedback')->name('feedback.get');
    Route::get('/feedbacks/{id}', 'StudentController@showStudentFeedbacks')->name('admin.feedback.show');



    



    Route::prefix('resources')->group(function (){
        Route::get('/', 'ResourcesController@index')->name('resources');
        Route::match(['GET', 'POST'], '/add', 'ResourcesController@add')->name('resources.add');
        Route::match(['GET', 'POST'], '{resource}/edit', 'ResourcesController@edit')->name('resources.edit');
        Route::post('/delete', 'ResourcesController@delete')->name('resources.delete');
        Route::match(['GET', 'POST'], '{resource}/add', 'ResourcesController@resourceAdd')->name('resource.child.add');
        Route::match(['GET', 'POST'], '{resource}/edit/{childResource}', 'ResourcesController@resourceEdit')->name('resource.child.edit');
        Route::get('{resource}', 'ResourcesController@resource')->name('resources.resources');
    });

    Route::prefix('information')->group(function (){
        Route::get('/', 'InformationController@index')->name('information');
        Route::post('update', 'InformationController@update')->name('information.update');
        Route::post('remove-footer-item', 'InformationController@removeFooterItem')->name('information.footer-item.destroy');
        Route::post('remove-student-item', 'InformationController@removeStudentItem')->name('information.student-item.destroy');

    });

    Route::prefix('scholars')->group(function (){
        Route::get('/', 'ScholarsController@index')->name('scholars');
        Route::match(['GET', 'POST'], '/add', 'ScholarsController@add')->name('scholars.add');
        Route::match(['GET', 'POST'], '{scholar}/edit', 'ScholarsController@edit')->name('scholars.edit');
        Route::post('/delete', 'ScholarsController@delete')->name('scholars.delete');
        // get student associated with scholar
        Route::get('/students', 'ScholarsController@getStudents')->name('scholars.students');
    });

    Route::prefix('testimonials')->group(function (){
        Route::get('/', 'TestimonialsController@index')->name('testimonials');
        Route::match(['GET', 'POST'], '/add', 'TestimonialsController@add')->name('testimonials.add');
        Route::match(['GET', 'POST'], '{testimonial}/edit', 'TestimonialsController@edit')->name('testimonials.edit');
        Route::post('/delete', 'TestimonialsController@delete')->name('testimonials.delete');
    });


    Route::prefix('quran')->group(function () {
        Route::get('/', 'QuranController@index')->name('quran');
        Route::match(['GET', 'POST'], '/add', 'QuranController@add')->name('quran.add');
        Route::match(['GET', 'POST'], '{quran}/edit', 'QuranController@edit')->name('quran.edit');
        Route::post('/delete', 'QuranController@delete')->name('quran.delete');
        Route::match(['GET', 'POST'], '{quran}/add', 'QuranController@quranAdd')->name('quran.child.add');
        Route::match(['GET', 'POST'], '{quran}/edit/{childQuran}', 'QuranController@quranEdit')->name('quran.child.edit');
        Route::get('{quran}', 'QuranController@quran')->name('quran.quran');
    });


    Route::prefix('tajweed-quran')->group(function () {
        Route::get('/', 'TajweedQuranController@index')->name('tajweed.quran');
        Route::match(['GET', 'POST'], '/add', 'TajweedQuranController@add')->name('tajweed.quran.add');
        Route::match(['GET', 'POST'], '{quran}/edit', 'TajweedQuranController@edit')->name('tajweed.quran.edit');
        Route::post('/delete', 'TajweedQuranController@delete')->name('tajweed.quran.delete');
        Route::match(['GET', 'POST'], '{quran}/add', 'TajweedQuranController@quranAdd')->name('tajweed.quran.child.add');
        Route::match(['GET', 'POST'], '{quran}/edit/{childQuran}', 'TajweedQuranController@quranEdit')->name('tajweed.quran.child.edit');
        Route::get('{quran}', 'TajweedQuranController@quran')->name('tajweed.quran.quran');
    });


    Route::prefix('articles')->group(function () {
        Route::get('/', 'ArticalsController@index')->name('articals');
        Route::match(['GET', 'POST'], '/add', 'ArticalsController@add')->name('articals.add');
        Route::match(['GET', 'POST'], '{artical}/edit', 'ArticalsController@edit')->name('articals.edit');
        Route::post('/delete', 'ArticalsController@delete')->name('articals.delete');
        Route::get('{article}', 'ArticalsController@artical')->name('articals.articals');
    });

    Route::prefix('media')->group(function (){
        Route::get('/', 'MediaController@index')->name('media');
        Route::match(['GET', 'POST'], '/add', 'MediaController@add')->name('media.add');
        Route::match(['GET', 'POST'], '{media}/edit', 'MediaController@edit')->name('media.edit');
        Route::post('/delete', 'MediaController@delete')->name('media.delete');
        Route::match(['GET', 'POST'], '{media}/add', 'MediaController@mediaAdd')->name('media.child.add');
        Route::match(['GET', 'POST'], '{media}/edit/{childMedia}', 'MediaController@mediaEdit')->name('media.child.edit');
        Route::get('{media}', 'MediaController@media')->name('media.media');
    });

    Route::prefix('users')->group(function (){
        Route::get('/', 'UserController@index')->name('users');
        Route::match(['GET', 'POST'], '/add', 'UserController@add')->name('users.add');
        Route::match(['GET', 'POST'], '{user}/edit', 'UserController@edit')->name('users.edit');
        Route::get('{user}/delete', 'UserController@delete')->name('users.delete');
        Route::match(['GET', 'POST'], '{user}/role', 'UserController@role')->name('users.role');
    });

    Route::prefix('roles')->group(function (){
        Route::get('/', 'RoleController@index')->name('roles');
        Route::match(['GET', 'POST'], '/add', 'RoleController@add')->name('roles.add');
        Route::match(['GET', 'POST'], '{role}/edit', 'RoleController@edit')->name('roles.edit');
        Route::get('{role}/delete', 'RoleController@delete')->name('roles.delete');
        Route::match(['GET', 'POST'], '{role}/permissions', 'RoleController@permissions')->name('roles.permissions');
    });

    Route::prefix('permissions')->group(function (){
        Route::get('/', 'PermissionController@index')->name('permissions');
        Route::match(['GET', 'POST'], '/add', 'PermissionController@add')->name('permissions.add');
        Route::match(['GET', 'POST'], '{permission}/edit', 'PermissionController@edit')->name('permissions.edit');
        Route::get('{permission}/delete', 'PermissionController@delete')->name('permissions.delete');
        Route::match(['GET', 'POST'], '{permission}/roles', 'PermissionController@roles')->name('permissions.roles');
    });

    Route::prefix('payment-methods')->group(function (){
        Route::get('/', 'PaymentsController@index')->name('payments');
        Route::match(['GET', 'POST'], '/add', 'PaymentsController@add')->name('payments.add');
        Route::match(['GET', 'POST'], '{paymentMethod}/edit', 'PaymentsController@edit')->name('payments.edit');
        Route::post('/delete', 'PaymentsController@delete')->name('payments.delete');
    });

});
