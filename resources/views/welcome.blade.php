<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 39px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>
                        {{-- <a href="{{ route('register') }}">Register</a> --}}
                    @endauth
                </div>
            @endif

            <div class="content">
                <img src="https://vignette.wikia.nocookie.net/logopedia/images/2/25/Hyundai_logo_with_slogan.png/revision/latest/scale-to-width-down/640?cb=20171113175048" alt="HYUNDAI new thinking.new possibilities">
                <br><br>
                <div class="title m-b-md">
                    Hynudai Tunisie
                    <br>
                    <small>Demandes de congés & autorisations de sortie</small>
                </div>

                <div class="links">
                    <a href="http://www.hyundai.com.tn/">Site officiel</a>
                    <a href="https://www.facebook.com/HyundaiTunisia/">Page Facebook</a>
                </div>
            </div>
        </div>
    </body>
</html>
