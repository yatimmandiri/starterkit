<?php

use App\Http\Controllers\Admin\Core\PermissionController;
use App\Http\Controllers\Admin\Core\Region\DistrictController;
use App\Http\Controllers\Admin\Core\Region\ProvinceController;
use App\Http\Controllers\Admin\Core\Region\RegencyController;
use App\Http\Controllers\Admin\Core\Region\VillageController;
use App\Http\Controllers\Admin\Core\RoleController;
use App\Http\Controllers\Admin\Core\UserController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\Sdm\ContractController;
use App\Http\Controllers\Admin\Sdm\EmployeeController;
use App\Http\Controllers\Admin\Sdm\GradeController;
use App\Http\Controllers\Admin\Sdm\HolidayController;
use App\Http\Controllers\Admin\Sdm\OfficeController;
use App\Http\Controllers\Admin\Sdm\PositionController;
use App\Http\Controllers\Admin\Sdm\ShiftController;
use App\Http\Controllers\Admin\Settings\LogActivityController;
use App\Http\Controllers\Admin\Settings\SiteSettingsController;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->as('admin.')->middleware(['auth', 'verified', 'auth.admin'])->group(function () {
    Route::redirect('/', '/admin/dashboard')->name('index');

    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('settings')->as('settings.')->group(function () {
        Route::get('site', [SiteSettingsController::class, 'edit'])->name('site.edit');
        Route::put('site', [SiteSettingsController::class, 'update'])->name('site.update');
        Route::put('profile', [AuthController::class, 'updateProfile'])->name('profile.update');
    });

    Route::prefix('logs')->as('logs.')->group(function () {
        Route::get('activities/data', [LogActivityController::class, 'getData'])->name('activities.data');
        Route::get('activities', [LogActivityController::class, 'index'])->name('activities.index');
    });

    Route::prefix('core')->as('core.')->group(function () {
        Route::get('permissions/data', [PermissionController::class, 'getData'])->name('permissions.data');
        Route::resource('permissions', PermissionController::class);

        Route::get('roles/data', [RoleController::class, 'getData'])->name('roles.data');
        Route::resource('roles', RoleController::class);

        Route::post('users/bulk-action', [UserController::class, 'bulkAction'])->name('users.bulk-action');
        Route::put('users/{user}/verify', [UserController::class, 'verify'])->name('users.verify');
        Route::get('users/data', [UserController::class, 'getData'])->name('users.data');
        Route::resource('users', UserController::class);

        Route::prefix('regions')->as('regions.')->group(function () {
            Route::get('provinces/data', [ProvinceController::class, 'getData'])->name('provinces.data');
            Route::resource('provinces', ProvinceController::class);

            Route::get('regencies/data', [RegencyController::class, 'getData'])->name('regencies.data');
            Route::resource('regencies', RegencyController::class);

            Route::get('districts/data', [DistrictController::class, 'getData'])->name('districts.data');
            Route::resource('districts', DistrictController::class);

            Route::get('villages/data', [VillageController::class, 'getData'])->name('villages.data');
            Route::resource('villages', VillageController::class);
        });
    });

    Route::prefix('sdm')->as('sdm.')->group(function () {
        Route::put('offices/{office}/status', [OfficeController::class, 'updateStatus'])->name('offices.status');
        Route::post('offices/reorder', [OfficeController::class, 'reorder'])->name('offices.reorder');
        Route::get('offices/data', [OfficeController::class, 'getData'])->name('offices.data');
        Route::resource('offices', OfficeController::class);

        Route::get('grades/data', [GradeController::class, 'getData'])->name('grades.data');
        Route::resource('grades', GradeController::class);

        Route::put('positions/{position}/status', [PositionController::class, 'updateStatus'])->name('positions.status');
        Route::post('positions/reorder', [PositionController::class, 'reorder'])->name('positions.reorder');
        Route::get('positions/data', [PositionController::class, 'getData'])->name('positions.data');
        Route::resource('positions', PositionController::class);

        Route::get('contracts/data', [ContractController::class, 'getData'])->name('contracts.data');
        Route::resource('contracts', ContractController::class);

        Route::get('shifts/data', [ShiftController::class, 'getData'])->name('shifts.data');
        Route::resource('shifts', ShiftController::class);

        Route::get('holidays/data', [HolidayController::class, 'getData'])->name('holidays.data');
        Route::resource('holidays', HolidayController::class);

        Route::put('employees/{employee}/status', [EmployeeController::class, 'updateStatus'])->name('employees.status');
        Route::get('employees/data', [EmployeeController::class, 'getData'])->name('employees.data');
        Route::resource('employees', EmployeeController::class);
    });
});
