<?php

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

// Get

Route::get('/', 'MainController@GetIndex');
Route::get('/index', 'MainController@GetIndex');
Route::get('/about', 'MainController@GetAbout');
Route::get('/contact', 'MainController@GetContact');

Route::get('/login', 'MainController@GetLogin');
Route::get('/activation', 'MainController@GetActivation');
Route::get('/register', 'MainController@GetRegister');
Route::get('/reset', 'MainController@GetReset');
Route::get('/renew', 'MainController@GetRenew');
Route::get('/logout', 'MainController@GetLogout');

Route::get('/profile', 'MainController@GetProfile');
Route::get('/settings', 'MainController@GetSettings');
Route::get('/messages', 'MainController@GetMessages');
Route::get('/send-m', 'MainController@GetSendM');
Route::get('/send-r', 'MainController@GetSendR');
Route::get('/create-announcement', 'MainController@GetCreateAnno');
Route::get('/announcements', 'MainController@GetAnno');
Route::get('/user', 'MainController@GetUser');
Route::get('/appointments', 'MainController@GetAppo');
Route::get('/appointment', 'MainController@GetCanAppo');
Route::get('/rate-appointment', 'MainController@GetRatAppo');
Route::get('/find-pair', 'MainController@GetFindPair');

////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////

// Post

Route::post('/register', 'MainController@PostRegister');
Route::post('/login', 'MainController@PostLogin');
Route::post('/reset', 'MainController@PostReset');
Route::post('/renew', 'MainController@PostRenew');
Route::post('/contact', 'MainController@PostContact');

Route::post('/profile', 'MainController@PostProfile');
Route::post('/settings', 'MainController@PostSettings');
Route::post('/messages', 'MainController@PostMessages');
Route::post('/send-m', 'MainController@PostSendM');
Route::post('/send-r', 'MainController@PostSendR');
Route::post('/create-announcement', 'MainController@PostCreateAnno');
Route::post('/announcements', 'MainController@PostAnno');
Route::post('/appointments', 'MainController@PostAppo');
Route::post('/appointment', 'MainController@PostCanAppo');
Route::post('/rate-appointment', 'MainController@PostRatAppo');
Route::post('/find-pair', 'MainController@PostFindPair');





































