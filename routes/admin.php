<?php

use App\Http\Controllers\Admin\Core\PermissionController;
use App\Http\Controllers\Admin\Core\RoleController;
use App\Http\Controllers\Admin\Core\UserController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\Settings\SiteSettingsController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->as('admin.')->middleware(['auth', 'verified', 'auth.admin'])->group(function () {
    Route::redirect('/', '/admin/dashboard')->name('index');

    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('settings')->as('settings.')->group(function () {
        Route::get('site', [SiteSettingsController::class, 'edit'])->name('site.edit');
        Route::put('site', [SiteSettingsController::class, 'update'])->name('site.update');
    });

    Route::prefix('core')->as('core.')->group(function () {
        Route::get('permissions/data', [PermissionController::class, 'getData'])->name('permissions.data');
        Route::resource('permissions', PermissionController::class);

        Route::get('roles/data', [RoleController::class, 'getData'])->name('roles.data');
        Route::resource('roles', RoleController::class);

        Route::get('users/data', [UserController::class, 'getData'])->name('users.data');
        Route::resource('users', UserController::class);

        // Route::prefix('regions')->as('regions.')->group(function () {
        //     Route::get('provinces/data', [ProvinceController::class, 'getData'])->name('provinces.data');
        //     Route::resource('provinces', ProvinceController::class);

        //     Route::get('regencies/data', [RegencyController::class, 'getData'])->name('regencies.data');
        //     Route::resource('regencies', RegencyController::class);

        //     Route::get('districts/data', [DistrictController::class, 'getData'])->name('districts.data');
        //     Route::resource('districts', DistrictController::class);

        //     Route::get('villages/data', [VillageController::class, 'getData'])->name('villages.data');
        //     Route::resource('villages', VillageController::class);
        // });
    });
});
