$(document).ready(function() {

    //Coloriage du tableau
    $('#Valide').addClass('table-success');
    $('#Correction').addClass('table-warning');
    $('#Refus').addClass('table-danger');

    //****Personnaliser le formulaire selon le type de la demande
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
    //****Fin de personnaliser le formulaire selon le type de la demande

    //**** Création d'une nouvelle demande ******/
    $('#nouvelleDemandeConge').click({
        // $.ajaxSetup({
        //   headers: {
        //     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //   }
        // });            
    });
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

}
/************** Fin de ajouter une nouvelle demande de congé depuis le modal ****************/