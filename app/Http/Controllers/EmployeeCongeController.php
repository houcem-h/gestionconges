<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Conge;
use App\HistoriqueConge;

class EmployeeCongeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Transférer les demandes échues vers l'historique
        $demande = Conge::where('created_by', \Auth::user()->id)
            ->whereIn('etat', ['Refus', 'Valide', 'Annulee'])
            ->get();
        foreach ($demande as $value) {
            if ($value->type = "Conge") {
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
            } else if ($value->type = "Sortie") {
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

        }
        //Lister le reste des demandes
        $conge = Conge::where([['created_by', \Auth::user()->id], ['type', 'Conge']])->get();
        $sortie = Conge::where([['created_by', \Auth::user()->id], ['type', 'Sortie']])->get();
        return view('employee.home')->with(['conge' => $conge, 'sortie' => $sortie]);
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
        $conge = Conge::find($id);
        $conge->date_debut = $request->input('date_debut');
        $conge->date_fin = $request->input('date_fin');
        $conge->heure_sortie = $request->input('heure_sortie');
        $conge->duree = $request->input('duree');
        $conge->motif = $request->input('motif');
        $conge->date_reprise = $request->input('date_reprise');
        $conge->heure_reprise = $request->input('heure_reprise');
        $conge->etat = "En attente";
        $conge->updated_by = \Auth::user()->id;
        $conge->save();
        return "updated successufly";
    }

    /**
     * Cancel the specified resource in <storage class=""></storage>
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
     * Afficher l'historique des demande pour un employé queconque.
     *
     * @return \Illuminate\Http\Response
     */
    public function historique()
    {
        $histconge = HistoriqueConge::where([
            ['created_by', \Auth::user()->id],
            ['type', 'Conge']
        ])
            ->orderBy('date_debut', 'desc')
            ->paginate(10);
        $histsortie = HistoriqueConge::where([
            ['created_by', \Auth::user()->id],
            ['type', 'Sortie']
        ])
            ->orderBy('date_debut', 'desc')
            ->paginate(10);
        return view('employee.historique')->with(['conge' => $histconge, 'sortie' => $histsortie]);
    }

    /**
     * Display the specified resource from History.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showFromHistory($id)
    {
        $conge = HistoriqueConge::find($id);
        // return view('employee.home')->with('conge', $conge);
        return $conge;
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
