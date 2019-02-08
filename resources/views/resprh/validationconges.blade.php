@extends('layouts.apprh')
@section('content')

    <div class="container">
            <h2 >Demandes congé à valider
                </h2>
            <div class="card mb-4">
                <div class="card-body">
                        @if(count($conge) > 0)

                    <table id="example" class="table table-hover" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>Employé</th>
                            <th>Solde</th>
                            <th>Date debut</th>
                            <th>Date fin</th>
                            <th>Motif</th>
                            <th>Etat</th>
                            <th class="actions">Opérations</th>
                        </tr>
                        </thead>
                        <tbody>
                        
                                @foreach ($conge as $item)
                                <tr class="{{ $item->etat }}">
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->soldeConge }}</td>
                                    <td>{{ $item->date_debut }}</td>
                                    <td>{{ $item->date_fin }}</td>
                                    <td>{{ $item->motif }}</td>
                                    <td>{{ $item->etat }}</td>
                                    <td>
                                        <a href="#" onclick="showdetails({{ $item->id }})" data-toggle="tooltip" title="Détails">
                                            <i class="fas fa-info-circle" data-toggle="modal" data-target="#showDetailsModal"></i>
                                        </a>
                                        @if (($item->etat == 'En attente') OR ($item->etat == 'Correction'))
                                            &nbsp;
                                            <a href="#" onclick="validerDemande({{ $item->id }})" data-toggle="tooltip" title="Valider">
                                                <i class="fas fa-check-square"></i>
                                            </a>
                                            &nbsp;
                                            <a href="#" onclick="refuserDemande({{ $item->id }})" data-toggle="tooltip" title="Refuser">
                                                <i class="fas fa-times-circle"></i>
                                            </a>
                                            &nbsp;
                                            <a href="#" onclick="showEditForm({{ $item->id }})" data-toggle="tooltip" title="Corriger">
                                                <i class="fas fa-edit" data-toggle="modal" data-target="#showEditModal"></i>
                                            </a> 
                                        @endif 
                                    </td>
                                </tr>
                                @endforeach
                        </tbody>
                        
                    </table>
                    <div class="text-center">
                            {{ $conge->links() }}
                        </div>
                    @else
                        Vous n'avez aucune demande en cours.
                    @endif
                </div>
               
            </div>
                </div>
            </div>
        
    </div>

    <!-- ************************** Modal pour afficher les détais d'un congé ************************** -->
    <div class="modal fade" id="showDetailsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><b><span id="modalname"></span></b> (<b><span id="modalsoldeconge"></span></b>)</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    Date début : <b><span id="modaldatedebut"></span></b><br>
                    Date fin : <b><span id="modaldatefin"></span></b><br>
                    Durée : <b><span id="modalduree"></span></b><br>
                    Date reprise : <b><span id="modaldatereprise"></span></b><br>
                    Motif : <b><span id="modalmotif"></span></b><br>
                    Remarque : <textarea name="modalremarque" id="modalremarque" class="form-control" cols="33" rows="3" disabled></textarea>
                    <span id="idDemande" style="display:none"></span>
                </div>
                <div class="modal-footer">
                    <a name="" id="" class="btn btn-success" href="#" onclick="validerDemande2()" role="button">Valider</a>
                    <a name="" id="" class="btn btn-danger" href="#" onclick="refuserDemande2()" role="button">Refuser</a>
                    <a name="" id="" class="btn btn-warning" href="#" onclick="showEditForm2()" role="button" data-toggle="modal" data-target="#showEditModal">Corriger</a>
                </div>
            </div>
            </div>
        </div>

        <!-- ************************** Modal pour écrire une remarque de correction  ************************** -->
        <div class="modal fade" id="showEditModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
            <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ajouter une remarque pour correction</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">                        
                    Remarque : <textarea name="modalremarque" id="modalremarqueEditArea" class="form-control" cols="33" rows="3"></textarea>
                    <span id="idDemandeEditForm" style="display:none"></span>
                </div>
                <div class="modal-footer">
                    <a name="" id="" class="btn btn-primary" href="#" onclick="saveRemarque()" role="button">Enregistrer</a>
                    <a name="" id="" class="btn btn-secondary" href="#" role="button" data-dismiss="modal">Annuler</a>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>
</div>
<script>
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
    
            //Coloriage du tableau
            $('tr.Valide').addClass('table-success');
            $('tr.Correction').addClass('table-info');
            $('tr.Refus').addClass('table-danger');
        });
    
        function validerDemande(id) {
            swal({
                    title: "Etes-vous certain?",
                    text: "Une fois validée, la demande ne peut plus être disponible pour édition!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willCancel) => {
                    if (willCancel) {
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        })
                        $.ajax({
                            type: "PUT",
                            url: "{{ route('superviseur.validerdemande') }}",
                            data: "id=" + id,
                            success: function() {
                                swal('Validation ', 'Demande congé validée avec succés', 'success')
                                    .then(() => { location.reload(); });
    
                            },
                            error: function() {
                                swal('Erreur', 'Merci de réessayer plutard', 'error')
                                    .then(() => { location.reload(); });
                            }
                        })
                    } else {
                        swal("La demande n'a pas été validée");
                    }
                });
        }
    
        function refuserDemande(id) {
            swal({
                    title: "Etes-vous certain?",
                    text: "Une fois refusée, la demande ne peut plus être disponible pour édition!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willCancel) => {
                    if (willCancel) {
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        })
                        $.ajax({
                            type: "PUT",
                            url: "{{ route('superviseur.refuserdemande') }}",
                            data: "id=" + id,
                            success: function() {
                                swal('Refus ', 'Demande congé refusée avec succés', 'success')
                                    .then(() => { location.reload(); });
    
                            },
                            error: function() {
                                swal('Erreur', 'Merci de réessayer plutard', 'error')
                                    .then(() => { location.reload(); });
                            }
                        })
                    } else {
                        swal("La demande n'a pas été refusée");
                    }
                });
        }
    
        function showdetails(id) {
            var date_debut = type = etat = motif = datedebut = datefin = heuresortie = duree = datereprise = heurereprise = remarque = '';
            $.get('./detailsDemandeEquipe/'+id, function(data) {
                name = data[0].name;
                soldeconge = data[0].soldeConge;
                motif = data[0].motif;
                datedebut = data[0].date_debut;
                datefin = data[0].date_fin;
                datereprise = data[0].date_reprise;
                duree = data[0].duree;
                remarque = data[0].remarque;
                etat = data[0].etat;            
    
            }).done(function() {            
                
                $('#modalname').text(name);
                $('#modalsoldeconge').text(soldeconge);
                $('#modalmotif').text(motif);
                $('#modaldatedebut').text(datedebut);
                $('#modaldatefin').text(datefin);
                $('#modaldatereprise').text(datereprise);
                $('#modalduree').text(duree);
                $('#modalremarque').text(remarque);
                $('#idDemande').text(id);
    
                if ((etat === 'Valide') || (etat === 'Refus')) {
                    $('.modal-footer a').hide();
                }
                
            });        
            
        }
    
        function validerDemande2() {
            var id = $('#idDemande').text();
            validerDemande(id);        
        }
    
        function refuserDemande2() {
            var id = $('#idDemande').text();
            refuserDemande(id); 
        }
    
        function showEditForm(id){
           $('#idDemandeEditForm').text(id);
       }
       function showEditForm2(){
           $('#idDemandeEditForm').text($('#idDemande').text());
       }
    
        function saveRemarque() {
            swal({
                title: "Etes-vous certain?",
                text: "Voulez-vous ajouter cette remarque à la demande pour correction ?",
                icon: "info",
                buttons: true,
            })
            .then((willCancel) => {
                if (willCancel) {
                    var remarque = $('#modalremarqueEditArea').val();
                    var id = $('#idDemandeEditForm').text();
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    })                
                    $.ajax({
                        type: "PUT",
                        url: "{{ route('superviseur.editerdemande') }}",
                        data: "id=" + id + "&remarque=" + remarque,
                        success: function() {
                            swal('Correction', 'Remarque de correction ajoutée avec succés', 'success')
                                .then(() => { location.reload(); });
    
                        },
                        error: function() {
                            swal('Erreur', 'Merci de réessayer plutard', 'error')
                                .then(() => { location.reload(); });
                        }
                    })
                } else {
                    swal("La remarque n'a pas été ajoutée");
                }
            });
        }
    
    </script>
@endsection