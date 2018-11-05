@extends('layouts.appsuperv')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Demandes congé à valider</div>

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
                                        <td>{{ $item->name }}</td>
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
@endsection
