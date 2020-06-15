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
Route::prefix('quran')->group(function(){
    Route::prefix('{surat}')->group(function(){
        Route::get('/', 'PublicController@quranSurat')->name('quranSurat');
        Route::get('page/{page}', 'PublicController@quranSuratPage')->name('quranSurat.page');
    });
});
Route::get('/faq', 'PublicController@faq')->name('faq');
Route::get('/charges', 'PublicController@charges')->name('charges');
Route::get('/islamicmedia/{slug}', 'PublicController@media')->name('islamicmedia');
Route::get('/terms', 'PublicController@terms')->name('terms');
Route::get('/article/{slug}', 'PublicController@artical')->name('artical');
Route::get('/search', 'PublicController@search')->name('search');

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
        Route::match(['GET', 'POST'], '{resource}/add', 'ResourcesController@resourceAdd')->name('resource.child.add');
        Route::match(['GET', 'POST'], '{resource}/edit/{childResource}', 'ResourcesController@resourceEdit')->name('resource.child.edit');
        Route::get('{resource}', 'ResourcesController@resource')->name('resources.resources');
    });


    Route::prefix('quran')->group(function () {
        Route::get('/', 'QuranController@index')->name('quran');
        Route::match(['GET', 'POST'], '/add', 'QuranController@add')->name('quran.add');
        Route::match(['GET', 'POST'], '{quran}/edit', 'QuranController@edit')->name('quran.edit');
        Route::post('/delete', 'QuranController@delete')->name('quran.delete');
        Route::match(['GET', 'POST'], '{quran}/add', 'QuranController@quranAdd')->name('quran.child.add');
        Route::match(['GET', 'POST'], '{quran}/edit/{childQuran}', 'QuranController@quranEdit')->name('quran.child.edit');
        Route::get('{quran}', 'QuranController@quran')->name('quran.quran');
    });


    Route::prefix('articles')->group(function () {
        Route::get('/', 'ArticalsController@index')->name('articals');
        Route::match(['GET', 'POST'], '/add', 'ArticalsController@add')->name('articals.add');
        Route::match(['GET', 'POST'], '{artical}/edit', 'ArticalsController@edit')->name('articals.edit');
        Route::post('/delete', 'ArticalsController@delete')->name('articals.delete');
        Route::get('{article}', 'ArticalsController@artical')->name('articals.articals');
    });

    Route::prefix('media')->group(function (){
        Route::get('/', 'MediaController@index')->name('media');
        Route::match(['GET', 'POST'], '/add', 'MediaController@add')->name('media.add');
        Route::match(['GET', 'POST'], '{media}/edit', 'MediaController@edit')->name('media.edit');
        Route::post('/delete', 'MediaController@delete')->name('media.delete');
        Route::match(['GET', 'POST'], '{media}/add', 'MediaController@mediaAdd')->name('media.child.add');
        Route::match(['GET', 'POST'], '{media}/edit/{childMedia}', 'MediaController@mediaEdit')->name('media.child.edit');
        Route::get('{media}', 'MediaController@media')->name('media.media');
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
