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
                            Mon solde congé : <span class="badge badge-primary">{{ Auth::user()->soldeConge }}</span> jours
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
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                  <th>Type</th>
                                  <th>Date début</th>
                                  <th>Date fin</th>
                                  <th>Motif</th>
                                  <th>Etat</th>
                                  <th>Options</th>
                                </tr>
                            </thead>
                            <tbody>                                
                                @foreach ($conge as $item)
                                    <tr id="{{ $item->etat }}">
                                        <td>{{ $item->type }}</td>
                                        <td>{{ $item->date_debut }}</td>
                                        <td>{{ $item->date_fin }}</td>
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
                                                        <a href="#" onclick="editDemande({{ $item->id }})" data-toggle="tooltip" title="Modifier">
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
                        Vous n'avez aucune demande en cours.
                    @endif
                </div>
            </div>
            
            <!-- ************************** Modal pour afficher les détais d'un congé ************************** -->
            <div class="modal fade" id="showDetailsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Votre demande <b><span id="modaltype"></span></b> pour <b><span id="modalmotif"></span></b> est <b><span id="modaletat" class="text-danger"></span></b></h5>
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
                    </div>
                    <div class="modal-footer">
                        <b>P.S:</b> <span id="modalremarque"></span>
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
                                <select name="edittype" id="edittype" class="form-control">
                                    <option disabled selected>Type de la demande</option>
                                    <option value="Conge">Congé</option>
                                    <option value="Sortie">Autorisation de sortie</option>
                                </select>
                            </div>
                            <div class="form-group" id="divdatedebut" style="display:none">
                                <label for="editdatedebut">Date début</label>
                                <input type="date" name="editdatedebut" id="editdatedebut" class="form-control" required>
                            </div>
                            <div class="form-group" id="divdatefin" style="display:none">
                                <label for="editdatefin">Date fin</label>
                                <input type="date" name="editdatefin" id="editdatefin" class="form-control">
                            </div>
                            <div class="form-group" id="divdatereprise" style="display:none">
                                <label for="editdatereprise">Date reprise</label>
                                <input type="date" name="editdatereprise" id="editdatereprise" class="form-control" required>
                            </div> 
                            <div class="form-group" id="divheuresortie" style="display:none">
                                <label for="editheuresortie">Heure sortie</label>
                                <input type="time" name="editheuresortie" id="editheuresortie" class="form-control">
                            </div>
                            <div class="form-group" id="divheurereprise" style="display:none">
                                <label for="editheurereprise">Heure reprise</label>
                                <input type="time" name="editheurereprise" id="editheurereprise" class="form-control">
                            </div>
                            <div class="form-group" id="divduree" style="display:none">
                                <label for="editduree">Durée</label>
                                <input type="number" name="editduree" id="editduree" class="form-control" min="1" required>
                            </div>
                            <div class="form-group" id="divmotif" style="display:none">
                                <select name="editmotif" id="editmotif" class="form-control" required>
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
                        <button type="button" class="btn btn-primary" onclick="updateDemandeConge()">Enregistrer</button>
                        </div>
                    </div>
                    </div>
                </div>
        </div>
    </div>
</div>
<script>    
    $(document).ready(function(){
        
        //Coloriage du tableau
        $('#Valide').addClass('table-success');
        $('#Correction').addClass('table-warning');
        $('#Refus').addClass('table-danger');        

        $('[data-toggle="tooltip"]').tooltip();
        
        //****Personnaliser le formulaire d'ajout selon le type de la demande
        $('select#newtype').change(function(){
            //Si le type de la demande est une autorisation de sortie
            if($('#newtype').val() == 'Sortie'){
                //afficher la date de sortie
                $('#divdatedebut').show();
                $('label[for=newdatedebut]').html('Date');

                $('#divdatefin').hide();

                //afficher l'heure de sortie
                $('#divheuresortie').show();

                //afficher la durée en heures
                $('#divduree').show();
                $('label[for=newduree]').html('Durée (en heures)');                
                $('input#newduree').attr('max', '6');

                $('#divmotif').show();

                $('#divdatereprise').hide();

                $('#divheurereprise').show();
            }
            //Si le type de la demande est une autorisation de sortie
            else if($('#newtype').val() == 'Conge'){
                $('#divdatedebut').show();
                $('label[for=newdatedebut]').html('Date début');

                $('#divdatefin').show();

                //afficher la durée en jours
                $('#divduree').show();
                $('label[for=newduree]').html('Durée (en jours)');

                $('#divmotif').show();

                $('#divdatereprise').show();

                $('#divheurereprise').hide();
            }
        });
        //****Fin de personnaliser le formulaire d'ajout selon le type de la demande

        //****Personnaliser le formulaire d'edition selon le type de la demande
        $('select#newtype').change(function(){
            //Si le type de la demande est une autorisation de sortie
            if($('#newtype').val() == 'Sortie'){
                //afficher la date de sortie
                $('#divdatedebut').show();
                $('label[for=newdatedebut]').html('Date');

                $('#divdatefin').hide();

                //afficher l'heure de sortie
                $('#divheuresortie').show();

                //afficher la durée en heures
                $('#divduree').show();
                $('label[for=newduree]').html('Durée (en heures)');                
                $('input#newduree').attr('max', '6');

                $('#divmotif').show();

                $('#divdatereprise').hide();

                $('#divheurereprise').show();
            }
            //Si le type de la demande est une autorisation de sortie
            else if($('#newtype').val() == 'Conge'){
                $('#divdatedebut').show();
                $('label[for=newdatedebut]').html('Date début');

                $('#divdatefin').show();

                //afficher la durée en jours
                $('#divduree').show();
                $('label[for=newduree]').html('Durée (en jours)');

                $('#divmotif').show();

                $('#divdatereprise').show();

                $('#divheurereprise').hide();
            }
        });
        //****Fin de personnaliser le formulaire d'edition selon le type de la demande
        
    });

    /************** Afficher les détails d'un congé dans un modal ********************************/
    function showdetails(id){
            var date_debut = type = etat = motif = datedebut = datefin = heuresortie = duree = datereprise = heurereprise = remarque = '';
            $.getJSON('../employeeConge/'+ id, function(data){
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
            }).done(function(){
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

        
        /************** Ajouter une nouvelle demande de congé depuis le modal ****************/
        function nouvelleDemandeConge(){

            //tester sur le type pour récupérer le reste des données
            var newtype = $('#newtype').val();            
            
            if (newtype === null) {
                swal('Type demande obligatoire', 'Vous devez choisir un type', 'warning');
            } else {                                
                //Récupérer les données saisies par l'employé communes entre les deux types de demandes                
                var newdatedebut = $('#newdatedebut').val();                
                var newduree = $('#newduree').val();
                var newmotif = $('#newmotif').val();

                if(newtype === 'Conge'){                
                var newdatefin = $('#newdatefin').val();
                var newdatereprise = $('#newdatereprise').val();
                var newheuresortie = "08:00";
                var newheurereprise = "08:00";                
                
                } else if (newtype === 'Sortie') {
                    var newdatefin = newdatedebut;
                    var newdatereprise = newdatedebut;
                    var newheuresortie = $('#newheuresortie').val();
                    var newheurereprise = $('#newheurereprise').val();                
                }
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                })                
                $.ajax({
                    type: "POST",
                    url: "{{ route('employeeConge.store') }}",
                    data: "type=" + newtype + "&date_debut=" + newdatedebut + "&date_fin=" + newdatefin + "&heure_sortie=" + newheuresortie + "&duree=" + newduree + "&motif=" + newmotif + "&date_reprise=" + newdatereprise + "&heure_reprise=" + newheurereprise,
                    success: function(){
                        swal('Demande congé ', 'ajoutée avec succés', 'success')
                        .then(()=> { location.reload(); });
                        
                    },
                    error: function(){
                        swal('Erreur', 'Merci de remplir tous les champs', 'error')
                        .then(()=> { location.reload(); });
                    }
                })
            }            
        };
        /************** Fin de ajouter une nouvelle demande de congé depuis le modal ****************/

        /************** Début de annuler une demande de congé ****************/
        function deleteDemande(id){
            swal({
                title: "Etes-vous certain?",
                text: "Une fois annulée, la demande ne peut plus être disponible pour édition!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
                })
            .then((willCancel)=>{
                if (willCancel) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    })                
                    $.ajax({
                        type: "PUT",
                        url: "{{ route('employeeConge.cancel') }}",
                        data: "id=" + id,
                        success: function(){
                            swal('Annulation ', 'Demande congé annulée avec succés', 'success')
                            .then(()=> { location.reload(); });
                            
                        },
                        error: function(){
                            swal('Erreur', 'Merci de réessayer plutard', 'error')
                            .then(()=> { location.reload(); });
                        }
                    })
                } else{
                    swal("La demande n'a pas été annulée");
                }
            });
        }
        /************** Fin de annuler une demande de congé ****************/
    
</script>
@endsection

