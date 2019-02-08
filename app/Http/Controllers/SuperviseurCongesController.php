<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Events\MoveCongeToHistory;
use App\Conge;
use App\HistoriqueConge;
use BD;
class SuperviseurCongesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
      
    }

    public function listerConges()
    {
        //Transférer les demandes congés échues vers l'historique
        $demande = Conge::where('conge.type', '=', 'Conge')
            ->whereIn('created_by', User::select('id')->where([
                ['equipe', '=', 1],
            ])->get())
            ->whereIn('etat', ['Refus', 'Valide'])
            ->get();
        foreach ($demande as $value) {
            if ($value->date_reprise <= date("Y-m-d")) {
                $histo = new HistoriqueConge;
                $histo->type = $value->type;
                $histo->date_debut = $value->date_debut;
                $histo->date_fin = $value->date_fin;
                $histo->heure_sortie = $value->heure_sortie;
                $histo->duree = $value->duree;
                $histo->motif = $value->motif;
                $histo->date_reprise = $value->date_reprise;
                $histo->heure_reprise = $value->heure_reprise;
                $histo->etat = $value->etat;
                $histo->remarque = $value->remarque;
                $histo->created_by = $value->created_by;
                $histo->updated_by = $value->updated_by;
                $histo->save();
                Conge::find($value->id)->delete();
            }
        }

        //lister le restant des demandes congés
        $conges = Conge::join('users', 'users.id', '=', 'conge.created_by')
            ->select('users.name', 'users.soldeConge', 'conge.*')
            ->where([['conge.type', '=', 'Conge'], ['conge.etat', '<>', 'Annulee']])
            ->whereIn('conge.created_by', User::select('id')->where([
                ['equipe', '=', 1],
            ])->get())
            ->paginate(10);
        return view('resprh.validationconges')->with(['conge' => $conges]);
    }


      /**
     * Lister les demandes de sortie.
     *
     * @return \Illuminate\Http\Response
     */
    public function listerSorties()
    {
        //Transférer les demandes de sortie échues vers l'historique
        $demande = Conge::where('conge.type', '=', 'Sortie')
            ->whereIn('created_by', User::select('id')->where([
                ['role', '=', 1]
            ])->get())
            ->whereIn('etat', ['Refus', 'Valide'])
            ->get();
        foreach ($demande as $value) {
            if ($value->date_debut <= date("Y-m-d", strtotime("-3 days"))) {
                $histo = new HistoriqueConge;
                $histo->type = $value->type;
                $histo->date_debut = $value->date_debut;
                $histo->date_fin = $value->date_fin;
                $histo->heure_sortie = $value->heure_sortie;
                $histo->duree = $value->duree;
                $histo->motif = $value->motif;
                $histo->date_reprise = $value->date_reprise;
                $histo->heure_reprise = $value->heure_reprise;
                $histo->etat = $value->etat;
                $histo->remarque = $value->remarque;
                $histo->created_by = $value->created_by;
                $histo->updated_by = $value->updated_by;
                $histo->save();
                Conge::find($value->id)->delete();
            }
        }

        //lister le restant des demandes congés
        $sorties = Conge::join('users', 'users.id', '=', 'conge.created_by')
            ->select('users.name', 'conge.*')
            ->where([['conge.type', '=', 'Sortie'], ['conge.etat', '<>', 'Annulee']])
            ->whereIn('conge.created_by', User::select('id')->where([
                ['role', '=', 1]
            ])->get())
            ->paginate(10);
        return view('resprh.validationsorties')->with(['sortie' => $sorties]);
    }
     /**
     * Chercher le nombre de nouveaux congés.
     *
     * @return \Illuminate\Http\Response
     */
    public function getNbNewConges()
    {
        $nbconge = Conge::where([
            ['etat', '=', 'En attente'],
            ['type', '=', 'Conge']
        ])
            ->whereIn('created_by', User::select('id')->where([
                ['equipe', '=', $this->equipe],
                ['role', '=', 0]
            ])->get())
            ->count();
        return $nbconge;
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
