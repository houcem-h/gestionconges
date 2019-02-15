@extends('layouts.appemp')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <br>
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            Historique
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="conge-tab" data-toggle="tab" href="#conge" role="tab" aria-controls="conge" aria-selected="true">Historique des congés</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="sortie-tab" data-toggle="tab" href="#sortie" role="tab" aria-controls="sortie" aria-selected="false">Historique des autorisations de sortie</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="conge" role="tabpanel" aria-labelledby="conge-tab">
                            @if(count($conge) > 0)
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Date début</th>
                                            <th>Date fin</th>
                                            <th>Durée</th>
                                            <th>Motif</th>
                                            <th>Etat</th>
                                            <th>Détails</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($conge as $item)
                                            <tr class="{{ $item->etat }}">
                                                <td>{{ $item->type }}</td>
                                                <td>{{ $item->date_debut }}</td>
                                                <td>{{ $item->date_fin }}</td>
                                                <td>{{ $item->motif }}</td>
                                                <td>{{ $item->etat }}</td>
                                                <td>
                                                    <a href="#" onclick="showdetailsHistorique({{ $item->id }})" data-toggle="tooltip" title="Détails">
                                                        <i class="fas fa-info-circle" data-toggle="modal" data-target="#showDetailsModal"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <br>
                                {{ $conge->links()}}
                            @else
                                Vous n'avez aucune demande de congé en historique.
                            @endif
                        </div>
                        <div class="tab-pane fade" id="sortie" role="tabpanel" aria-labelledby="sortie-tab">
                            @if(count($sortie) > 0)
                                <table class="table table-hover table-responsive-md">
                                    <thead>
                                        <tr>
                                        <th>Date</th>
                                        <th>Heure sortie</th>
                                        <th>Heure reprise</th>
                                        <th>Motif</th>
                                        <th>Etat</th>
                                        <th>Options</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($sortie as $item)
                                            <tr class="{{ $item->etat }}">
                                                <td>{{ $item->date_debut }}</td>
                                                <td>{{ $item->heure_sortie }}</td>
                                                <td>{{ $item->heure_reprise }}</td>
                                                <td>{{ $item->motif }}</td>
                                                <td>{{ $item->etat }}</td>
                                                <td>
                                                    <a href="#" onclick="showdetails({{ $item->id }})" data-toggle="tooltip" title="Détails">
                                                        <i class="fas fa-info-circle" data-toggle="modal" data-target="#showDetailsModal"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <br>
                                {{ $sortie->links()}}
                            @else
                                Vous n'avez aucune demande d'autoriation de sortie en historique.
                            @endif
                        </div>
                    </div>

                    <br><hr><br>
                </div>
            </div>

            <!-- ************************** Modal pour afficher les détais d'un congé ************************** -->
            <div class="modal fade" id="showDetailsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Demande <b><span id="modaltype"></span></b> pour <b><span id="modalmotif"></span></b> est <b><span id="modaletat" class="text-danger"></span></b></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <div class="modal-body">
                        Date début : <b><span id="modaldatedebut"></span></b><br>
                        Date fin : <b><span id="modaldatefin"></span></b><br>
                        Heure sortie : <b><span id="modalheuresortie"></span></b><br>
                        Durée : <b><span id="modalduree"></span></b><br>
                        Date reprise : <b><span id="modaldatereprise"></span></b><br>
                        Heure reprise : <b><span id="modalheurereprise"></span></b><br>
                        Remarque : <b><span id="modalremarque"></span></b>
                    </div>
                    <div class="modal-footer">

                    </div>
                </div>
                </div>
            </div>
    </div>
</div>

@endsection
