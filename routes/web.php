<?php

use App\Http\Controllers\HomeController;
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

Route::get('/profile','UserController@profile')->name('profile');//Pobierz dane i wyswietl profil użytkownika

Auth::routes();//Routing opcji rejestracji i logowania
//Kontroler panelu użytkownika
Route::post('/home', 'HomeController@update_avatar');//Zmień awatar
Route::post('/addAlbum','HomeController@addAlbum');//Dodanie albumu w panelu
Route::post('/addPlaylist','HomeController@addPlaylist');//Playlisty -||-
Route::post('/addSong','HomeController@addSong');//Utworu
Route::post('/changeName', 'HomeController@changeName');
//Zmiana hasła
Route::get('change-password', 'ChangePasswordController@index');
Route::post('change-password', 'ChangePasswordController@store')->name('change.password');
Route::get('/home', 'HomeController@index')->name('home');
//Kontroler wiadomości
Route::get('/messages','MessagesController@mymessages')->name('messages');
//kontroler Wyszukiwania
Route::get('/search', 'SearchController@search');
//kontroler polubień z odtwarzacza
Route::post('/like', ['uses' => 'PostController@likePost',
    'as'=> 'like']);
//kontroler followu
Route::post('/follow', ['uses' => 'PostController@followPost',
    'as'=> 'follow']);//Prześli dane do funkcji followPost kontrolera PostController
//Kontroler wiadomości
Route::get('/sendmessage', ['uses' => 'PostController@sendMessage',
'as'=> 'sendmessage']);
//Usuwanie wiadomości
Route::get('/deletemessage', ['uses' => 'PostController@deleteMessage',
'as'=> 'deletemessage']);
//Usuwanie
Route::get('/deletesong', ['uses' => 'PostController@deleteSong',
'as'=> 'deletesong']);
Route::get('/deletealbum', ['uses' => 'PostController@deleteAlbum',
'as'=> 'deletealbum']);
Route::get('/deleteplaylist', ['uses' => 'PostController@deletePlaylist',
'as'=> 'deleteplaylist']);
Route::get('/deleteuser', ['uses' => 'PostController@deleteUser',
'as'=> 'deleteUser']);

//profil
Route::get('/user={id}', 'UserController@profile')->name('user.profile');
//Dodanie playlisty
Route::get('/addtoplaylist',['uses' => 'PostController@addplaylist',
'as' => 'addplaylist']);

?>