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

Auth::routes();

Route::get('/home', 'HomeController@index')->middleware('role')->name('home');

/*
 **
 Routes for redirecting the users depending on their role in the app
 **
*/
Route::get('/resprh/home', function(){
    return view('resprh.home');
});

Route::get('/superviseur/home', 'EquipeCongeController@index')->name('superviseur.home')->middleware('auth');

Route::get('/employee/home', 'EmployeeCongeController@index')->middleware('auth');

/*
 **
 Routes for the employee section
 **
*/
Route::resource('employeeConge', 'EmployeeCongeController');

Route::put('employeeCongeCancel', 'EmployeeCongeController@cancel')->name('employeeConge.cancel');


/*
 **
 Routes for the supervisor section
 **
*/
// Route::resource('equipeConge', 'EquipeCongeController');
Route::get('equipeConge', 'EquipeCongeController@listerConges')->name('equipeConge.liste');
Route::get('equipeSortie', 'EquipeCongeController@listerSorties')->name('equipeSortie.liste');
Route::get('mesdemandes', 'EquipeCongeController@mesDemandes')->name('superviseur.mesdemandes');