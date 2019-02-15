@extends('layouts.apprrh')
@section('content')

    <div class="container">
            <a href="#">
                    <button class="btn btn-primary float-right" data-toggle="modal" data-target="#addnewleaveModal"><i class="fas fa-plus"></i>&nbsp;Ajouter une equipe</button>
                </a>
                <br><br>
            <div class="card mb-4">
                <div class="card-body">
                        <h4 >Liste des equipes</h4>

                    <table id="example" class="table table-hover" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nom equipe</th>
                            <th class="actions">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                           
                            @foreach ($equipes as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->nom_equipe }}</td>
                                

                            <td>
                                <a href="#" class="btn btn-icon btn-pill btn-primary"  onclick="afficheEditForm({{ $item->id }})" data-toggle="tooltip" title="Supprimer"><i class="fas fa-edit" data-toggle="modal" data-target="#showEditModal"></i></a>
                                <a href="#" class="btn btn-icon btn-pill btn-danger" onclick="deleteDemande({{ $item->id }})" data-toggle="tooltip" title="Modifier"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                        @endforeach
                     
                        </tbody>
                    </table>
                    <div class="text-center">
                            {{ $equipes->links() }}
                        </div>
                </div>
            </div>
                </div>
            </div>
        
    </div>

  
    <div class="modal fade" id="addnewleaveModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Nouvelle equipe</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                   
                    <div class="form-group" >
                        <label for="newnom_equipe">Nom equipe</label>
                        <input type="text" name="newnom_equipe" id="newnom_equipe" class="form-control" required>
                    </div>
                   
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-primary" onclick="nouvelleEquipe()">Enregistrer</button>
                </div>
            </div>
            </div>
        </div>

    
</div>
<div class="modal fade" id="showEditModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleEditModalLabel">Modifier une equipe</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body">
           
            <div class="form-group" >
                <label for="editnom_equipe">Nom equipe</label>
                <input type="text" name="editnom_equipe" id="editnom_equipe" class="form-control" required>
            </div>
           
                <span id="idDemandeEdition" style="display:none"></span>

        <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
        <button type="button" class="btn btn-primary" onclick="updateEquipe()">Enregistrer</button>
        </div>
    </div>
    </div>
</div>


</div>
<script>    


function nouvelleEquipe() {
       
            var newnom_equipe = $('#newnom_equipe').val();
           

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "POST",
                url: "{{ route('equipe.store') }}",
                data: "nom_equipe=" + newnom_equipe ,
                success: function() {
                    swal('Equipe', 'ajoutée avec succés', 'success')
                        .then(() => { location.reload(); });

                },
                error: function() {
                    swal('Erreur', 'Merci de remplir tous les champs', 'error')
                        .then(() => { location.reload(); });
                }
            })  ;
               }    

     function afficheEditForm(id) {
         console.log(id);
        var nom_equipe = '';
        $.getJSON('../equipe/' + id, function(data) {
            
            nom_equipe= data.nom_equipe;

        }).done(function() {
            //Afficher les informations existante pour modification
            $('#idDemandeEdition').text(id);
            $("#editnom_equipe").val(nom_equipe);
           
        });}


    </script>
    <script>
    
    function updateEquipe() {
        swal({
            title: "Etes-vous certain?",
            text: "Vous êtes sur le point de mettre à jour l employee !",
            icon: "warning",
            buttons: ["Annuler", "Confirmer"],
            // dangerMode: true,
        })
        .then((willCancel) => {
            if (willCancel) {
                var id = $('#idDemandeEdition').text();
                var nom_equipe = $('#editnom_equipe').val();
               console.log(nom_equipe);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                })
                $.ajax({
                    type: "PUT",
                    url: "../equipe/"+id,
                    data: "nom_equipe="+nom_equipe,
                    success: function() {
                        swal('Mis à jour ', 'Equipe mise à jour avec succées', 'success')
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
                    type: "POST",
                    url: "",
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
    </script>
        @endsection
