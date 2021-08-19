<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <title>Shelfie</title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-primary">
    <div class="navbar-collapse collapse w-100 order-1 order-md-0 dual-collapse2">
        <ul class="navbar-nav mr-auto">
            @guest()
            @else
                <li>
                    <h1>Welcome, {{auth()->user()->firstname}}</h1>
                </li>
            @endguest
        </ul>
    </div>
    <div div class="navbar-collapse collapse w-100 order-3 dual-collapse2" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto">
            @guest()
                <li class="nav-item"><a class="nav-link" href="login">Log In</a></li>
                <li class="nav-item"><a class="nav-link" href="register">Register</a></li>
            @else
                <li class="nav-item"><a class="nav-link" href="{{route('login')}}">Log Out</a></li>
            @endguest

        </ul>
        <a class="navbar-brand" href="/">Shelfie</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </div>
    </div>
</nav>
</body>
</html>
