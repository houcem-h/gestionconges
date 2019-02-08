<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\MoveCongeToHistory;
use App\Conge;
use App\Equipe;
use App\User;

use App\HistoriqueConge;

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
        $conge = Conge::where([
            ['created_by', \Auth::user()->id],
            ['type', 'Conge']
        ])->get();
        $sortie = Conge::where([
            ['created_by', \Auth::user()->id],
            ['type', 'Sortie']
        ])->get();
        return view('superviseur.mesdemandes')->with(['conge' => $conge, 'sortie' => $sortie]);
    }


    /**
     * Lister les demandes de congés.
     *
     * @return \Illuminate\Http\Response
     */
    public function listerConges()
    {
        //Transférer les demandes congés échues vers l'historique
        $demande = Conge::where('conge.type', '=', 'Conge')
            ->whereIn('created_by', User::select('id')->where([
                ['equipe', '=', \Auth::user()->equipe],
                ['role', '=', 0]
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
                ['equipe', '=', \Auth::user()->equipe],
                ['role', '=', 0]
            ])->get())
            ->paginate(10);
        return view('superviseur.validationconges')->with(['conge' => $conges]);
    }
  /**
     * Lister les demandes de congés.
     *
     * @return \Illuminate\Http\Response
     */
    public function listerCongesEquipe($id)
    {
        //Transférer les demandes congés échues vers l'historique
        $demande = Conge::where('conge.type', '=', 'Conge')
            ->whereIn('created_by', User::select('id')->where([
                ['equipe', '=',$id]
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
                ['equipe', '=', $id]
                            ])->get())
            ->paginate(10);
        return view('resprh.validationconges')->with(['conge' => $conges]);
    }

    /**
     * Lister les demandes de sortie .
     *
     * @return \Illuminate\Http\Response
     */
    public function listerSorties()
    {
        //Transférer les demandes de sortie échues vers l'historique
        $demande = Conge::where('conge.type', '=', 'Sortie')
            ->whereIn('created_by', User::select('id')->where([
                ['equipe', '=', \Auth::user()->equipe],
                ['role', '=', 0]
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
                ['equipe', '=', \Auth::user()->equipe],
                ['role', '=', 0]
            ])->get())
            ->paginate(10);
        return view('superviseur.validationsorties')->with(['sortie' => $sorties]);
    }
  /**
     * Lister les demandes de sortie par equipe.
     *
     * @return \Illuminate\Http\Response
     */
    public function listerSortiesEquipe($id)
    {
        //Transférer les demandes de sortie échues vers l'historique
        $demande = Conge::where('conge.type', '=', 'Sortie')
            ->whereIn('created_by', User::select('id')->where([
                ['equipe', '=', $id]
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

        //lister le restant des demandes sorties
        $sorties = Conge::join('users', 'users.id', '=', 'conge.created_by')
            ->select('users.name', 'conge.*')
            ->where([['conge.type', '=', 'Sortie'], ['conge.etat', '<>', 'Annulee']])
            ->whereIn('conge.created_by', User::select('id')->where([
                ['equipe', '=', $id]
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
                ['equipe', '=', \Auth::user()->equipe],
                ['role', '=', 0]
            ])->get())
            ->count();
        return $nbconge;
    }
   /* Chercher le nombre de nouveaux congés par equipes.
     *
     * @return \Illuminate\Http\Response
     */
    public function getNbNewCongesEquipe()
    {
        $nbconge = Conge::where([
            ['etat', '=', 'En attente'],
            ['type', '=', 'Conge']
        ])
            ->whereIn('created_by', User::select('id')->where([
                ['equipe', '=', $this->id]
                            ])->get())
            ->count();
        return $nbconge;
    }

    /**
     * Chercher le nombre de nouveaux congés.
     *
     * @return \Illuminate\Http\Response
     */
    public function getNbNewSorties()
    {
        $nbsortie = Conge::where([
            ['etat', '=', 'En attente'],
            ['type', '=', 'Sortie']
        ])
            ->whereIn('created_by', User::select('id')->where([
                ['equipe', '=', \Auth::user()->equipe],
                ['role', '=', 0]
            ])->get())
            ->count();
        return $nbsortie;
    }

    /**
     * Valider une demande.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function validerDemande(Request $request)
    {
        $demande = Conge::find($request->id);
        $demande->etat = 'Valide';
        $demande->updated_by = \Auth::user()->id;
        $demande->save();
        return "Validée avec succès";
    }

    /**
     * Refuser une demande.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function refuserDemande(Request $request)
    {
        $demande = Conge::find($request->id);
        $demande->etat = 'Refus';
        $demande->updated_by = \Auth::user()->id;
        $demande->save();
        return "Refusée avec succès";
    }

    /**
     * Ajouter une remarque de correction.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editerDemande(Request $request)
    {
        $demande = Conge::find($request->id);
        $demande->etat = 'Correction';
        $demande->updated_by = \Auth::user()->id;
        $demande->remarque = $request->remarque;
        $demande->save();
        return "Refusée avec succès";
    }

    /**
     * Afficher l'hostorique des demande pour un employé queconque.
     *
     * @return \Illuminate\Http\Response
     */
    public function monhistorique()
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
        return view('superviseur.monhistorique')->with(['conge' => $histconge, 'sortie' => $histsortie]);
    }

    /**
     * Lister l'historique des demandes de congés.
     *
     * @return \Illuminate\Http\Response
     */
    public function listerHistoriqueConges()
    {
        //lister les demandes congés en historique
        $conges = HistoriqueConge::join('users', 'users.id', '=', 'historiqueconge.created_by')
            ->select('users.name', 'users.soldeConge', 'historiqueconge.*')
            ->where('historiqueconge.type', '=', 'Conge')
            ->whereIn('historiqueconge.created_by', User::select('id')->where([
                ['equipe', '=', \Auth::user()->equipe],
                ['role', '=', 0]
            ])->get())
            ->paginate(10);
        return view('superviseur.historiqueconges')->with(['conge' => $conges]);
    }
  /**
     * Lister l'historique des demandes de congés par equipe.
     *
     * @return \Illuminate\Http\Response
     */
    public function listerHistoriqueCongesEquipe($id)
    {
        //lister les demandes congés en historique
        $conges = HistoriqueConge::join('users', 'users.id', '=', 'historiqueconge.created_by')
            ->select('users.name', 'users.soldeConge', 'historiqueconge.*')
            ->where('historiqueconge.type', '=', 'Conge')
            ->whereIn('historiqueconge.created_by', User::select('id')->where([
                ['equipe', '=', $id],
            ])->get())
            ->paginate(10);
        return view('resprh.historiqueconges')->with(['conge' => $conges]);
    }

    /**
     * Lister l'historique des autorisations de sortie.
     *
     * @return \Illuminate\Http\Response
     */
    public function listerHistoriqueSorties()
    {
        //lister les demandes congés en historique
        $sorties = HistoriqueConge::join('users', 'users.id', '=', 'historiqueconge.created_by')
            ->select('users.name', 'historiqueconge.*')
            ->where('historiqueconge.type', '=', 'Sortie')
            ->whereIn('historiqueconge.created_by', User::select('id')->where([
                ['equipe', '=', \Auth::user()->equipe],
                ['role', '=', 0]
            ])->get())
            ->paginate(10);
        return view('superviseur.historiquesorties')->with(['sortie' => $sorties]);
    }

    /**
     * Lister les employés de l'équipe du supervisuer.
     *
     * @return \Illuminate\Http\Response
     */
    public function listerEquipe()
    {
        $equipe = User::where([
            ['equipe', '=', \Auth::user()->equipe],
            ['role', '=', 0]
        ])->paginate(10);
        return view('superviseur.monequipe')->with('equipe', $equipe);
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
     * Afficher les détails d'une demande d'un employé.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $conge = Conge::join('users', 'users.id', '=', 'conge.created_by')
            ->select('users.name', 'users.soldeConge', 'conge.*')
            ->where('conge.id', '=', $id)
            ->get();
        return $conge;
    }

    /**
     * Afficher les détails d'une demande du superviseur.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showMaDemandeDetails($id)
    {
        $conge = Conge::find($id);
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
