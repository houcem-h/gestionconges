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
Route::get('/resprh/home', function () {
    return view('resprh.home');
});


Route::get('/superviseur/home', 'EquipeCongeController@index')->name('superviseur.home')->middleware('auth');

Route::get('/employee/home', 'EmployeeCongeController@index')->name('employee.home')->middleware('auth');

/*
 ***************************************************************
 **         Routes for the employee section                   **
 ***************************************************************
 */
Route::resource('employeeConge', 'EmployeeCongeController');


Route::put('employeeCongeCancel', 'EmployeeCongeController@cancel')->name('employeeConge.cancel');

Route::get('employeeCongeHistorique', 'EmployeeCongeController@historique')->name("employeeConge.historique");


/*
 ***************************************************************
 **         Routes for the supervisor section                 **
 ***************************************************************
 */

/*
 */
//lister des demandes de l'équipe
Route::get('equipeConge', 'EquipeCongeController@listerConges')->name('equipeConge.liste');
Route::get('equipeSortie', 'EquipeCongeController@listerSorties')->name('equipeSortie.liste');
/*
 */
//lister des demandes du chef d'équipe 
Route::get('mesdemandes', 'EquipeCongeController@mesDemandes')->name('superviseur.mesdemandes');
// Route::get('mademandedetails', 'EquipeCongeController@showMaDemandeDetails')->name('superviseur.mademandedetails');

/*
 */
//afficher le nombre de nouvelle demande non encore traitées
Route::get('nbconge', 'EquipeCongeController@getNbNewConges')->name('superviseur.nbnewconge');
Route::get('nbsortie', 'EquipeCongeController@getNbNewSorties')->name('superviseur.nbnewsortie');

/*
 */
//gérer les demande de l'équipe
Route::put('validerDemande', 'EquipeCongeController@validerDemande')->name('superviseur.validerdemande');
Route::put('refuserDemande', 'EquipeCongeController@refuserDemande')->name('superviseur.refuserdemande');
Route::get('detailsDemandeEquipe/{id}', 'EquipeCongeController@show')->name('superviseur.detailsdemandeequipe');
Route::put('editerDemande', 'EquipeCongeController@editerDemande')->name('superviseur.editerdemande');

/*
 */
//Afficher les historiques pour le chef d'équipe
Route::get('monhistorique', 'EquipeCongeController@monhistorique')->name('superviseur.monhistorique');
Route::get('historiqueconge', 'EquipeCongeController@listerHistoriqueConges')->name('superviseur.historiqueconges');
Route::get('historiquesortie', 'EquipeCongeController@listerHistoriqueSorties')->name('superviseur.historiquesorties');

/*
 */
//Afficher la liste des employés appartenant à l'équipe du superviseur
Route::get('monequipe', 'EquipeCongeController@listerEquipe')->name('superviseur.monequipe');


/*
 ***************************************************************
 **         Routes for the responsable RH section                 **
 ***************************************************************
 */
/*
 */
//gestion des employees crud
Route::get('/resprh/gestionemp', 'EmployeeController@index')->name('resph.gestionemp')->middleware('auth');
Route::resource('employee', 'EmployeeController');

/*
 */
//gestion des equipes crud
Route::get('/resprh/gestionequi', 'EquipeController@index')->name('resph.gestionequi')->middleware('auth');
Route::resource('equipe', 'EquipeController');
/*
 */
//lister des demandes des employees
Route::get('demandeConge', 'EmployeesCongeController@listerConges')->name('resprh.demandeConge');
Route::get('demandeSortie', 'EmployeesCongeController@listerSorties')->name('resprh.demandeSortie');

/*
 */
//gérer les demande des employees
Route::put('validerDemande', 'EmployeesCongeController@validerDemande')->name('resprh.validerdemande');
Route::put('refuserDemande', 'EmployeesCongeController@refuserDemande')->name('resprh.refuserdemande');
Route::get('detailsDemande/{id}', 'EmployeesCongeController@show')->name('resprh.detailsdemande');
Route::put('editerDemande', 'EmployeesCongeController@editerDemande')->name('resprh.editerdemande');

/*
 */
//Afficher les historiques pour le RRH
Route::get('historiqueconge', 'EmployeesCongeController@listerHistoriqueConges')->name('resprh.historiqueconges');
Route::get('historiquesortie', 'EmployeesCongeController@listerHistoriqueSorties')->name('resprh.historiquesorties');
/*
 */
//afficher le nombre de nouvelle demande non encore traitées
Route::get('nbconge', 'EmployeesCongeController@getNbNewConges')->name('resprh.nbnewconge');
Route::get('nbsortie', 'EmployeesCongeController@getNbNewSorties')->name('resprh.nbnewsortie');
