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

Route::get('/', ['as' => 'home',
    'uses' => 'IndexController@index']);
Route::get('/getDomainFromUrl', ['as' => 'get.domain.from.url',
    'uses' => 'IndexController@getDomainFromUrl']);
Route::get('/infoSiteOutlook', ['as' => 'get.domain.info',
    'uses' => 'IndexController@infoSiteOutlook']);
Route::get('/{domain}', ['as' => 'view.domain',
    'uses' => 'IndexController@viewDomain']);