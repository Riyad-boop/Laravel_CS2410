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


Route::get('/registerdetails', [App\Http\Controllers\AccountController::class, 'getRegisterForm'])->name('regAccount');

Route::post('/registerdetails', [App\Http\Controllers\AccountController::class, 'saveUserdetails'])->name('completeregister');



//

///Admin only section ///

Route::get('/ManageAdoptionRequest/{id}', [App\Http\Controllers\AccountController::class, 'adoptionRequestsManagerForm'])->name('manageAdoptionRequests');

Route::post('/ManageAdoptionRequest/modify', [App\Http\Controllers\AccountController::class, 'modifyAdoptionStatus'])->name('modifyStatus');


//upload animal 
Route::get('/upload-animal', [App\Http\Controllers\AnimalController::class, 'uploadAnimal'])->name('uploadAnimal');

Route::post('/upload-animal', [App\Http\Controllers\AnimalController::class, 'animaldataUpload'])->name('animaldata');

//upload animal image
Route::get('/upload-file/{id}', [App\Http\Controllers\AnimalController::class, 'createForm'])->name('imagesform');

Route::post('/upload-file', [App\Http\Controllers\AnimalController::class, 'fileUpload'])->name('fileUpload');


///////////////

//display animals
Route::get('/MyAnimals', [App\Http\Controllers\AccountController::class, 'showAnimals'])->name('showMyAnimals');

Route::get('/displayAnimals', [App\Http\Controllers\AccountController::class, 'displayAnimals'])->name('displayAnimals');

Route::post('/displayAnimals', [App\Http\Controllers\AccountController::class, 'processAdoptionRequest'])->name('adoptionRequest');
