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
    return redirect()->route('login');

});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::match(['get','post'],'/validate-case', 'CaseController@validateCase')->name('validate.case');
Route::match(['get','post'],'add-case','CaseController@addCaseForm')->name('add.case.form');
Route::match(['get','post'],'edit-case','CaseController@editCaseForm')->name('edit.case.form');
Route::match(['get','post'],'edit/{id}/case','CaseController@editCase')->name('edit.case');
Route::post('add/vehicle-info','CaseController@addVehicleInfo')->name('add.vehicle.info');
Route::post('associate/accused','CaseController@associate')->name('case.accused.associate');
Route::post('associate/accused/remove','CaseController@removeAssociate')->name('case.accused.associate.remove');
Route::match(['get','post'],'search/case','CaseController@search')->name('search.case');

//valiate Accused
Route::match(['get','post'],'/validate-accused', 'AccusedController@validateAccused')->name('validate.accused');
Route::match(['get','post'],'accused/{id}/edit', 'AccusedController@edit')->name('accused.edit');
Route::post('add/accused-relation','AccusedController@addRelation')->name('add.accusedRelation');
Route::post('remove/accused-relation','AccusedController@removeRelation')->name('remove.accusedRelation');
Route::post('add/accused-to-gang', 'AccusedController@addGang')->name('add.accusedToGang');
Route::post('remove/accused-to-gang','AccusedController@removeGang')->name('remove.accusedToGang');
Route::post('add/accused-associate','AccusedController@associate')->name('accusedAssociate');
Route::post('remove/accused-associate','AccusedController@removeAssociate')->name('remove.accusedAssociate');
Route::match(['get','post'],'search/accused','AccusedController@search')->name('search.accused');

Route::post('add/accused-visiting','AccusedController@addVisiting')->name('add.visitingPlace');
Route::post('remove/accused-visiting','AccusedController@removeVisiting')->name('remove.visitingPlace');

Route::get('bailer', 'BailerController@index')->name('bailer.index');
Route::post('bailer/add', 'BailerController@create')->name('bailer.add');
Route::post('bailer/edit', 'BailerController@edit')->name('bailer.edit');
Route::post('bailer/destroy', 'BailerController@destroy')->name('bailer.destroy');


Route::get('advocate', 'AdvocateController@index')->name('advocate.index');
Route::post('advocate/add', 'AdvocateController@create')->name('advocate.add');
Route::post('advocate/edit', 'AdvocateController@edit')->name('advocate.edit');
Route::post('advocate/destroy', 'AdvocateController@destroy')->name('advocate.destroy');


Route::get('gang', 'GangController@index')->name('gang.index');
Route::post('gang/add', 'GangController@create')->name('gang.add');
Route::post('gang/edit', 'GangController@edit')->name('gang.edit');
Route::post('gang/destroy', 'GangController@destroy')->name('gang.destroy');


Route::get('nbw', 'NbwController@index')->name('nbw.index');
Route::post('nbw/add', 'NbwController@create')->name('nbw.add');

Route::get('record-110', 'Tbl110Controller@index')->name('r110.index');
Route::post('record-110/add', 'Tbl110Controller@create')->name('r110.add');

Route::get('hazira', 'HaziraController@index')->name('hazira.index');
Route::post('hazira/add', 'HaziraController@create')->name('hazira.add');

Route::get('PS', 'PsController@index')->name('ps.index');
Route::post('PS/add', 'PsController@create')->name('ps.add');
Route::post('PS/edit', 'PsController@edit')->name('ps.edit');
Route::post('PS/destroy', 'PsController@destroy')->name('ps.destroy');

Route::get('outpost', 'OutPostController@index')->name('outpost.index');
Route::post('outpost/add', 'OutPostController@create')->name('outpost.add');
Route::post('outpost/edit', 'OutPostController@edit')->name('outpost.edit');
Route::post('outpost/destroy', 'OutPostController@destroy')->name('outpost.destroy');


Route::get('modus', 'ModusController@index')->name('modus.index');
Route::post('modus/add', 'ModusController@create')->name('modus.add');
Route::post('modus/edit', 'ModusController@edit')->name('modus.edit');
Route::post('modus/destroy', 'ModusController@destroy')->name('modus.destroy');


Route::get('category', 'CategoryController@index')->name('category.index');
Route::post('category/add', 'CategoryController@create')->name('category.add');
Route::post('category/edit', 'CategoryController@edit')->name('category.edit');
Route::post('category/destroy', 'CategoryController@destroy')->name('category.destroy');


Route::get('place-type', 'PlaceTypeController@index')->name('placeType.index');
Route::post('place-type/add', 'PlaceTypeController@create')->name('placeType.add');
Route::post('place-type/edit', 'PlaceTypeController@edit')->name('placeType.edit');
Route::post('place-type/destroy', 'PlaceTypeController@destroy')->name('placeType.destroy');

Route::get('basti', 'BastiController@index')->name('basti.index');
Route::post('basti/add', 'BastiController@create')->name('basti.add');
Route::post('basti/edit', 'BastiController@edit')->name('basti.edit');
Route::post('basti/destroy', 'BastiController@destroy')->name('basti.destroy');

Route::get('status', 'StatusController@index')->name('status.index');
Route::post('status/add', 'StatusController@create')->name('status.add');
Route::post('status/edit', 'StatusController@edit')->name('status.edit');
Route::post('status/destroy', 'StatusController@destroy')->name('status.destroy');



Route::match(['get','post'],'add-accused','AccusedController@addAccusedForm')->name('add.accused.form');
Route::match(['get','post'],'edit-accused','AccusedController@editAccusedForm')->name('edit.accused.form');

//outpost of PS
Route::post('/ps-outpost', 'CaseController@outpost')->name('ps.outpost');

Route::post('/add-witness', 'CaseController@addWitness')->name('add.witness');
Route::post('/destroy-wintess', 'CaseController@removeWitness')->name('destroy.witness');
Route::post('ccs-update-status', 'CaseController@CrimeCriminalStatusUpdate')->name('ccs.status.update');
Route::post('add-victim', 'CaseController@addVictim')->name('add.victim');
Route::post('remove-victim', 'CaseController@removeVictim')->name('remove.victim');

Route::post('add-recovery', 'CaseController@addRecovery')->name('add.recovery');
Route::post('remove-recovery', 'CaseController@removeRecovery')->name('remove.recovery');
Route::post('add-bailed-info', 'CaseController@addBailedInformation')->name('add.bailed.info');

Route::post('get-110-criminal', 'Tbl110Controller@getById')->name('get.crimial110');
Route::post('get-hazira-criminal', 'HaziraController@getById')->name('get.crimialHazira');
Route::post('get-nbw-criminal', 'NbwController@getById')->name('get.crimialNBW');

Route::match(['get','post'],'register-user', 'UserController@create')->name('register.user');


