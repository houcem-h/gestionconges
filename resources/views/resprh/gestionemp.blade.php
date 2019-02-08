@extends('layouts.apprh')
@section('content')

    <div class="container">
            <h2 >Liste des employees</h2>
            <div class="card mb-4">
                <div class="card-body">
                        <a href="#">
                                <button class="btn btn-primary float-right" data-toggle="modal" data-target="#addnewleaveModal"><i class="fas fa-user-plus"></i>&nbsp;Ajouter un employee</button>
                            </a>
                            <br><br>
                    <table id="example" class="table table-hover" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nom & Prénom</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Matricule</th>
                            <th>Equipe</th>
                            <th>Solde Conge</th>
                            <th class="actions">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                           
                            @foreach ($users as $item)
                            <tr> 
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->email }}</td>
                                <td>{{ $item->role }}</td>
                                <td>{{ $item->matricule }}</td>
                                <td>{{ $item->equipe }}</td>
                                <td>{{ $item->soldeConge }}</td>

                            <td>
                                <a href="#" class="btn btn-icon btn-pill btn-primary"  onclick="afficheEditForm({{ $item->id }})" data-toggle="tooltip" title="Edit"><i class="fas fa-user-edit" data-toggle="modal" data-target="#showEditModal"></i></a>
                                <a href="#" class="btn btn-icon btn-pill btn-danger" onclick="deleteDemande({{ $item->id }})" data-toggle="tooltip" title="Delete"><i class="fas fa-user-minus"></i></a>
                            </td>
                        </tr>
                        @endforeach
                     
                        </tbody>
                    </table>
                    <div class="text-center">
                            {{ $users->links() }}
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
                <h5 class="modal-title" id="exampleModalLabel">Nouveau employee</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                   
                    <div class="form-group" >
                        <label for="newname">Nom & Prénom</label>
                        <input type="text" name="newname" id="newname" class="form-control" required>
                    </div>
                    <div class="form-group" >
                        <label for="newemail">Email</label>
                        <input type="email" name="newemail" id="newemail" class="form-control">
                    </div>
                    <div class="form-group" >
                            <label for="newrole">Role</label>
                            <select name="newrole" id="newrole" class="form-control">
                                    <option disabled selected>Role de l'employee</option>
                                    <option value="0">Employee</option>
                                    <option value="1">Superviseur</option>
                                </select>                   
                             </div> 
                    <div class="form-group">
                        <label for="newmatricule">Matricule</label>
                        <input type="text" name="newmatricule" id="newmatricule" class="form-control">
                    </div>
                    <div class="form-group">
                            <label for="newequipe">Equipe</label>
                            <input type="text" name="newequipe" id="newequipe" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="newsoldeConge">Solde Conge</label>
                            <input type="text" name="newsoldeConge" id="newsoldeConge" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="newpassword">Password</label>
                            <input type="text" name="newpassword" id="newpassword" class="form-control">
                        </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-primary" onclick="nouveauEmployee()">Enregistrer</button>
                </div>
            </div>
            </div>
        </div>

    
</div>
<div class="modal fade" id="showEditModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleEditModalLabel">Modifier un employee</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body">
           <div class="form-group" >
                <label for="editname">Nom & Prénom</label>
                <input type="text" name="editname" id="editname" class="form-control" required>
            </div>
            
            <div class="form-group" >
                <label for="editemail">Email</label>
                <input type="email" name="editemail" id="editemail" class="form-control">
            </div>
            <div class="form-group" >
                    <label for="editrole">Role</label>
                    <select name="editrole" id="editrole" class="form-control">
                            <option disabled >Role de l'employee</option>
                            <option value="0">Employee</option>
                            <option value="1">Superviseur</option>
                        </select>                   
                     </div> 
            <div class="form-group">
                <label for="editmatricule">Matricule</label>
                <input type="text" name="editmatricule" id="editmatricule" class="form-control">
            </div>
            <div class="form-group">
                    <label for="editequipe">Equipe</label>
                    <input type="text" name="editequipe" id="editequipe" class="form-control">
                </div>
                <div class="form-group">
                    <label for="editsoldeConge">Solde Conge</label>
                    <input type="text" name="editsoldeConge" id="editsoldeConge" class="form-control">
                </div>
                <span id="idDemandeEdition" style="display:none"></span>

        <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
        <button type="button" class="btn btn-primary" onclick="updateEmployee()">Enregistrer</button>
        </div>
    </div>
    </div>
</div>


</div>
@endsection
<script>    


function nouveauEmployee(){
       
            var newname = $('#newname').val();
            var newemail = $('#newemail').val();
            var newmatricule = $('#newmatricule').val();
            var newrole = $('#newrole').val();
            var newsoldeConge = $('#newsoldeConge').val();
            var newequipe = $('#newequipe').val();
            var newpassword="12345";

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "POST",
                url: "{{ route('employee.store') }}",
                data: "name=" + newname + "&email=" + newemail + "&role=" + newrole + "&matricule=" + newmatricule + "&equipe=" + newequipe +"&soldeConge=" + newsoldeConge +"&password="+ newpassword,
                success: function() {
                    swal('Employee ', 'ajoutée avec succés', 'success')
                        .then(() => { location.reload(); });

                },
                error: function() {
                    swal('Erreur', 'Merci de remplir tous les champs', 'error')
                        .then(() => { location.reload(); });
                }
            })  ;
               }       
     function afficheEditForm(id) {
        var name = email = role = matricule = equipe = soldeConge = password  = '';
        $.getJSON('../employee/' + id, function(data) {
            name = data.name;
            email = data.email;
            role = data.role;
            matricule = data.matricule;
            equipe = data.equipe;
            soldeConge = data.soldeConge;
         
        }).done(function() {
            //Afficher les informations existante pour modification
         
            $('#idDemandeEdition').text(id);
            $("#editname").val(name);
            $("#editemail").val(email);
            $("#editrole").val(role);
            $("#editmatricule").val(matricule);
            $("#editequipe").val(equipe);
            $("#editsoldeConge").val(soldeConge);
           
        });}


    </script>
    <script>
    
    function updateEmployee() {
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
                var name = $('#editname').val();
                var email = $('#editemail').val();
                var role = $('#editrole').val();
                var matricule = $('#editmatricule').val();
                var equipe = $('#editequipe').val();
                var soldeConge = $('#editsoldeConge').val();
                var password = "12345";
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                })
                $.ajax({
                    type: "PUT",
                    url: "../employee/"+id,
                    data: "name="+name+ "&email="+email +"&role="+role+ "&matricule="+matricule+ "&equipe="+equipe+ "&soldeConge="+soldeConge + "&password="+password,
                    success: function() {
                        swal('Mis à jour ', 'Employee mise à jour avec succées', 'success')
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
