<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Equipe;

use BD;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /*$users= User::orderBy('created_at','desc')->paginate(10);
        return view('resprh.gestionemp')->with('users',$users);*/
          //lister les demandes congés en historique
          $users = User::join('equipes', 'equipes.id', '=', 'users.equipe')
          ->select('equipes.*', 'users.*')->paginate(10);
          return view('resprh.gestionemp')->with('users',$users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = new user;
        $user->name = $request->input('name');
        $user->role = $request->input('role');
        $user->email = $request->input('email');
        $user->matricule = $request->input('matricule');
        $user->equipe = $request->input('equipe');
        $user->soldeConge = $request->input('soldeConge');
        $user->password = $request->input('password');
        $user->save();
        return "Employee ajouter avec succès !";
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user= User::find($id);
        return $user;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $user->name = $request->input('name');
        $user->role = $request->input('role');
        $user->email = $request->input('email');
        $user->matricule = $request->input('matricule');
        $user->equipe = $request->input('equipe');
        $user->soldeConge = $request->input('soldeConge');
        $user->password = $request->input('password');
        $user->save();
       
        return "updated successufly";
    }
  
    public function cancel($id)
    {
        
       
    }
    public function deleteEmployee(id $id){
        $user = User::find ($id)->delete();
        return "supprimer";
      }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)

    { 
       
    }

      }
