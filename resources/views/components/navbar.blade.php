<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <script>
        function toggleLights() {
            axios.get(`/api/lights/toggle`)
        }

        function lightSegments() {
            axios.get(`/api/lights/segments`)
        }

        function lightStrip() {
            axios.get(`/api/lights/strip`, {
                params: {
                    colour: $('#stripColour').value
                }
            })
        }
    </script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <title>Shelfie</title>
</head>
<body style="max-height: 100vh; overflow-y: hidden">
<nav class="navbar navbar-expand-md navbar-light bg-primary">
    <div class="navbar-collapse collapse w-100 order-1 order-md-0 dual-collapse2">
        <ul class="navbar-nav mr-auto mt-1">
            <li><h3>Shelfie</h3></li>
            <li class="ml-3"><a href="{{route('home')}}"><i class="fas fa-home fa-2x" style="color: #000000"></i></a>
            </li>
            @if(\App\Models\User::all()->first())
                <li class="ml-3"><a href="{{route('collection.index')}}"><i class="fas fa-record-vinyl fa-2x"
                                                                            style="color: #000000"></i></a></li>
                @if((\App\Models\User::all()->first()->userSettings->wled_ip != null) && (\App\Models\User::all()->first()->userSettings->wled_ip != ""))
                    <li class="ml-3"><a data-toggle="collapse" data-target="#lightOptions"><i
                                class="fas fa-lightbulb fa-2x"
                                style="color: #000000"></i></a>
                    </li>
                @endif
                <li class="ml-3"><a href="{{route('stats')}}"><i class="fas fa-chart-pie fa-2x"></i></a></li>
            @endif
        </ul>
    </div>
    <div class="navbar-collapse collapse w-100 order-3 dual-collapse2">
        <ul class="navbar-nav ml-auto">
            @if(!\App\Models\User::query()->first())
                <li class="nav-item"><a class="nav-link" href="{{route('register')}}">Register</a></li>
            @else
            @endif
            <li class="ml-3"><a href="{{route('collection.manage.index')}}"><i class="fas fa-cog fa-2x"
                                                                               style="color: #000000"></i></a></li>
        </ul>

    </div>
</nav>
</body>
</html>
