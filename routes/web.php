<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CashierController;
use App\Http\Controllers\FDCashierController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ServiceController;
use App\Livewire\Cashier\Home\Home;
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

Route::get('/', function () {
    return view('welcome');
});

// Route::middleware([
//     'auth:sanctum',
//     config('jetstream.auth_session'),
//     'verified',
// ])->group(function () {
//     Route::get('/dashboard', function () {
//         return view('dashboard');
//     })->name('dashboard');
// });

// Route::get('/home', [HomeController::class, 'redirect']);
Route::get('/home', [AdminController::class, 'index'])->name('home');


// user
Route::get('/user/get-in-queue', function(){
    return view('user.get-in-queue');
})->name('get-in-queue');
Route::get('/user/about-us', function(){
    return view('user.about-us');
})->name('about-us');
Route::get('/user/contact-us', function(){
    return view('user.contact-us');
})->name('contact-us');
Route::get('/user/queue-history', function(){
    return view('user.queue-history');
})->name('queue-history');

// admin
Route::get('/admin/home', function(){
    return view('admin.home');
})->name('admin-home');
Route::get('/admin/reports', function(){
    return view('admin.reports');
})->name('admin-reports');
Route::get('/admin/monitor', function(){
    return view('admin.monitor');
})->name('admin-monitor');
Route::get('/admin/help', function(){
    return view('admin.help');
})->name('admin-help');

Route::get('/admin/accounts', function(){
    return view('admin.accounts');
})->name('admin-accounts');

// admin accounts links
Route::get('/admin/accounts/create-user', function(){
    return view('admin.accounts.create-user');
})->name('admin-create-user');
Route::get('/admin/accounts/manage-user', [AdminController::class, 'manageUserView'])->name('admin-manage-user');
Route::post('/admin/accounts/create-user/create', [AdminController::class,  'createUser'])->name('admin.create-user');
Route::post('/admin/accounts/manage-user/edit', [AdminController::class,  'manageUser'])->name('admin.manage-user');

// Edit user form
Route::get('/admin/users/{id}/edit', [AdminController::class, 'editUser'])->name('admin-edit-user');

// Update user
Route::put('/admin/users/{id}', [AdminController::class, 'updateUser'])->name('admin-update-user');

// delete user
Route::delete('/admin/users/{id}', [AdminController::class, 'deleteUser'])->name('admin-delete-user');
// end admin accounts links





// admin  windows links
// windows view 
Route::get('/admin/windows', [AdminController::class,  'windowsView'])->name('admin-windows');
// Edit a window
Route::get('/admin/windows/{id}/edit', [AdminController::class, 'editWindow'])->name('admin-edit-windows');

// windows add form
Route::get('/admin/windows/add-windows', [AdminController::class, 'addWindows'])->name('admin-add-windows');
// routes/web.php
Route::post('/admin/windows/store', [AdminController::class, 'storeWindow'])->name('admin.store-window');
// Delete a window
Route::delete('/admin/windows/{id}', [AdminController::class, 'deleteWindow'])->name('admin-delete-windows');
// Update an existing window
Route::put('/admin/windows/{id}', [AdminController::class, 'updateWindow'])->name('admin-update-window');











// admin service  links
// Admin Services
Route::middleware(['auth', 'is_admin'])->group(function () {
    Route::get('/admin/services', function () {
        return view('admin.services.index');
    })->name('admin-view-services');
});

// View all services
Route::get('/admin/services', [AdminController::class, 'viewServices'])->name('admin-view-services');

// Create a new service
Route::get('/admin/services/create', [AdminController::class, 'createService'])->name('admin-add-services');

// Store a new service
Route::post('/admin/services', [AdminController::class, 'storeService'])->name('admin-store-services');

// Edit an existing service
Route::get('/admin/services/{id}/edit', [AdminController::class, 'editService'])->name('admin-edit-service');

// Update an existing service
Route::put('/admin/services/{id}', [AdminController::class, 'updateService'])->name('admin-update-service');



// Delete a service
Route::delete('/admin/services/{id}', [AdminController::class, 'deleteService'])->name('admin-delete-service');

// admin queues
Route::get('/admin/queues', [AdminController::class, 'viewQueue'])->name('admin-view-queue');





// * cashier links

// Cashier home dashboard
Route::get('/cashier/home', [CashierController::class, 'index'])->name('cashier-index');

// cashier queues links
Route::get('/cashier/queue', [CashierController::class, 'showQueue'])->name('cashier-queue');

// cashier reports links
Route::get('/cashier/reports', [CashierController::class, 'showReports'])->name('cashier-reports');

// cashier reports links
Route::get('/cashier/reports', [CashierController::class, 'showReports'])->name('cashier-reports');

// cashier reports links
Route::get('/cashier/reports', [CashierController::class, 'showReports'])->name('cashier-reports');
















// * Front desk cashier links

// Cashier home dashboard
Route::get('/fdcashier/home', [FDCashierController::class, 'index'])->name('fdcashier-index');

// cashier queues links
Route::get('/fdcashier/queue', [FDCashierController::class, 'showQueue'])->name('fdcashier-queue');

// cashier walk ins links
Route::get('/fdcashier/walkin', [FDCashierController::class, 'walkIn'])->name('fdcashier-walkin');
// cashier walk ins links
Route::get('/fdcashier/walkin/create', [FDCashierController::class, 'createwalkIn'])->name('fdcashier-walkin-create');

Route::post('/fdcashier/walkin/store', [FDCashierController::class, 'storeWalkIn'])->name('fdcashier-walkin-store');




// Front desk cashier accounts page
Route::get('/fdcashier/accounts', [FDCashierController::class, 'showAcc'])->name('fdcashier-accounts');


// cashier add accounts links
Route::get('/fdcashier/accounts/create', [FDCashierController::class, 'createAcc'])->name('fdcashier-accounts-create');
// cashier add accounts links
Route::post('/fdcashier/accounts/store', [FDCashierController::class, 'storeAcc'])->name('fdcashier-accounts-store');
// cashier add accounts links
Route::get('/fdcashier/accounts/{id}/edit', [FDCashierController::class, 'editAcc'])->name('fdcashier-accounts-edit');
// update
Route::put('/fdcashier/accounts/{id}', [FDCashierController::class, 'updateAcc'])->name('fdcashier-accounts-update');


// Route for deleting an account
Route::delete('/fdcashier/accounts/{id}', [FDCashierController::class, 'deleteAcc'])->name('fdcashier-accounts-delete');



// cashier reports links
Route::get('/fdcashier/reports', [FDCashierController::class, 'showReports'])->name('fdcashier-reports');

// cashier monitor links
Route::get('/fdcashier/monitor', [FDCashierController::class, 'monitor'])->name('fdcashier-monitor');


