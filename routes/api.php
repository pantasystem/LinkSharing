<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\FavoritesController;
use App\Http\Controllers\NotesController;
use App\Http\Controllers\TagsController;
use App\Http\Controllers\UsersController;

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

Route::middleware('auth:web')->get('/user', function (Request $request) {
    return $request->user();
});


Route::middleware('auth:web')->group(function() {
Route::get('me', [HomeController::class, 'me']);

    Route::post('notes', [NotesController::class, 'create']);
    Route::get('notes', [NotesController::class, 'timeline']);

    Route::delete('notes/{noteId}', [NotesController::class, 'delete']);

    Route::put('notes/{noteId}/favorites', [FavoritesController::class, 'favorite']);
    Route::delete('notes/{noteId}/favorites', [FavoritesController::class, 'unfavorite']);
    Route::get('notes/{noteId}/favorites/my-favorite', [FavoritesController::class, 'isFavorited']);

    Route::put('users/{userId}', [UsersController::class, 'follow']);
    Route::delete('users/{userId}', [UsersController::class, 'unfollow']);


});
Auth::routes();



Route::get('notes/{noteId}', [NotesController::class, 'get']);

Route::get('users/followers-count-ranking', [UsersController::class, 'followerCountsRanking']);


Route::get('users/{userId}', [UsersController::class, 'get']);


Route::get('users/{userId}/notes', [UsersController::class, 'notes']);

Route::get('users/{userId}/favorites', [UsersController::class, 'favoriteNotes']);

Route::get('tags/{name?}', [TagsController::class, 'search']);

Route::post('notes/search-by-tag', [NotesController::class, 'searchByTag']);

Route::get('notes/{noteId}/favorites', [FavoritesController::class, 'favorites']);









