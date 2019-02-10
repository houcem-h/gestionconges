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
Route::get('congeHistorique/{id}', 'EmployeeCongeController@showFromHistory')->name("employeeConge.congeHistorique");


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


Route::get('/resprh/gestionemp', 'EmployeeController@index')->name('resph.gestionemp')->middleware('auth');
Route::resource('employee', 'EmployeeController');

Route::get('/resprh/gestionequi', 'EquipeController@index')->name('resph.gestionequi')->middleware('auth');
Route::resource('equipe', 'EquipeController');


Route::get('superviseurConge', 'SuperviseurCongesController@listerConges')->name('superviseurConge.liste');
Route::get('superviseurSortie', 'SuperviseurCongesController@listerSorties')->name('superviseurSortie.liste');

Route::get('/resprh/demandeConges', 'EquipeController@liste_equipesConges')->name('demandeConges.equipe');
Route::get('equipeCongeliste/{id}', 'EquipeCongeController@listerCongesEquipe')->name('equipeCongeliste.listeEquipe');

Route::get('/resprh/demandeSorties', 'EquipeController@liste_equipesSorties')->name('demandeSorties.equipe');
Route::get('equipeSortieliste/{id}', 'EquipeCongeController@listerSortiesEquipe')->name('equipeSortieliste.listeEquipe');

Route::get('/resprh/historiqueConges', 'EquipeController@liste_equipesSorties')->name('historiqueConges.equipe');
