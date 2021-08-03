<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <title>Shelfie</title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-primary">
    <div class="container-fluid">
        <form class="d-flex">
            @guest()
            @else
                <h1>Welcome, {{auth()->user()->firstname}}</h1>
            @endguest
        </form>
        <div class="collapse navbar-collapse text-right" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    @guest()
                    <li class="nav-item"> <a class="nav-link" href="login">Log In</a>  </li>
                    <li class="nav-item"> <a class="nav-link" href="register">Register</a> </li>
                    @else
                    <li class="nav-item"> <a class="nav-link" href="login">Log Out</a> </li>
                    @endguest

            </ul>
            <a class="navbar-brand" href="/">Shelfie</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </div>
</nav>
</body>
</html>
