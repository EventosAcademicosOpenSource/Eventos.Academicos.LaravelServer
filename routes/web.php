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
// if (getenv('FORCE_SSL')) {
//     URL::forceScheme('https');
// };
Route::get('/', function () {
    return view('welcome');
});

Route::prefix('admin')->group(function(){
    Auth::routes();
    Route::get('/home', 'HomeController@index')->name('home');
    
    Route::group(['as'=> 'admin.', 'namespace' => 'Admin\\'],function(){
        Route::name('palestrantes.search')->get('/palestrantes/search', 'SpeakerController@search');
        Route::name('patrocinadores.search')->get('/patrocinadores/search', 'SponsorController@search');
        Route::name('eventos.search')->get('/eventos/search', 'EventController@search');
        Route::resource('/palestrantes', 'SpeakerController', ['except' => ['show']]);
        Route::resource('/patrocinadores', 'SponsorController', ['except' => ['show']]);
        Route::resource('/eventos', 'EventController', ['except' => ['show']]);
        Route::name('eventChildren.index')->get('/eventos/{id}/palestras', 'EventChildrenController@index');
        Route::name('eventChildren.create')->get('/eventos/{id}/palestras/create', 'EventChildrenController@create');
        Route::name('eventChildren.edit')->get('/eventos/{idEvent}/palestras/{id}/edit', 'EventChildrenController@edit');
        Route::name('eventChildren.store')->post('/eventos/palestras/', 'EventChildrenController@store');
        Route::name('eventChildren.destroy')->delete('/eventos/palestras/{id}', 'EventChildrenController@destroy');
        Route::name('eventChildren.update')->put('/eventos/palestras/{id}', 'EventChildrenController@update');
        
        Route::name('eventChildrenNoSpeaker.index')->get('/eventos/{id}/integrantes', 'EventChildrenNoSpeakerController@index');
        Route::name('eventChildrenNoSpeaker.create')->get('/eventos/{id}/integrantes/create', 'EventChildrenNoSpeakerController@create');
        Route::name('eventChildrenNoSpeaker.edit')->get('/eventos/{idEvent}/integrantes/{id}/edit', 'EventChildrenNoSpeakerController@edit');
        Route::name('eventChildrenNoSpeaker.store')->post('/eventos/integrantes/', 'EventChildrenNoSpeakerController@store');
        Route::name('eventChildrenNoSpeaker.destroy')->delete('/eventos/integrantes/{id}', 'EventChildrenNoSpeakerController@destroy');
        Route::name('eventChildrenNoSpeaker.update')->put('/eventos/integrantes/{id}', 'EventChildrenNoSpeakerController@update');
        
        Route::name('eventSponsors.index')->get('/eventos/{id}/patrocinador', 'EventSponsorController@index');
        Route::name('eventSponsors.destroy')->delete('/eventos/patrocinador/{id}/{idPatrocinador}', 'EventSponsorController@destroy');
        Route::name('eventSponsors.store')->post('/eventos/patrocinador/', 'EventSponsorController@store');

        Route::name('notification.index')->get('/eventos/{id}/notificacoes', 'NotificationController@index');
        Route::name('notification.store')->post('/eventos/notificacao/', 'NotificationController@store');
        
        Route::name('user.index')->get('/acount/', 'UsersPreferenceController@index');
        Route::name('user.update')->put('/acount/edit/', 'UsersPreferenceController@update');
        Route::name('users.index')->get('/usuarios/', 'UsersController@index');
        Route::name('users.create')->get('/usuarios/create', 'UsersController@create');
        Route::name('users.store')->post('/usuarios/', 'UsersController@store');
        Route::name('users.edit')->get('/usuarios/{id}/edit/', 'UsersController@edit');
        Route::name('users.update')->put('/usuarios/{id}', 'UsersController@update');
        Route::name('users.destroy')->delete('/usuarios/{id}', 'UsersController@destroy');
    });
});

