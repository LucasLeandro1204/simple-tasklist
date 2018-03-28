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

Route::middleware('bindings')->prefix('task')->group(function () {
    Route::get('/', 'TaskController@index')->name('task.index');
    Route::post('/', 'TaskController@store')->name('task.store');
    Route::get('/{task}', 'TaskController@show')->name('task.show');
    Route::put('{task}', 'TaskController@update')->name('task.update');
    Route::delete('{task}', 'TaskController@destroy')->name('task.delete');
});
