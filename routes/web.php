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

Route::get('org', 'OrganizationController@index')
    ->name('organization.index')
    ->middleware(['auth']);

Route::get('org/create', 'OrganizationController@create')
    ->name('organization.create')
    ->middleware(['auth']);

Route::post('org', 'OrganizationController@store')
    ->name('organization.store')
    ->middleware(['auth']);

Route::get('org/{organization}', 'OrganizationController@show')
    ->name('organization.show')
    ->middleware(['auth', 'context']);

Route::get('org/{organization}/edit', 'OrganizationController@edit')
    ->name('organization.edit')
    ->middleware(['auth', 'context']);

Route::put('org/{organization}', 'OrganizationController@update')
    ->name('organization.update')
    ->middleware(['auth', 'context']);

Route::group(['prefix' => 'org/{organization}', 'middleware' => ['auth', 'context']], function(){

    Route::resource('account', 'AccountController');
    Route::resource('transaction', 'TransactionController');

    Route::get('statement', 'StatementController@index')->name('statement.index');
    Route::get('statement/upload', 'StatementController@uploader')->name('statement.uploader');
    Route::post('statement/upload', 'StatementController@upload')->name('statement.upload');
    Route::get('statement/{statement}', 'StatementController@preview')->name('statement.preview');
    Route::delete('statement/{statement}', 'StatementController@destroy')->name('statement.destroy');
    Route::delete('statement/{statement}/download', 'StatementController@download')->name('statement.download');

});
