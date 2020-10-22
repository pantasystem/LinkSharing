<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:api')->group(function() {
    Route::post('notes', 'NotesController@create');
    Route::delete('notes/{noteId}', 'NotesController@delete');
    Route::get('notes', 'NotesController@timeline');

    Route::put('notes/{noteId}/favorites', 'FavoritesController@favorite');
    Route::delete('notes/{noteId}/favorites', 'FavoritesController@unfavorite');
    Route::get('notes/{noteId}/favorites/my-favorite', 'FavoritesController@isFavorited');

    Route::put('users/{userId}', 'UsersController@follow');
    Route::delete('users/{userId}', 'UsersController@unfollow');


});
Auth::routes();


Route::get('notes/{noteId}', 'NotesController@get');

Route::get('users/{userId}', 'UsersController@get');

Route::get('users/{userId}/notes', 'UserController@notes');

Route::get('tags/{name?}', 'TagsController@search');

Route::post('notes/search-by-tag', 'NotesController@searchByTag');

Route::get('notes/{noteId}/favorites', 'FavoritesController@favorites');









