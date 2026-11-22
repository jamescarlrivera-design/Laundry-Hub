<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LaundryRequestController;
use App\Http\Controllers\RequestItemController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\BranchController;


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
});



Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::resource('branches', BranchController::class);

    });


Route::middleware(['auth', 'role:staff'])
    ->prefix('staff')
    ->name('staff.')
    ->group(function () {

        Route::get('/dashboard', function () {
            return view('staff.dashboard');
        })->name('dashboard');

        Route::patch(
            '/requests/{laundryRequest}/status',
            [LaundryRequestController::class, 'staffupdate']
        )->name('requests.update-status');


        Route::get('/requests', [LaundryRequestController::class, 'staffindex'])
            ->name('requests.index');

        Route::get('/requests/{request}', [LaundryRequestController::class, 'staffShow'])
            ->name('requests.show');


        


    });


Route::middleware(['auth', 'role:customer'])
    ->prefix('customer')
    ->name('customer.')
    ->group(function () {
        //to show requests order
        Route::get('/requests/create', [LaundryRequestController::class, 'customercreate'])
            ->name('requests.create');


        Route::get('/requests', [LaundryRequestController::class, 'customerindex'])
            ->name('requests.index');

        Route::get('/requests/{laundryRequest}', [LaundryRequestController::class, 'customershow'])
            ->name('requests.show');

        Route::post('/requests', [LaundryRequestController::class, 'customerstore'])
            ->name('requests.store');
        // end 
    
        //Requests items
        Route::get(
            '/requests/{laundryRequest}/items',
            [RequestItemController::class, 'index']
        )->name('requests.items.index');

        Route::get(
            '/requests/{laundryRequest}/items/{item}',
            [RequestItemController::class, 'show']
        )->name('requests.items.show');

        Route::post(
            '/requests/{laundryRequest}/items',
            [RequestItemController::class, 'store']
        )->name('requests.items.store');
        //end
    

        // view branches
        Route::get('/branches', [BranchController::class, 'customerindex'])
            ->name('branches.index');

        Route::get(
            '/branches/{branch}/services',
            [LaundryRequestController::class, 'branchServices']
        )->name('branches.services');

        // for view services 
        Route::get('/services', [ServiceController::class, 'customerIndex'])
            ->name('services.index');






    });

Route::middleware('auth')->group(function () {
    Route::post(
        '/laundry-requests',
        [LaundryRequestController::class, 'store']
    )->name('laundry-requests.store');
});

require __DIR__ . '/auth.php';
