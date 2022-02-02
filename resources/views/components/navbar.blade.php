<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <script>function changeLightBulb() {
            console.log('here')
            if ($('#lightBulb').hasClass('text-black')) {
                $('#lightBulb').removeClass('text-black')
                $('#lightBulb').addClass('text-black-50')
            } else {
                $('#lightBulb').removeClass('text-black-50')
                $('#lightBulb').addClass('text-black')
            }
        }

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
    <link rel="stylesheet" href="{{ mix('css/app.css') }}" type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
            crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
            integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <title>Shelfie</title>
</head>
<body style="max-height: 100vh; overflow-y: hidden">
<nav class="navbar navbar-expand-md navbar-light bg-primary">
    <div class="navbar-collapse collapse w-100 order-1 order-md-0 dual-collapse2">
        <ul class="navbar-nav mr-auto">
            <li class="mt-1"><h3>Shelfie</h3></li>
            <ul class="nav nav-pills d-block" id="pills-tab" role="tablist">
                <li class="nav-item ml-1" style="display: inline-block"
                    role="presentation">
                    <a class="nav-link active" id="pills-playing-tab" data-bs-toggle="pill"
                       data-bs-target="#pills-playing" type="button" role="tab" aria-controls="pills-playing"
                       aria-selected="true"><i class="fas fa-record-vinyl fa-2x"></i>
                    </a>
                </li>
                <li class="nav-item" role="presentation"
                    style="display: inline-block">
                    <button class="nav-link" id="pills-collection-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-collection"
                            type="button" role="tab" aria-controls="pills-collection" aria-selected="false"><i
                            class="fas fa-list fa-2x "></i>
                    </button>
                </li>
                <li class="nav-item" role="presentation"
                    style="display: inline-block">
                    <button class="nav-link" id="pills-stats-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-stats"
                            type="button" role="tab" aria-controls="pills-stats" aria-selected="false"><i
                            class="fas fa-chart-pie fa-2x"></i>
                    </button>
                </li>
                <li class="nav-item" role="presentation"
                    style="display: inline-block">
                    <button class="nav-link" id="pills-options-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-options"
                            type="button" role="tab" aria-controls="pills-options" aria-selected="false"><i
                            class="fas fa-cog fa-2x"></i>
                    </button>
                </li>
            </ul>
        </ul>
    </div>
    <div class="navbar-collapse collapse w-100 order-3 justify-content-end me-2 dual-collapse2">
        <ul class="navbar-nav ml-auto">
            @if(\App\Models\User::all()->first())
                @if((\App\Models\User::all()->first()->userSettings?->wled_ip != null) && (\App\Models\User::all()->first()->userSettings?->wled_ip != ""))
                    <li class="mt-1">
                        <button class="btn" type="button" data-bs-toggle="collapse" data-bs-target="#lightOptions"
                                aria-expanded="false" aria-controls="lightOptions">
                            <i
                                class="fas fa-lightbulb fa-2x text-black-50" onclick="changeLightBulb()"
                                id="lightBulb"></i></button>
                    </li>
                @endif
            @endif
        </ul>
    </div>
</nav>
</body>
</html>

