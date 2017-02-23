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
Route::post('jobs/{id}/star', 'JobsController@star');
Route::post('jobs/{id}/unstar', 'JobsController@unstar');
Route::resource('jobs', 'JobsController', ['only' => ['index', 'show']]);
Route::resource('jobs.records', 'Jobs\RecordsController', ['only' => ['index']]);
Route::resource('companies', 'CompaniesController', ['only' => ['index', 'show']]);
Route::resource('records', 'RecordsController', ['only' => ['index', 'show']]);
Route::resource('companies.jobs', 'Companies\JobsController', ['only' => ['index']]);
Route::resource('leads', 'LeadsController', ['only' => ['index', 'show', 'store']]);

