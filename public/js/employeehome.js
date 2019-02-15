$(document).ready(function() {

    //Coloriage du tableau
    $('tr.Valide').addClass('table-success');
    $('tr.Correction').addClass('table-warning');
    $('tr.Refus').addClass('table-danger');
    $('tr.Annulee').addClass('table-secondary');
    $('tr.attente').addClass('table-primary');
    $('a').css('color', 'black');

    $('[data-toggle="tooltip"]').tooltip();

    // let today = new Date();
    // let dd = today.getDate();
    // let mm = today.getMonth() + 1;
    // let yyyy = today.getFullYear();
    // today = yyyy + "-" + mm + "-" + dd;

    //fix minimum end date after choosing starting date
    $('#newdatedebut').change(function() {
        $('#newdatefin').prop('min', (this.value));
    })

    //fix minimum upturn date after choosing ending date
    $('#newdatefin').change(function() {
        $('#newdatereprise').prop('min', (this.value));
    })

    //calculate number of days
    $('#newduree').focus(function() {
        this.value = ((Date.parse($('#newdatefin')[0].value) - Date.parse($('#newdatedebut')[0].value)) / (1000 * 60 * 60 * 24)) + 1;
    })


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

});

/** Display leave's details on modal
 *
 * @param {int} id
 *
 */
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
        if ((etat === 'Valide') || (etat === 'Refus')) {
            $('.modal-footer button').hide();
        }
    });
}

/**
 * Add new leave request throw modal
 */
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
            // url: "{{ route('employeeConge.store') }}",
            url: "../employeeConge/",
            data: "type=" + newtype + "&date_debut=" + newdatedebut + "&date_fin=" + newdatefin + "&heure_sortie=" + newheuresortie + "&duree=" + newduree + "&motif=" + newmotif + "&date_reprise=" + newdatereprise + "&heure_reprise=" + newheurereprise,
            success: function() {
                swal('Demande congé ', 'ajoutée avec succés', 'success')
                    .then(() => {
                        location.reload();
                    });

            },
            error: function() {
                swal('Erreur', 'Merci de remplir tous les champs', 'error')
                    .then(() => {
                        location.reload();
                    });
            }
        })
    }
};

/**
 * Cancel leave request
 *
 * @param {int} id
 */
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
                    // url: "{{ route('employeeConge.cancel') }}",
                    url: "../employeeCongeCancel/",
                    data: "id=" + id,
                    success: function() {
                        swal('Annulation ', 'Demande congé annulée avec succés', 'success')
                            .then(() => {
                                location.reload();
                            });

                    },
                    error: function() {
                        swal('Erreur', 'Merci de réessayer plutard', 'error')
                            .then(() => {
                                location.reload();
                            });
                    }
                })
            } else {
                swal("La demande n'a pas été annulée");
            }
        });
}

/**
 * Add id to delete modal
 */
function deleteDemande2() {
    var id = $('#modalid').text();
    deleteDemande(id);
}

/**
 * Display edit form in edit modal
 *
 * @param {int} id
 */
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

/**
 * Add id to display details modal
 */
function afficherEditForm2() {
    var id = $('#modalid').text();
    afficheEditForm(id);
}

/**
 * Save edit data
 */
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
                    url: "../employeeConge/" + id,
                    data: "date_debut=" + date_debut + "&date_fin=" + date_fin + "&duree=" + duree + "&motif=" + motif + "&heure_sortie=" + heure_sortie + "&date_reprise=" + date_reprise + "&heure_reprise=" + heure_reprise,
                    success: function() {
                        swal('Mis à jour ', 'Demande mise à jour avec succées', 'success')
                            .then(() => {
                                location.reload();
                            });

                    },
                    error: function() {
                        swal('Erreur', 'Merci de réessayer plutard', 'error')
                            .then(() => {
                                location.reload();
                            });
                    }
                })
            } else {
                swal("La demande n'a pas été annulée");
            }
        });
}

/** Display leave's details from history on modal
 *
 * @param {int} id
 *
 */
function showdetailsHistorique(id) {
    var date_debut = type = etat = motif = datedebut = datefin = heuresortie = duree = datereprise = heurereprise = remarque = '';
    $.getJSON('../congeHistorique/' + id, function(data) {
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
        if ((etat === 'Valide') || (etat === 'Refus')) {
            $('.modal-footer button').hide();
        }
    });
}