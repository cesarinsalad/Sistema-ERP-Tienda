<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>GIGI FASHION IMPORT</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">

    <!-- Styles -->
    <style>
        html, body {
            height: 100%;
            background: #FFFFFF;
            color: #f00000;
            margin: 0;
            font-family: sans-serif;
        }

        #menu-container {
            height: 50px;
            color: #FFFFFF;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
            z-index: 5000;
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
            text-align: right;
        }

        .title {
            font-size: 84px;
        }

        .links > a {
            color: #000000;
            padding: 0 25px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }

        #fondo_1 {
            background-image: url(/imagenes/imagen1.jpg);
            background-position: center;
            background-attachment: fixed;
            background-size: cover;
            background-repeat: no-repeat;
            width: 100%;
            height: 100%;
            position: absolute;
            text-align: center;
        }

        #fondo_1 > img {
            width: 500px;
            max-width: 90%;
            margin-top: 15vh;
            filter: drop-shadow(0 4px 20px rgba(0,0,0,0.15));

        }

    </style>
</head>
<body>
<div class="flex-center position-ref" id="menu-container">
    @if (Route::has('login'))
        <div class="top-right links">
            @auth
                <a href="{{ url('/home') }}">Home</a>
            @else

                <a href="{{ route('login') }}">Iniciar Sesión</a>

            @endauth
        </div>
    @endif
</div>
<div class="content">

    <div class="" id="fondo_1">
        <img src="{{asset('/imagenes/logo-gigi.png')}}" width="500">
    </div>
</div>
</body>
</html>
