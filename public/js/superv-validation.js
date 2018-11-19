$(document).ready(function() {
    $('[data-toggle="tooltip"]').tooltip();
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