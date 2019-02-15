<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Equipe;
use BD;
class EquipeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $equipes= Equipe::orderBy('created_at','desc')->paginate(10);
        return view('resprh.gestionequi')->with('equipes',$equipes);
    }
   /* public function liste_equipes()
    {
        $equipes= Equipe::orderBy('nom_equipe','desc');
        return view('resprh.gestionemp')->with('equipes',$equipes);
    }
    
    /*   public function liste_equipesSorties()
       {
           $equipes= Equipe::orderBy('nom_equipe','desc')->paginate(10);
          return view('')->with('equipes',$equipes);}
          */

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
        $equipe = new equipe;
        $equipe->nom_equipe = $request->input('nom_equipe');
       
        $equipe->save();
        return "Equipe ajouter avec succès !";
    }
    
   

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       
        $equipe= Equipe::find($id);
        return $equipe;
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
        
        $equipe= Equipe::find($id);
        $equipe->nom_equipe = $request->input('nom_equipe');
        $equipe->save();
       
        return "updated successufly";
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
