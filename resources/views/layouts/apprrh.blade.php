
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Animate CSS -->
    <link rel="stylesheet" href="{{ asset('css/animate.css') }}">

    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">

    <!-- Icons -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.2/css/all.css" integrity="sha384-/rXc/GQVaYpyDdyxK+ecHPVYJSN9bmVFBvjA/9eOB+pb3F2w2N6fc5qB9Ew5yIns" crossorigin="anonymous">
    <link rel="stylesheet" href="https://bootadmin.net/css/bootadmin.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">


    <link rel="stylesheet" href="https://bootadmin.net/css/datatables.min.css">


    <title>Dashboard | BootAdmin</title>
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand navbar-dark bg-primary">
        <a class="sidebar-toggle mr-3" href="#"><i class="fa fa-bars"></i></a>
        <a class="navbar-brand" href="#">RRH</a>

        <div class="navbar-collapse collapse">
            <ul class="navbar-nav ml-auto">

                <li class="nav-item active" style="display:none" id="liNbNewConges">
                        <a class="nav-link" href="{{ route('resprh.demandeConge') }}"> New Congés <span class="badge badge-danger" id="nbNewConges"></span></a>
                    </li>
                    <li class="nav-item active" style="display:none" id="liNbNewSorties">
                        <a class="nav-link" href="{{ route('resprh.demandeSortie') }}">New Sorties  <span class="badge badge-danger" id="nbNewSorties"></span></a>
                    </li>
                <li class="nav-item dropdown">
                    <a href="#" id="dd_user" class="nav-link dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i>   {{ Auth::user()->name }}</a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dd_user">
                        <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>
            </ul>
        </div>
    </nav>

    <div class="d-flex">
        <div class="sidebar sidebar-dark bg-dark">
            <ul class="list-unstyled">
                <li><a href={{ route('home') }}><i class="fas fa-home"></i> Acceuil</a></li>

                <li><a href="{{ route('resph.gestionemp') }}"><i class="fas fa-user"></i> Gestion des employees</a></li>
                <li><a href="{{ route('resph.gestionequi') }}"> <i class="fas fa-users"></i> Gestion des equipes</a></li>                <li>
                    <li>
                        <a href="#sm_base" data-toggle="collapse">
                            <i class="far fa-calendar-check"></i> Validation
                        </a>
                        <ul id="sm_base" class="list-unstyled collapse">
                            <li>
                                <a href="{{ route('demandeConges.equipe') }}">Congés</a>
                            </li>
                            <li>
                                <a href="{{ route('demandeSorties.equipe') }}">Sorties</a>
                            </li>

                        </ul>
                    </li>
                    <li>
                        <a href="#sm_base1" data-toggle="collapse">
                            <i class="fas fa-history"></i> Historique
                        </a>
                        <ul id="sm_base1" class="list-unstyled collapse">
                            <li>
                                <a href="{{ route('resprh.historiqueconges') }}">Congés</a>
                            </li>
                            <li>
                                    <a href="{{ route('resprh.historiquesorties') }}">Sorties</a>
                            </li>
                        </ul>
                    </li>
            </ul>
        </div>

        <div class="content p-4">
            <div class="text-center mb-4">
                <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                    <!-- Responsive -->
                    <ins class="adsbygoogle"
                        style="display:block"
                        data-ad-client="ca-pub-4097235499795154"
                        data-ad-slot="5211442851"
                        data-ad-format="auto">
                    </ins>
                <script>
                    (adsbygoogle = window.adsbygoogle || []).push({});
                </script>
            </div>

            @yield('content')
        </div>
<!-- Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{URL::asset('asset/js/bootstrap.min.js')}}"></script>
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-118868344-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-118868344-1');
    </script>

    <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <script>
      (adsbygoogle = window.adsbygoogle || []).push({
        google_ad_client: "ca-pub-4097235499795154",
        enable_page_level_ads: true
      });
    </script>
   <script> $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();

        $('#sidebarCollapse').on('click', function() {
            $('#sidebar').toggleClass('active');
        });

        $.ajax({
            type: "GET",
            url: "{{ route('resprh.nbnewconge') }}",
            success: function(data, status){
                if (data > 0) {
                    $('#nbNewConges').text(data);
                    $('#liNbNewConges').show().addClass('animated swing');
                }
            },
        });

        $.ajax({
            type: "GET",
            url: "{{ route('resprh.nbnewsortie') }}",
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
