<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ mix('css/app.css') }}" type="text/css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
            integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <title>Shelfie</title>
    <script>
        window.addEventListener('showLightSettings', event => {
            $('#lightBulbButton').removeClass('hidden')
            $('#lightsPill').removeClass('hidden')
        })
        window.addEventListener('hideLightSettings', event => {
            $('#lightBulbButton').addClass('hidden')
            $('#lightsPill').addClass('hidden')
        })

        function changeLightBulb() {
            console.log('here')
            if ($('#lightBulb').hasClass('text-blue-900')) {
                $('#lightBulb').removeClass('text-blue-900')
                $('#lightBulb').addClass('text-blue-700')
            } else {
                $('#lightBulb').removeClass('text-blue-700')
                $('#lightBulb').addClass('text-blue-900')
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

        function onClick(pageId) {
            $("[role='tabpanel']").addClass('hidden')
            $("[role='tab']").removeClass('text-blue-900')
            $(pageId).toggleClass('hidden')
            $(pageId + '-tab').addClass('text-blue-900')
        }

        function closeModal() {
            $('#detailsModal').toggleClass('hidden');
            turnOffLight();
        }

        function toggleLightOptions() {
            $('#lightOptions').toggle();
        }

        function toggleAccordionContent(e) {
            let currentlyHidden = $(e).parent().find('.accordion-content').hasClass('hidden');
            $('.accordion-content').addClass('hidden');
            if (currentlyHidden) {
                $(e).parent().find('.accordion-content').removeClass('hidden');
            }
        }
    </script>
</head>
<body>
<nav class="bg-blue-400 text-blue-700 min-w-full flex shrink-0 justify-between py-2 px-4">
    <ul class="inline-flex items-center">
        <h3 class="mr-2 uppercase font-bold tracking-wider">Shelfie</h3>
        @if(\App\Models\User::all()->first())
            <ul class="" id="pills-tab" role="tablist">
                <li class="inline-block mr-2"
                    role="presentation">
                    <button class="text-blue-900" onclick="onClick('#pills-playing')" id="pills-playing-tab"
                            data-bs-toggle="pill"
                            data-bs-target="#pills-playing" type="button" role="tab" aria-controls="pills-playing"
                            aria-selected="true"><i class="fill-current fas fa-record-vinyl fa-2x"></i>
                    </button>
                </li>
                <li class="inline-block mr-2" role="presentation">
                    <button class="" onclick="onClick('#pills-collection')" id="pills-collection-tab"
                            data-bs-toggle="pill"
                            data-bs-target="#pills-collection"
                            type="button" role="tab" aria-controls="pills-collection" aria-selected="false"><i
                            class="fas fa-list fa-2x "></i>
                    </button>
                </li>
                <li class="inline-block mr-2" role="presentation">
                    <button class="" onclick="onClick('#pills-stats')" id="pills-stats-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-stats"
                            type="button" role="tab" aria-controls="pills-stats" aria-selected="false"><i
                            class="fas fa-chart-pie fa-2x"></i>
                    </button>
                </li>
                <li class="inline-block mr-2" role="presentation">
                    <button class="" onclick="onClick('#pills-options')" id="pills-options-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-options"
                            type="button" role="tab" aria-controls="pills-options" aria-selected="false"><i
                            class="fas fa-cog fa-2x"></i>
                    </button>
                </li>
            </ul>
        @else
            <li class="inline-block mr-2" role="presentation">
                <button onclick="onClick('#pills-register')" class="flex justify-center items-center text-blue-900"
                        id="pills-register-tab"
                        type="button" role="tab" aria-controls="pills-options" aria-selected="false">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" viewBox="0 0 20 20" fill="currentColor">
                        <path
                            d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6zM16 7a1 1 0 10-2 0v1h-1a1 1 0 100 2h1v1a1 1 0 102 0v-1h1a1 1 0 100-2h-1V7z"/>
                    </svg>
                </button>
            </li>
        @endif
    </ul>
    </ul>
    <ul class="inline-block">
        <li class="mt-1">
            <button onclick="toggleLightOptions()"
                    class="@if(\App\Models\User::all()->first()?->userSettings->wled_ip === null) hidden @endif"
                    type="button" id="lightBulbButton"
                    aria-expanded="false" aria-controls="lightOptions">
                <i
                    class="fas fa-lightbulb fa-2x text-blue-700" onclick="changeLightBulb()"
                    id="lightBulb"></i></button>
        </li>
    </ul>
    </div>
</nav>
</body>
</html>

