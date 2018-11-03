<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Conge;

class EmployeeCongeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $conge = Conge::where('created_by', \Auth::user()->id)->get();
        return view('employee.home')->with('conge', $conge);        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $conge = new Conge;
        $conge->type = $request->input('type');
        $conge->date_debut = $request->input('date_debut');
        $conge->date_fin = $request->input('date_fin');
        $conge->heure_sortie = $request->input('heure_sortie');
        $conge->duree = $request->input('duree');
        $conge->motif = $request->input('motif');
        $conge->date_reprise = $request->input('date_reprise');
        $conge->heure_reprise = $request->input('heure_reprise');
        $conge->etat = "En attente";
        $conge->created_by = \Auth::user()->id;
        $conge->save();
        return "Congé créé avec succès !";
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $conge = Conge::find($id);
        // return view('employee.home')->with('conge', $conge);
        return $conge;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
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
        //
    }

    /**
     * Cancel the specified resource in storage.
     *     
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function cancel(Request $request)
    {
        $conge = Conge::find($request->id);
        $conge->etat = "Annulee";
        $conge->updated_by = \Auth::user()->id;
        $conge->save();
        return "annulée avec succès";
    }
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // $conge = Conge::find($id);
        // $conge->etat = "Annulee";
        // $conge->updated_by = \Auth::user()->id;
        // $conge->save();
        // return 'annulée avec succès';
    }
}
