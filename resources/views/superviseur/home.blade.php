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
                            
                        </tbody>
                    </table>
                        
                </div>
            </div>
            <br>
            <div class="card">
                <div class="card-header">Autorisations de sortie à valider</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

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
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
