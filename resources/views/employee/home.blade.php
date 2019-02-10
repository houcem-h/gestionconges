@extends('layouts.appemp')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <a href="#">
                <button class="btn btn-info" data-toggle="modal" data-target="#addnewleaveModal"><i class="fas fa-calendar-plus">&nbsp;Ajouter une demande</i></button>
            </a>
            <br><br>
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            Mes demandes en cours
                        </div>
                        <div class="col-4 text-right">
                            Mon solde congé : <span class="badge badge-primary animated shake">{{ Auth::user()->soldeConge }}</span> jours
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    {{-- Liste des demandes de congés --}}
                    @if(count($conge) > 0)
                        <h3>Liste des demandes de congé</h3>
                        <table class="table table-hover table-responsive-md">
                            <thead>
                                <tr>
                                    <th>Date début</th>
                                    <th>Date fin</th>
                                    <th>Durée</th>
                                    <th>Motif</th>
                                    <th>Etat</th>
                                    <th>Options</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($conge as $item)
                                    <tr class="{{ $item->etat }}">
                                        <td>{{ $item->date_debut }}</td>
                                        <td>{{ $item->date_fin }}</td>
                                        <td>{{ $item->duree }}</td>
                                        <td>{{ $item->motif }}</td>
                                        <td>{{ $item->etat }}</td>
                                        <td>
                                            <a href="#" onclick="showdetails({{ $item->id }})" data-toggle="tooltip" title="Détails">
                                                <i class="fas fa-info-circle" data-toggle="modal" data-target="#showDetailsModal"></i>
                                            </a>
                                            <?php
                                                if (($item->etat == 'En attente') OR ($item->etat == 'Correction')) {
                                                    ?>
                                                        &nbsp;
                                                        <a href="#" onclick="afficheEditForm({{ $item->id }})" data-toggle="tooltip" title="Modifier">
                                                            <i class="fas fa-edit" data-toggle="modal" data-target="#showEditModal"></i>
                                                        </a>
                                                        &nbsp;
                                                        <a href="#" onclick="deleteDemande({{ $item->id }})" data-toggle="tooltip" title="Annuler">
                                                            <i class="fas fa-minus-circle"></i>
                                                        </a>
                                                    <?php
                                                }
                                            ?>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        Vous n'avez aucune demande de congé en cours.
                    @endif
                    <br><hr><br>
                    {{-- Liste des demandes d'autorisations de sortie --}}
                    @if(count($sortie) > 0)
                        <h3>Liste des autorisations de sortie</h3>
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
                                            <?php
                                                if (($item->etat == 'En attente') OR ($item->etat == 'Correction')) {
                                                    ?>
                                                        &nbsp;
                                                        <a href="#" onclick="afficheEditForm({{ $item->id }})" data-toggle="tooltip" title="Modifier">
                                                            <i class="fas fa-edit" data-toggle="modal" data-target="#showEditModal"></i>
                                                        </a>
                                                        &nbsp;
                                                        <a href="#" onclick="deleteDemande({{ $item->id }})" data-toggle="tooltip" title="Annuler">
                                                            <i class="fas fa-minus-circle"></i>
                                                        </a>
                                                    <?php
                                                }
                                            ?>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        Vous n'avez aucune demande d'autoriation de sortie en cours.
                    @endif
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
                        <span id="modalid" style="display:none"></span>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" onclick="afficherEditForm2()" data-toggle="modal" data-target="#showEditModal">Editer</button>
                        <button class="btn btn-warning" onclick="deleteDemande2()">Annuler</button>
                    </div>
                </div>
                </div>
            </div>

            <!-- ************************** Modal pour ajouter une nouvelle demande ************************** -->
            <div class="modal fade" id="addnewleaveModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Nouvelle demande</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <select name="newtype" id="newtype" class="form-control">
                                <option disabled selected>Type de la demande</option>
                                <option value="Conge">Congé</option>
                                <option value="Sortie">Autorisation de sortie</option>
                            </select>
                        </div>
                        <div class="form-group" id="divdatedebut" style="display:none">
                            <label for="newdatedebut">Date début</label>
                            <input type="date" name="newdatedebut" id="newdatedebut" class="form-control" required>
                        </div>
                        <div class="form-group" id="divdatefin" style="display:none">
                            <label for="newdatefin">Date fin</label>
                            <input type="date" name="newdatefin" id="newdatefin" class="form-control">
                        </div>
                        <div class="form-group" id="divdatereprise" style="display:none">
                            <label for="newdatereprise">Date reprise</label>
                            <input type="date" name="newdatereprise" id="newdatereprise" class="form-control" required>
                        </div>
                        <div class="form-group" id="divheuresortie" style="display:none">
                            <label for="newheuresortie">Heure sortie</label>
                            <input type="time" name="newheuresortie" id="newheuresortie" class="form-control">
                        </div>
                        <div class="form-group" id="divheurereprise" style="display:none">
                            <label for="newheurereprise">Heure reprise</label>
                            <input type="time" name="newheurereprise" id="newheurereprise" class="form-control">
                        </div>
                        <div class="form-group" id="divduree" style="display:none">
                            <label for="newduree">Durée</label>
                            <input type="number" name="newduree" id="newduree" class="form-control" min="1" required>
                        </div>
                        <div class="form-group" id="divmotif" style="display:none">
                            <select name="newmotif" id="newmotif" class="form-control" required>
                                <option disabled selected value="null">Motif de la demande</option>
                                <option value="Affaire personnelle">Affaire personnelle</option>
                                <option value="Maladie">Maladie</option>
                                <option value="Maternité">Maternité</option>
                                <option value="Sans solde">Sans solde</option>
                                <option value="Annuel">Annuel</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-primary" onclick="nouvelleDemandeConge()">Enregistrer</button>
                    </div>
                </div>
                </div>
            </div>

            <!-- ************************** Modal pour modifier une demande ************************** -->
            <div class="modal fade" id="showEditModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="exampleEditModalLabel">Editer la demande</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <select name="edittype" id="edittype" class="form-control" disabled>
                                    <option value="Conge">Congé</option>
                                    <option value="Sortie">Autorisation de sortie</option>
                                </select>
                            </div>
                            <div class="form-group" id="diveditdatedebut" style="display:none">
                                <label for="editdatedebut">Date début</label>
                                <input type="date" name="editdatedebut" id="editdatedebut" class="form-control" required>
                            </div>
                            <div class="form-group" id="diveditdatefin" style="display:none">
                                <label for="editdatefin">Date fin</label>
                                <input type="date" name="editdatefin" id="editdatefin" class="form-control">
                            </div>
                            <div class="form-group" id="diveditdatereprise" style="display:none">
                                <label for="editdatereprise">Date reprise</label>
                                <input type="date" name="editdatereprise" id="editdatereprise" class="form-control" required>
                            </div>
                            <div class="form-group" id="diveditheuresortie" style="display:none">
                                <label for="editheuresortie">Heure sortie</label>
                                <input type="time" name="editheuresortie" id="editheuresortie" class="form-control">
                            </div>
                            <div class="form-group" id="diveditheurereprise" style="display:none">
                                <label for="editheurereprise">Heure reprise</label>
                                <input type="time" name="editheurereprise" id="editheurereprise" class="form-control">
                            </div>
                            <div class="form-group" id="diveditduree" style="display:none">
                                <label for="editduree">Durée</label>
                                <input type="number" name="editduree" id="editduree" class="form-control" min="1" required>
                            </div>
                            <div class="form-group" id="diveditremarque" style="display:none">
                                <label for="editremarque">Remarque</label>
                                <textarea type="number" name="editremarque" id="editremarque" class="form-control" disabled></textarea>
                            </div>
                            <div class="form-group" id="diveditmotif" style="display:none">
                                <label for="editmotif">Motif</label>
                                <select name="editmotif" id="editmotif" class="form-control" required>
                                    <option disabled selected value="null">Motif de la demande</option>
                                    <option value="Affaire personnelle">Affaire personnelle</option>
                                    <option value="Maladie">Maladie</option>
                                    <option value="Maternité">Maternité</option>
                                    <option value="Sans solde">Sans solde</option>
                                    <option value="Annuel">Annuel</option>
                                </select>
                            </div>
                            <span id="idDemandeEdition" style="display:none"></span>
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                        <button type="button" class="btn btn-primary" onclick="updateDemandeConge()">Enregistrer</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

