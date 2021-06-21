<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientsController;
use App\Http\Controllers\ContractsController;
use App\Http\Controllers\EmailConfigController;
use App\Http\Controllers\EmailsController;
//use App\Http\Controllers\Contract_docController;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\OperationalsController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Progress_statusController;
use App\Http\Controllers\Projects_statusController;
use App\Http\Controllers\TypeController;
use App\Models\Email;

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

// Route::get('/', function () {
//     return view('welcome');
Route::get('/login',[AuthController::class, 'index'])->name('login');
Route::post('/login/api/ui', [AuthController::class, 'callapiusinglaravelui'])->name('loginui');
Route::get('/logout',[AuthController::class, 'logout'])->name('logout');

//user
Route::get('/user-profile',[AuthController::class, 'userProfile'])->middleware('authapi')->name('profile');

Route:: view('/operationals','v_operational')->middleware('authapi');
Route::resource('/',ClientsController::class)->middleware('authapi');
// Route::resource('/',[ClientsController::class]);
Route::resource('/contracts',ContractsController::class)->middleware('authapi');
Route::get('/contracts/{contract}/ammend', [ContractsController::class, 'ammend'])->middleware('authapi');
Route::put('/contracts/{contract}', [ContractsController::class, 'upammend'])->middleware('authapi');
Route::post('/contract_doc/{contract_doc}', [ContractsController::class, 'destroyDoc'])->middleware('authapi');

Route::resource('/projects', ProjectsController::class)->middleware('authapi');
Route::get('/projects/{project}/ammend', [ProjectsController::class, 'ammend'])->middleware('authapi');
Route::put('/projects/{project}', [ProjectsController::class, 'upammend'])->middleware('authapi');
Route::post('/progress_item/{progress_item}', [ProjectsController::class, 'destroyItem'])->middleware('authapi');
Route::post('/project_cost/{project_cost}', [ProjectsController::class, 'destroyCost'])->middleware('authapi');

Route::resource('/operationals', OperationalsController::class)->middleware('authapi');
Route::post('/progress_doc', [OperationalsController::class, 'uploadProgress'])->middleware('authapi');
Route::get('/changestatus/{changestatus}', [OperationalsController::class, 'changeStatus'])->middleware('authapi');
Route::get('/progress_doc/{progress_doc}', [OperationalsController::class, 'destroyDoc'])->middleware('authapi');

Route::resource('/projects_status', Projects_statusController::class)->middleware('authapi');

Route::resource('/payments', PaymentController::class)->middleware('authapi');

//config
Route::middleware(['authapi','admin'])->group(function () {
    Route::resource('/progress_status', Progress_statusController::class)->middleware('authapi');
    Route::resource('/email', EmailsController::class)->middleware('authapi');
    Route::resource('/email_configuration', EmailConfigController::class)->middleware('authapi');
    Route::resource('/types', TypeController::class)->middleware('authapi');
    Route::get('/send-mail',[EmailsController::class,'sendMail']);
});
