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
    return view('startseite');
});

Route::get('/info', function () {
    return view('info');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//Route für Hobby - Type resource ist eine Abkürzung für alle 7 Funktionen des Controllers
Route::resource('hobby', 'HobbyController');

//Route für Tags 
Route::resource('tag', 'TagController');

//Route für User
Route::resource('user', 'UserController');

//Route für funktion Tags auflistung! {tag_id} ist nur ein Platzhalter für in dem FAll die ID!
Route::get('/hobby/tag/{tag_id}', 'hobbyTagController@getFilteredHobbies')->name('hobby_tag');

// Route für Tags bei Hobby hinzufügen
Route::get('/hobby/{hobby_id}/tag/{tag_id}/attach', 'hobbyTagController@attachTag');
// Route für Tags bei Hobby entfernen
Route::get('/hobby/{hobby_id}/tag/{tag_id}/detach', 'hobbyTagController@detachTag');

// Bilder vom Hobby löschen!
Route::get('/delete-image/hobby/{hobby_id}', 'HobbyController@deleteImages');

// Bilder vom User löschen!
Route::get('/delete-image/user/{user_id}', 'UserController@deleteImages');