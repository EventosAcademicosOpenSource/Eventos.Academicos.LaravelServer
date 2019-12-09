<?php

use Illuminate\Http\Request;

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

Route::post('register', 'Api\AuthController@register');

Route::middleware(['auth:api'])->group(function(){
    Route::get('/events', 'Api\ApiController@events');
    Route::get('/events/{id}', 'Api\ApiController@event');
    //notification /api/notification/{token}
    Route::name('api.notification.setToken')->post('/notification/{token}', 'Api\NotificationController@setTokenUser');
    Route::name('api.notification.setEvent')->post('/notification/event/set/{event}', 'Api\NotificationController@setEventNotification');
    Route::name('api.notification.unsetEvent')->post('/notification/event/unset/{event}', 'Api\NotificationController@unsetEventNotification');
});
Route::get('update-app', function(){
    return response(file_get_contents(public_path('update_app.xml')), 200, [
        'Content-Type' => 'application/xml'
    ]);
});