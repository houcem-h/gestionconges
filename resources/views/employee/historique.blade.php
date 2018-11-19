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
                    @if(count($conge) > 0)
                        <h3>Historique des congés</h3>
                        <table class="table table-hover">
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
                                        <td>{{ $item->type }}</td>
                                        <td>{{ $item->date_debut }}</td>
                                        <td>{{ $item->date_fin }}</td>
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
                        {{ $conge->links()}}
                    @else
                        Vous n'avez aucune demande de congé en historique.
                    @endif
                    <br><hr><br>
                    @if(count($sortie) > 0)
                        <h3>Historique des autorisations de sortie</h3>
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
                        <br>
                        {{ $sortie->links()}}
                    @else
                        Vous n'avez aucune demande d'autoriation de sortie en historique.
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
                    </div>
                    <div class="modal-footer">
                        
                    </div>
                </div>
                </div>
            </div>
    </div>
</div>
<script>
    $(document).ready(function() {

        //Coloriage du tableau
        $('tr.Valide').addClass('table-success');
        $('tr.Correction').addClass('table-warning');
        $('tr.Refus').addClass('table-danger');
        $('tr.Annulee').addClass('table-secondary');
        $('a').css('color', 'black');

        $('[data-toggle="tooltip"]').tooltip();

    });

    /************** Afficher les détails d'un congé dans un modal ********************************/
    function showdetails(id) {
        var date_debut = type = etat = motif = datedebut = datefin = heuresortie = duree = datereprise = heurereprise = remarque = '';
        $.getJSON('../employeeConge/' + id, function(data) {
            date_debut = data.date_debut;
            type = data.type;
            etat = data.etat;
            motif = data.motif;
            datedebut = data.date_debut;
            datefin = data.date_fin;
            heuresortie = data.heure_sortie;
            duree = data.duree;
            datereprise = data.date_reprise;
            heurereprise = data.heure_reprise;
            remarque = data.remarque;
        }).done(function() {
            $('#modaltype').text(type);
            $('#modaletat').text(etat);
            $('#modalmotif').text(motif);
            $('#modaldatedebut').text(datedebut);
            $('#modaldatefin').text(datefin);
            $('#modalheuresortie').text(heuresortie);
            $('#modalduree').text(duree);
            $('#modaldatereprise').text(datereprise);
            $('#modalheurereprise').text(heurereprise);
            $('#modalremarque').text(remarque);            
            
        });
    }
    /************** Fin de afficher les détails d'un congé dans un modal ********************/
</script>
@endsection

