$(document).ready(function() {

    //Coloriage du tableau
    $('#Valide').addClass('table-success');
    $('#Correction').addClass('table-warning');
    $('#Refus').addClass('table-danger');
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
    });
}
/************** Fin de afficher les détails d'un congé dans un modal ********************/


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
/************** Fin de ajouter une nouvelle demande de congé depuis le modal ****************/

/************** Début de annuler une demande de congé ****************/
function deleteDemande(id) {
    swal({
            title: "Etes-vous certain?",
            text: "Une fois annulée, la demande ne peut plus être disponible pour édition!",
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
/************** Fin de annuler une demande de congé ****************/