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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login','API\PassportController@login')->name('user.login');
Route::post('register', 'API\PassportController@register')->name('user.register');
Route::post('resetPassword', 'API\PassportController@resetPassword')->name('user.resetPassword');
Route::post('storegame', 'HistoryController@storegame')->name('user.storegame');
Route::post('storequestionnaire', 'HistoryController@storequestionnaire')->name('user.storequestionnaire');
Route::post('gameslist', 'HistoryController@gameslist')->name('user.gameslist');
Route::post('questionnaireslist', 'HistoryController@questionnaireslist')->name('user.questionnaireslist');
Route::post('previousgameresult', 'HistoryController@previousgameresult')->name('user.previousgameresult');
Route::post('updategameresult/{id}', 'HistoryController@updategameresult')->name('user.updategameresult');
Route::get('users', 'API\PassportController@users')->name('user.users');
Route::get('games', 'HistoryController@games')->name('user.games');
Route::get('questionnaires', 'HistoryController@questionnaires')->name('user.questionnaires');

Route::group(['middleware' => 'auth:api'], function(){
Route::get('user', 'API\PassportController@user')->name('user.user');
Route::get('logout', 'API\PassportController@logout')->name('user.logout');
Route::post('changePassword', 'API\PassportController@changePassword')->name('user.changePassword');
Route::post('changeProfile', 'API\PassportController@changeProfile')->name('user.changeProfile');
});
