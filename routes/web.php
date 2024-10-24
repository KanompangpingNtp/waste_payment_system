<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\BillController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminbillController;
use App\Http\Controllers\AdminshowbilluserController;
use App\Http\Controllers\AdminManageUsersController;


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

// Route::get('/', function () {
//     return view('welcome');
// });

//login-register
Route::get('/showRegistrationForm', [AuthController::class, 'showRegistrationForm'])->name('showRegistrationForm');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::get('/', [AuthController::class, 'showLoginForm'])->name('showLoginForm');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

//user
Route::get('/showUserindex', [UsersController::class, 'showUserindex'])->name('showUserindex')->middleware('checkIfLoggedIn');

//bills
Route::get('/showBillindex', [BillController::class, 'showBillindex'])->name('showBillindex')->middleware('checkIfLoggedIn');
Route::post('/bills/pay/{bill}', [BillController::class, 'pay'])->name('bills.pay');

//payment
Route::get('/payments', [PaymentController::class, 'showPaidBills'])->name('showPaidBills')->middleware('checkIfLoggedIn');

//admin
Route::get('/showAdminindex', [AdminController::class, 'showAdminindex'])->name('showAdminindex')->middleware('checkIfLoggedIn');

//admin manage bills
Route::get('/showAdminBills', [AdminbillController::class, 'showAdminBills'])->name('showAdminBills')->middleware('checkIfLoggedIn');
Route::put('/EditAdminBills/{id}', [AdminbillController::class, 'EditAdminBills'])->name('EditAdminBills')->middleware('checkIfLoggedIn');
Route::delete('/EditAdminDelete/{id}', [AdminbillController::class, 'EditAdminDelete'])->name('EditAdminDelete')->middleware('checkIfLoggedIn');
Route::post('/admin/bills/create', [AdminbillController::class, 'AdminbillsCreate'])->name('AdminbillsCreate')->middleware('checkIfLoggedIn');

//admin bills
Route::get('/showAdminBillindex', [AdminshowbilluserController::class, 'showAdminBillindex'])->name('showAdminBillindex')->middleware('checkIfLoggedIn');
Route::get('/admin/user/{userId}/bills', [AdminshowbilluserController::class, 'showUserBills'])->name('showUserBills')->middleware('checkIfLoggedIn');

//admin approve bills
Route::get('/showApproveBills', [AdminbillController::class, 'showApproveBills'])->name('showApproveBills')->middleware('checkIfLoggedIn');
Route::put('/approveBill/{bill}', [AdminbillController::class, 'approveBill'])->name('approveBill')->middleware('checkIfLoggedIn');
Route::delete('/bills/{bill_id}/delete', [AdminbillController::class, 'deleteBill'])->name('deleteBill')->middleware('checkIfLoggedIn');

//Admin Manage Users
Route::get('/showAdminManageUsers', [AdminManageUsersController::class, 'showAdminManageUsers'])->name('showAdminManageUsers')->middleware('checkIfLoggedIn');
Route::post('/admin-create-user', [AdminManageUsersController::class, 'createUser'])->name('createUser');
Route::put('/admin-edit-user/{id}', [AdminManageUsersController::class, 'editUser'])->name('editUser');
Route::delete('/admin-delete-user/{id}', [AdminManageUsersController::class, 'deleteUser'])->name('deleteUser');
