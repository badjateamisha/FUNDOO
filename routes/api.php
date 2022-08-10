<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CacheController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Api\AuthController;
use App\Models\User;
use App\Models\Contact;
use App\Models\notes;
use App\Models\lable;
use App\Models\PasswordReset;
use App\Http\Controllers\LableController;
use App\Http\Controllers\NotesController;
use App\Http\Controllers\VerificationController;
use Illuminate\support\Facades\JWTAuth;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
//Route::middleware(['auth:sanctum'])->group(function(){

Route::post('create',[ContactController::class,'store']);
Route::get('display',[ContactController::class,'display']);
Route::get('display/{id}',[ContactController::class,'display_by_id']);
Route::Put('updatebyID/{id}', [ContactController::class, 'update_by_id']);
Route::post('updatebyID/{id}', [ContactController::class, 'update_by_id']);
Route::Delete('deletebyID/{id}',[ContactController::class,'delete_by_id']);
//});
Route::post('changePassword',[ContactController::class,'changePassword']);
Route::post('forgotPassword',[ContactController::class,'forgotPassword']);
Route::post('resetPassword',[ContactController::class,'resetPassword']);


Route::post('CreateNotes',[NotesController::class,'CreateNotes']);
Route::get('displayNotes',[NotesController::class,'displayNotes']);
Route::get('displayNotes/{id}',[NotesController::class,'displayNotes_ID']);
Route::put('updateNotes/{id}',[NotesController::class,'updateNotes_ID']);
Route::post('updateNotes/{id}',[NotesController::class,'updateNotes_ID']);
Route::delete('deleteNotes/{id}',[NotesController::class,'deleteNotes_ID']);


Route::post('CreateLable',[LableController::class,'CreateLable']);
Route::get('displayLable',[LableController::class,'displayLable']);
Route::get('displayLable/{id}',[LableController::class,'displayLable_ID']);
Route::put('updateLable/{id}',[LableController::class,'updateLable_ID']);
Route::post('updateLable/{id}',[LableController::class,'updateLable_ID']);
Route::delete('deleteLable/{id}',[LableController::class,'deleteLable_ID']);

Route::post('jointables',[LableController::class,'JoinTables']);

Route::get('getUser',[CacheController::class, 'getUser']);
Route::get('getNotes',[CacheController::class, 'getNotes']);
Route::get('getLable',[CacheController::class, 'getLable']);
Route::get('getJoinNotesLable',[CacheController::class, 'getJoinNotesLable']);

Route::post('registration', [AuthController::class, 'newregister']);
Route::post('login', [AuthController::class, 'login']);
// Route::middleware('auth:api')->group(function(){
//     Route::get('get-user',[UserController::class,'userInfo']);
//     //Route::get('',[NotesandlabelController::class,'addToNotes']);
// });