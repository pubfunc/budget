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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::resource('organization', 'OrganizationController')->middleware(['auth']);

Route::group(['prefix' => 'org/{organization}', 'middleware' => ['auth', 'context']], function(){


    Route::resource('account', 'AccountController');
    Route::resource('transaction', 'TransactionController');

    Route::get('/statement', 'StatementController@index')->name('statement.index');
    Route::get('/statement/upload', 'StatementController@uploader')->name('statement.uploader');
    Route::post('/statement/upload', 'StatementController@upload')->name('statement.upload');
    Route::get('/statement/{id}', 'StatementController@preview')->name('statement.preview');
    Route::delete('/statement/{id}', 'StatementController@destroy')->name('statement.destroy');
    Route::delete('/statement/{id}/download', 'StatementController@download')->name('statement.download');

});
