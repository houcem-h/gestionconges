<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>


    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    
    <!-- Sidebar Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/style4.css') }}">

    <!-- Animate CSS -->
    <link rel="stylesheet" href="{{ asset('css/animate.css') }}">

    <!-- Font Awesome JS -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>

    <!-- Popper.JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>

    <!-- Icons -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.2/css/all.css" integrity="sha384-/rXc/GQVaYpyDdyxK+ecHPVYJSN9bmVFBvjA/9eOB+pb3F2w2N6fc5qB9Ew5yIns" crossorigin="anonymous">


</head>

<body>

    <div class="wrapper" id="app">
        <!-- Sidebar  -->
        <nav id="sidebar">
            <div class="sidebar-header">
                <h3>
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                </h3>
                <strong>HT</strong>
            </div>

            <ul class="list-unstyled components">
                <li>
                    <a href="{{ route('superviseur.home') }}">
                        <i class="fas fa-home"></i> Accueil
                    </a>
                </li>
                <li>
                    <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                        <i class="far fa-calendar-check"></i> Validation
                    </a>
                    <ul class="collapse list-unstyled" id="homeSubmenu">
                        <li>
                        <a href="{{ route('equipeConge.liste') }}">Congés</a>
                        </li>
                        <li>
                            <a href="{{ route('equipeSortie.liste') }}">Sorties</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="{{ route('superviseur.mesdemandes') }}">
                            <i class="fas fa-calendar-alt"></i> Mes demandes
                    </a>
                </li>
                <li>
                    <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                        <i class="fas fa-history"></i> Historique
                    </a>
                    <ul class="collapse list-unstyled" id="pageSubmenu">
                        <li>
                        <a href="{{ route('superviseur.monhistorique') }}">Mon historique</a>
                        </li>
                        <li>
                        <a href="{{ route('superviseur.historiqueconges') }}">Congés</a>
                        </li>
                        <li>
                            <a href="{{ route('superviseur.historiquesorties') }}">Sorties</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="{{ route('superviseur.monequipe') }}">
                        <i class="fas fa-users"></i> Equipe
                    </a>
                </li>
                {{-- <li>
                    <a href="#">
                        <i class="fas fa-question"></i> FAQ
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="fas fa-paper-plane"></i> Contact
                    </a>
                </li> --}}
            </ul>            
        </nav>

        <!-- Page Content  -->
        <div id="content">

            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">

                    <button type="button" id="sidebarCollapse" class="btn btn-info">
                        <i class="fas fa-align-left"></i>
                        <span></span>
                    </button>
                    <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="fas fa-align-justify"></i>
                    </button>                    

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="nav navbar-nav ml-auto">
                            <li class="nav-item active" style="display:none" id="liNbNewConges">
                                <a class="nav-link" href="{{ route('equipeConge.liste') }}">New Congés <span class="badge badge-primary" id="nbNewConges"></span></a>
                            </li>
                            <li class="nav-item active" style="display:none" id="liNbNewSorties">
                                <a class="nav-link" href="{{ route('equipeSortie.liste') }}">New Sorties <span class="badge badge-primary" id="nbNewSorties"></span></a>
                            </li>
                            <!-- Authentication Links -->
                            @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            {{--
                            <li class="nav-item">
                                @if (Route::has('register'))
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a> @endif
                            </li> --}} @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
                                        </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                            @endguest
                        </ul>
                    </div>
                </div>
            </nav>

            <main class="py-4">
                @yield('content')
            </main>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#sidebarCollapse').on('click', function() {
                $('#sidebar').toggleClass('active');
            });

            $.ajax({
                type: "GET",
                url: "{{ route('superviseur.nbnewconge') }}",                
                success: function(data, status){
                    if (data > 0) {
                        $('#nbNewConges').text(data);
                        $('#liNbNewConges').show().addClass('animated swing');
                    }                    
                },                
            });

            $.ajax({
                type: "GET",
                url: "{{ route('superviseur.nbnewsortie') }}",                
                success: function(data, status){
                    if (data > 0) {
                        $('#nbNewSorties').text(data);
                        $('#liNbNewSorties').show().addClass('animated swing');   
                    }                    
                },                
            });
        });
    </script>
</body>

</html>