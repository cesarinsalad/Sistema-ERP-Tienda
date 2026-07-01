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
            overflow: hidden;
        }

        #menu-container {
            height: 60px;
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(226, 232, 240, 0.8);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 100;
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
            right: 30px;
            top: 20px;
        }

        .content {
            text-align: right;
        }

        .title {
            font-size: 84px;
        }

        .links > a {
            color: #7D266E !important;
            padding: 0.5rem 1.5rem;
            font-size: 13px;
            font-weight: 700;
            letter-spacing: .05rem;
            text-decoration: none;
            text-transform: uppercase;
            border: 2px solid #7D266E;
            border-radius: 50px;
            transition: all 0.3s ease;
        }

        .links > a:hover {
            background: #7D266E;
            color: #FFFFFF !important;
            box-shadow: 0 4px 12px rgba(125, 38, 110, 0.2);
            text-decoration: none;
        }

        .m-b-md {
            margin-bottom: 30px;
        }

        #fondo_1 {
            background-image: url(/imagenes/imagen1.jpg);
            background-position: center;
            background-size: cover;
            background-repeat: no-repeat;
            width: 100%;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1;
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
