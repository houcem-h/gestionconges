<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Conge;
use App\User;

class EquipeCongeController extends Controller
{
    /**
     * Home page du superviseur.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('superviseur.home');
    }

    /**
     * les demandes du superviseur.
     *
     * @return \Illuminate\Http\Response
     */
    public function mesDemandes()
    {
        $conge = Conge::where('created_by', \Auth::user()->id)->get();
        return view('superviseur.mesdemandes')->with('conge', $conge);
    }    
    /**
     * Lister les demandes de congés.
     *
     * @return \Illuminate\Http\Response
     */
    public function listerConges()
    {
        $conges = Conge::join('users', 'users.id', '=', 'conge.created_by')
                    ->select('users.name', 'conge.*')
                    ->where('conge.type', '=', 'Conge')
                    ->whereIn('conge.created_by', User::select('id')->where([
                        ['equipe', '=', \Auth::user()->equipe],
                        ['role', '=', 0]
                    ])->get())
                    ->paginate(10);
        return view('superviseur.validationconges')->with(['conge' => $conges]);
    }

    /**
     * Lister les demandes de sortie.
     *
     * @return \Illuminate\Http\Response
     */
    public function listerSorties()
    {
        $sorties = Conge::join('users', 'users.id', '=', 'conge.created_by')
                    ->select('users.name', 'conge.*')
                    ->where('conge.type', '=', 'Sortie')
                    ->whereIn('conge.created_by', User::select('id')->where([
                        ['equipe', '=', \Auth::user()->equipe],
                        ['role', '=', 0]
                    ])->get())
                    ->paginate(10);
        return view('superviseur.validationsorties')->with(['sortie' => $sorties]);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
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
