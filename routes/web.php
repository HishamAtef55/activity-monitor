<?php

use App\Http\Middleware\LogRequests;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('posts')->as('posts.')

        ->controller(PostController::class)->group(function () {

            Route::get('/', 'index')->name('index')
                ->middleware('permission:posts-list');

            Route::get('/create', 'create')->name('create')
                ->middleware('permission:posts-create');

            Route::post('/', 'store')->name('store')
                ->middleware('permission:posts-create');

            Route::prefix('/{post}')->group(function () {

                Route::get('/edit', 'edit')->name('edit')
                    ->middleware('permission:posts-update');

                Route::put('/', 'update')->name('update')
                    ->middleware('permission:posts-update');

                Route::delete('/', 'destroy')->name('destroy')
                    ->middleware('permission:posts-delete');
            });
        });



    Route::prefix('settings')->as('settings.')

        ->controller(SettingController::class)->group(function () {

            Route::get('/', 'index')->name('list')
                ->middleware('permission:settings-list');


            Route::put('/', 'update')->name('update')
                ->middleware('permission:settings-update');
        });


    Route::prefix('roles')->as('roles.')

        ->controller(RoleController::class)->group(function () {

            Route::put('{role}/toggle-idle-monitoring', '__invoke')->name('toggle-idle-monitoring');
        });

    Route::prefix('employees')->as('employees.')

        ->controller(EmployeeController::class)->group(function () {

            Route::get('/', '__invoke')->name('index')
                ->middleware('permission:employees-list');
    });
    
    Route::post('/logout-inactive', [AuthenticatedSessionController::class, 'logoutInactivity'])->name('logout-inactive');
});                                                                                                                                        

require __DIR__ . '/auth.php';  
