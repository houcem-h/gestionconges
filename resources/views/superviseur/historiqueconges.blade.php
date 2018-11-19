@extends('layouts.appsuperv')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Historique des demandes de congé</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if(count($conge) > 0)
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Employé</th>
                                    <th>Solde</th>
                                    <th>Date début</th>
                                    <th>Date fin</th>
                                    <th>Motif</th>
                                    <th>Etat</th>
                                    <th>Opérations</th>
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
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="text-center">
                            {{ $conge->links() }}
                        </div>
                    @else
                        Vous n'avez aucun historique.
                    @endif
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

</script>
@endsection
