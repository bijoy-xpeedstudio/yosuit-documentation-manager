<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\FolderController;
use App\Http\Controllers\TagController;
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
    Route::post('update-user/{id?}', [AuthController::class, 'update_user']);
    /**
     * Documents
     */
    Route::get('document', [DocumentController::class, 'index']);
    Route::post('document/store', [DocumentController::class, 'store']);
    Route::post('document/update/{document}', [DocumentController::class, 'update']);
    Route::get('document/delete/{document}', [DocumentController::class, 'destroy']);

    /**
     * Folder
     */
    Route::get('folder', [FolderController::class, 'index']);
    Route::post('folder/store', [FolderController::class, 'store']);
    Route::get('folder/show/{folder}', [FolderController::class, 'show']);
    Route::post('folder/update/{folder}', [FolderController::class, 'update']);
    Route::get('folder/delete/{folder}', [FolderController::class, 'destroy']);

    /**
     * Tags
     */
    Route::get('tag', [TagController::class, 'index']);
    Route::post('tag/store', [TagController::class, 'store']);
    Route::get('tag/show/{tag}', [TagController::class, 'show']);
    Route::post('tag/update/{tag}', [TagController::class, 'update']);
    Route::get('tag/delete/{tag}', [TagController::class, 'destroy']);

    Route::post('pivot', [FolderController::class, 'polyPivot']);
});
