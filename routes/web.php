<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


///User registration Section ///

Route::get('/registerdetails', [App\Http\Controllers\AccountController::class, 'getRegisterForm'])->name('regAccount');

Route::post('/registerdetails', [App\Http\Controllers\AccountController::class, 'saveUserdetails'])->name('completeregister');



///Managing Requests section ///
Route::post('/displayAnimals', [App\Http\Controllers\AdoptionRequestController::class, 'processAdoptionRequest'])->name('adoptionRequest');

Route::get('/ManageAdoptionRequest/{id}', [App\Http\Controllers\AdoptionRequestController::class, 'adoptionRequestsManagerForm'])->name('manageAdoptionRequests');

Route::post('/ManageAdoptionRequest/modify', [App\Http\Controllers\AdoptionRequestController::class, 'modifyAdoptionStatus'])->name('modifyStatus');


///Uploading animal and picture section ///
Route::get('/upload-animal', [App\Http\Controllers\AnimalController::class, 'uploadAnimal'])->name('uploadAnimal');

Route::post('/upload-animal', [App\Http\Controllers\AnimalController::class, 'animaldataUpload'])->name('animaldata');

Route::get('/upload-file/{id}', [App\Http\Controllers\AnimalController::class, 'animalImageForm'])->name('imagesform');

Route::post('/upload-file', [App\Http\Controllers\AnimalController::class, 'fileUpload'])->name('fileUpload');



///Display animals Section ///

Route::get('/MyAnimals', [App\Http\Controllers\AccountController::class, 'showAnimals'])->name('showMyAnimals');

Route::get('/displayAnimals', [App\Http\Controllers\AccountController::class, 'displayAnimals'])->name('displayAnimals');

