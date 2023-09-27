<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\FolderController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\FevouriteController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth:api'])->group(function () {
    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/store-user', [AuthController::class, 'store_user']);
    Route::post('/update-user/{id?}', [AuthController::class, 'update_user'])->middleware('isAdmin');
    /**
     * Documents
     */
    Route::get('document', [DocumentController::class, 'index']);
    Route::post('document/store', [DocumentController::class, 'store'])->middleware('isAdminOrEditor');
    Route::post('document/update/{document}', [DocumentController::class, 'update'])->middleware('isAdminOrEditor');
    Route::get('document/delete/{document}', [DocumentController::class, 'destroy'])->middleware('isAdminOrEditor');

    /**
     * Folder
     */
    Route::get('folder', [FolderController::class, 'index']);
    Route::post('folder/store', [FolderController::class, 'store'])->middleware('isAdminOrEditor');
    Route::get('folder/show/{folder}', [FolderController::class, 'show']);
    Route::post('folder/update/{folder}', [FolderController::class, 'update'])->middleware('isAdminOrEditor');
    Route::get('folder/delete/{folder}', [FolderController::class, 'destroy'])->middleware('isAdminOrEditor');

    /**
     * Tags
     */
    Route::get('tag', [TagController::class, 'index']);
    Route::post('tag/store', [TagController::class, 'store'])->middleware('isAdminOrEditor');
    Route::get('tag/show/{tag}', [TagController::class, 'show']);
    Route::post('tag/update/{tag}', [TagController::class, 'update'])->middleware('isAdminOrEditor');
    Route::get('tag/delete/{tag}', [TagController::class, 'destroy'])->middleware('isAdminOrEditor');

    /**
     * Fevourite
     */

    Route::get('fevourite', [FevouriteController::class, 'index']);
    Route::post('fevourite/store', [FevouriteController::class, 'store']);
});
