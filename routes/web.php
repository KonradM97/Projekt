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
    return view('player');
});

Route::get('/profile','UserController@profile')->name('profile');
Route::post('/profile', 'UserController@update_avatar');
Auth::routes();
//Kontroler profilu home
Route::post('/addAlbum','HomeController@addAlbum');
Route::post('/addPlaylist','HomeController@addPlaylist');
Route::post('/addSong','HomeController@addSong');
Route::get('/home', 'HomeController@index')->name('home');
//kontroler Wyszukiwania
Route::get('/search', 'SearchController@search');
//kontroler polubień z odtwarzacza
Route::post('/like', ['uses' => 'PostController@likePost',
    'as'=> 'like']);
//profil
Route::get('/user={id}', 'UserController@profile')->name('user.profile');