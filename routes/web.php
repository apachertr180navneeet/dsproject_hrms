<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\{
    HomeController
};

use App\Http\Controllers\Admin\{
    AdminAuthController,
    EmployeeController,
    AttendenceController
};

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


Route::get('/', [HomeController::class, 'index'])->name('/');
Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::prefix('admin')->name('admin.')->group(function () {

    // Public routes (No auth middleware required)
    Route::controller(AdminAuthController::class)->group(function () {
        Route::get('/', 'index');

        Route::get('login', 'login')->name('login');
        Route::post('login', 'postLogin')->name('login.post');

        Route::get('forget-password', 'showForgetPasswordForm')->name('forget.password.get');
        Route::post('forget-password', 'submitForgetPasswordForm')->name('forget.password.post');

        Route::get('reset-password/{token}', 'showResetPasswordForm')->name('reset.password.get');
        Route::post('reset-password', 'submitResetPasswordForm')->name('reset.password.post');
    });
    Route::middleware('admin')->group(function () {
        // Protected admin routes (Requires admin middleware)
        Route::controller(AdminAuthController::class)->group(function () {
            Route::get('dashboard', 'adminDashboard')->name('dashboard');

            Route::get('change-password', 'changePassword')->name('change.password');
            Route::post('update-password', 'updatePassword')->name('update.password');

            Route::get('logout', 'logout')->name('logout');

            Route::get('profile', 'adminProfile')->name('profile');
            Route::post('profile', 'updateAdminProfile')->name('update.profile');
        });

        Route::prefix('employee')->name('employee.')->controller(EmployeeController::class)->group(function () {
            Route::get('index', 'index')->name('index');
            Route::get('get-all', 'getall')->name('getall');
            Route::get('add', 'add')->name('add');
            Route::delete('/delete/{id}', 'destroy')->name('destroy');
            Route::post('/save-basic-info', 'saveBasicInfo')->name('save.basic.info');
            Route::post('/save-employee-detail', 'saveEmployeDetail')->name('save.employee.detail');
            Route::post('/save-employee-document', 'saveEmployeDocument')->name('save.employee.document');
            Route::get('edit/{id}', 'edit')->name('edit');
        });
        Route::prefix('attendence')->name('attendence.')->controller(AttendenceController::class)->group(function () {
            Route::get('index', 'index')->name('index');
            Route::post('add', 'addattendence')->name('add');
            Route::delete('/delete/{id}', 'destroy')->name('destroy');
        });
    });

});

Route::middleware(['auth'])->group(function () {

});



