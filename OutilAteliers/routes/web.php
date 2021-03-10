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

Route::get('/', 'PublicController@accueil')->name('Accueil');;

Route::get('/404', function()
{
    return View::make('public.404');
})->name('404');

Route::get('/resetpassword/{token}', function ($token) {
    return view('public.accueil')->with('token', $token);
})->name('ResetLink');

Auth::routes();

Route::resource('ateliers', 'AteliersController');
Route::post('atelier_horaires/rappel','AtelierHorairesController@rappel')->name('atelier_horaires.rappel');;
Route::get('atelier_horaires/{atelier}/create', 'AtelierHorairesController@create')->name('atelier_horaires.create');
Route::resource('atelier_horaires', 'AtelierHorairesController')->except(['create']);
Route::resource('etablissements', 'EtablissementsController');
Route::post('inscriptions/{atelier_horaire}/store', 'InscriptionsController@store')->name('inscriptions.store');
Route::get('inscriptions/index/{atelier_horaire?}', 'InscriptionsController@index')->name('inscriptions.index');
Route::resource('inscriptions', 'InscriptionsController')->except(['create','store','index','edit','update','destroy','show']);;
Route::resource('programmes', 'ProgrammesController');
Route::get('users/edit/{user}/{profil?}', 'UsersController@edit')->name('users.edit');
Route::resource('users', 'UsersController')->except(['edit']);