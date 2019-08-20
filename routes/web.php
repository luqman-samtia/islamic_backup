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

Route::get('/', 'PublicController@index')->name('site');
Route::match(['GET', 'POST'],'/contactUs', 'PublicController@contactUs')->name('contactUs');
Route::get('/page/{slug}', 'PublicController@page')->name('page');
Route::get('/quran', 'PublicController@quran')->name('quranPage');
Route::get('/quran/{surat}', 'PublicController@quranSurat')->name('quranSurat');

Auth::routes();

Route::middleware('auth')->prefix('admin')->group(function(){

    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/pages', 'HomeController@pages')->name('pages');
    Route::get('/emails', 'HomeController@emails')->name('emails');



    Route::prefix('resources')->group(function (){
        Route::get('/', 'ResourcesController@index')->name('resources');
        Route::match(['GET', 'POST'], '/add', 'ResourcesController@add')->name('resources.add');
        Route::match(['GET', 'POST'], '{resource}/edit', 'ResourcesController@edit')->name('resources.edit');
        Route::post('/delete', 'ResourcesController@delete')->name('resources.delete');
        Route::match(['GET', 'POST'], '{resource}/add', 'ResourcesController@resourceAdd')->name('child.add');
        Route::match(['GET', 'POST'], '{resource}/edit/{childResource}', 'ResourcesController@resourceEdit')->name('child.edit');
        Route::get('{resource}', 'ResourcesController@resource')->name('resources.resources');
    });


    Route::prefix('quran')->group(function () {
        Route::get('/', 'QuranController@index')->name('quran');
        Route::match(['GET', 'POST'], '/add', 'QuranController@add')->name('quran.add');
        Route::match(['GET', 'POST'], '{quran}/edit', 'QuranController@edit')->name('quran.edit');
        Route::post('/delete', 'QuranController@delete')->name('quran.delete');
        Route::match(['GET', 'POST'], '{quran}/add', 'QuranController@quranAdd')->name('child.add');
        Route::match(['GET', 'POST'], '{quran}/edit/{childQuran}', 'QuranController@quranEdit')->name('child.edit');
        Route::get('{quran}', 'QuranController@quran')->name('quran.quran');
    });

    Route::prefix('users')->group(function (){
        Route::get('/', 'UserController@index')->name('users');
        Route::match(['GET', 'POST'], '/add', 'UserController@add')->name('users.add');
        Route::match(['GET', 'POST'], '{user}/edit', 'UserController@edit')->name('users.edit');
        Route::get('{user}/delete', 'UserController@delete')->name('users.delete');
        Route::match(['GET', 'POST'], '{user}/role', 'UserController@role')->name('users.role');
    });

    Route::prefix('roles')->group(function (){
        Route::get('/', 'RoleController@index')->name('roles');
        Route::match(['GET', 'POST'], '/add', 'RoleController@add')->name('roles.add');
        Route::match(['GET', 'POST'], '{role}/edit', 'RoleController@edit')->name('roles.edit');
        Route::get('{role}/delete', 'RoleController@delete')->name('roles.delete');
        Route::match(['GET', 'POST'], '{role}/permissions', 'RoleController@permissions')->name('roles.permissions');
    });

    Route::prefix('permissions')->group(function (){
        Route::get('/', 'PermissionController@index')->name('permissions');
        Route::match(['GET', 'POST'], '/add', 'PermissionController@add')->name('permissions.add');
        Route::match(['GET', 'POST'], '{permission}/edit', 'PermissionController@edit')->name('permissions.edit');
        Route::get('{permission}/delete', 'PermissionController@delete')->name('permissions.delete');
        Route::match(['GET', 'POST'], '{permission}/roles', 'PermissionController@roles')->name('permissions.roles');
    });

});
