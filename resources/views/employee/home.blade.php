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
<script>
    $(document).ready(function() {

        //Coloriage du tableau
        $('tr.Valide').addClass('table-success');
        $('tr.Correction').addClass('table-warning');
        $('tr.Refus').addClass('table-danger');
        $('tr.Annulee').addClass('table-secondary');
        $('tr.attente').addClass('table-primary');
        $('a').css('color', 'black');

        $('[data-toggle="tooltip"]').tooltip();

        //****Personnaliser le formulaire d'ajout selon le type de la demande
        $('select#newtype').change(function() {
            //Si le type de la demande est une autorisation de sortie
            if ($('#newtype').val() == 'Sortie') {
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
            else if ($('#newtype').val() == 'Conge') {
                $('#divdatedebut').show();
                $('label[for=newdatedebut]').html('Date début');

                $('#divdatefin').show();

                //masquer l'heure de sortie
                $('#divheuresortie').hide();

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
        $('select#newtype').change(function() {
            //Si le type de la demande est une autorisation de sortie
            if ($('#newtype').val() == 'Sortie') {
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
            else if ($('#newtype').val() == 'Conge') {
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
            $('#modalid').text(id);
            if((etat === 'Valide') || (etat === 'Refus')){
                $('.modal-footer button').hide();
            }
        });
    }
    


    /************** Ajouter une nouvelle demande de congé depuis le modal ****************/
    function nouvelleDemandeConge() {
        //tester sur le type pour récupérer le reste des données
        var newtype = $('#newtype').val();

        if (newtype === null) {
            swal('Type demande obligatoire', 'Vous devez choisir un type', 'warning');
        } else {
            //Récupérer les données saisies par l'employé communes entre les deux types de demandes                
            var newdatedebut = $('#newdatedebut').val();
            var newduree = $('#newduree').val();
            var newmotif = $('#newmotif').val();

            if (newtype === 'Conge') {
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
                success: function() {
                    swal('Demande congé ', 'ajoutée avec succés', 'success')
                        .then(() => { location.reload(); });

                },
                error: function() {
                    swal('Erreur', 'Merci de remplir tous les champs', 'error')
                        .then(() => { location.reload(); });
                }
            })            
        }
    };
    

    /************** Annuler une demande de congé ****************/
    function deleteDemande(id) {
        swal({
            title: "Etes-vous certain?",
            text: "Une fois annulée, la demande ne peut plus être disponible pour édition!",
            icon: "warning",
            buttons: ["Annuler", "Confirmer"],
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
                    url: "{{ route('employeeConge.cancel') }}",
                    data: "id=" + id,
                    success: function() {
                        swal('Annulation ', 'Demande congé annulée avec succés', 'success')
                            .then(() => { location.reload(); });

                    },
                    error: function() {
                        swal('Erreur', 'Merci de réessayer plutard', 'error')
                            .then(() => { location.reload(); });
                    }
                })
            } else {
                swal("La demande n'a pas été annulée");
            }
        });
    }

    function deleteDemande2(){
        var id = $('#modalid').text();
        deleteDemande(id);
    }
    

    /************** Afficher le formulaire de modification d'un congé dans un modal ********************************/
    function afficheEditForm(id) {
        var date_debut = type = etat = motif = datedebut = datefin = heuresortie = duree = datereprise = heurereprise = remarque = '';
        $.getJSON('../employeeConge/' + id, function(data) {
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
            //Afficher les informations existante pour modification
            $('#idDemandeEdition').text(id);
            $("#edittype").val(type);
            $("#editdatedebut").val(datedebut);
            $("#editdatefin").val(datefin);
            $("#editduree").val(duree);
            $("#editmotif").val(motif);
            $("#editheuresortie").val(heuresortie);
            $("#editdatereprise").val(datereprise);
            $("#editheurereprise").val(heurereprise);
            $("#editremarque").val(remarque);

            //afficher les informations communes entre les deux types de demandes: la date de début, duree et motif           
            $("#diveditdatedebut").show();           
            $("#diveditduree").show();          
            $("#diveditmotif").show();
            if (etat === "Correction") {
                $("#diveditremarque").show();
            } else {
                $("#diveditremarque").hide();
            }

            //Afficher les informations spécifiques à chaque type de demande
            if (type === "Conge") {
                $("#diveditdatedebut label").text("Date début");
                $("#diveditdatefin").show();
                $("#diveditdatereprise").show();
                $("#diveditheuresortie").hide();
                $("#diveditheurereprise").hide();
            } else if (type === "Sortie") {
                $("#diveditdatedebut label").text("Date");
                $("#diveditheuresortie").show();
                $("#diveditheurereprise").show();
                $("#diveditdatefin").hide();
                $("#diveditdatereprise").hide();
            }
           
        });
    }

    function afficherEditForm2(){
        var id = $('#modalid').text();
        afficheEditForm(id);
    }
    

    /************** Enregistrer la modification d'un congé********************/
    function updateDemandeConge() {
        swal({
            title: "Etes-vous certain?",
            text: "Vous êtes sur le point de mettre à jour votre demande !",
            icon: "warning",
            buttons: ["Annuler", "Confirmer"],
            // dangerMode: true,
        })
        .then((willCancel) => {
            if (willCancel) {
                var id = $('#idDemandeEdition').text();
                var date_debut = $('#editdatedebut').val();
                var date_fin = $('#editdatefin').val();
                var duree = $('#editduree').val();
                var motif = $('#editmotif').val();
                var heure_sortie = $('#editheuresortie').val();
                var date_reprise = $('#editdatereprise').val();
                var heure_reprise = $('#editheurereprise').val();                
                
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                })
                $.ajax({
                    type: "PUT",
                    url: "../employeeConge/"+id,
                    data: "date_debut="+date_debut+ "&date_fin="+date_fin+ "&duree="+duree+ "&motif="+motif+ "&heure_sortie="+heure_sortie+ "&date_reprise="+date_reprise+ "&heure_reprise="+heure_reprise,
                    success: function() {
                        swal('Mis à jour ', 'Demande mise à jour avec succées', 'success')
                            .then(() => { location.reload(); });

                    },
                    error: function() {
                        swal('Erreur', 'Merci de réessayer plutard', 'error')
                            .then(() => { location.reload(); });
                    }
                })
            } else {
                swal("La demande n'a pas été annulée");
            }
        });
    }
    
</script>
@endsection

