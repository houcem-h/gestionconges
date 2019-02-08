@extends('layouts.apprh')
@section('content')

<div class="container">
        <h2 >Demandes congé à valider</h2>
        <div class="card mb-4">
            <div class="card-body">
                    
                        <br><br>
                <table id="example" class="table table-hover" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom equipe</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                       
                        @foreach ($equipes as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->nom_equipe }}</td>
                            

                        <td  id="liNbNewConges">
                                <a class="nav-link" href="{{ route('equipeCongeliste.listeEquipe', ['id' => $item->id]) }}
                                        "> <span class="badge badge-danger" id="nbNewConges"> 0</span></a>
                        </td>
                    </tr>
                    @endforeach
                 
                    </tbody>
                </table>
            </div>
        </div>
            </div>
        </div>
    
</div>


@endsection