<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\FavoritesController;
use App\Http\Controllers\NotesController;
use App\Http\Controllers\TagsController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\CommentController;

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

    Route::post('notes/{noteId}/comments', [CommentController::class, 'replyToNote']);
    // Route::post('notes/{noteId}/comments/{commentId}', [CommentController::class, 'replyToComment']);
    Route::delete('notes/{noteId}/comments/{commentId}', [CommentController::class, 'delete']);



});
Auth::routes();



Route::get('notes/{noteId}', [NotesController::class, 'get']);

Route::get('users/followers-count-ranking', [UsersController::class, 'followerCountsRanking']);


Route::get('users/{userId}', [UsersController::class, 'get']);


Route::get('users/{userId}/notes', [UsersController::class, 'notes']);

Route::get('users/{userId}/favorites', [UsersController::class, 'favoriteNotes']);

Route::get('users/{userId}/followers', [UsersController::class, 'followers']);

Route::get('users/{userId}/followings', [UsersController::class, 'followings']);

Route::get('tags/{name?}', [TagsController::class, 'search']);

Route::post('notes/search-by-tag', [NotesController::class, 'searchByTag']);

Route::get('notes/{noteId}/favorites', [FavoritesController::class, 'favorites']);


Route::get('notes/{noteId}/comments', [CommentController::class, 'findAllByNote']);
//Route::get('notes/{noteId}/comments/{commentId}/all', [CommentController::class, 'findAllByNoteAndCommentId']);

Route::get('notes/{noteId}/comments/{commentId}', [CommentController::class, 'show']);
















