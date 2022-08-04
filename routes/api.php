<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CacheController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Models\User;
use App\Models\notes;
use App\Models\lable;
use App\Http\Controllers\LableController;
use App\Http\Controllers\NotesController;
use App\Http\Controllers\VerificationController;

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

Route::post('/login', [UserController::class, 'login']);
Route::post('/register', [UserController::class, 'register']);
Route::post('/changepassword',[VerificationController::class,'changepassword'])->middleware('auth:api');
// Route::middleware('auth:api')->group(function(){
//     Route::get('get-user',[UserController::class,'userInfo']);
//     //Route::get('',[NotesandlabelController::class,'addToNotes']);
// });