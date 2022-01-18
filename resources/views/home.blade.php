<x-navbar></x-navbar>
@livewireStyles()
<script
    src="https://code.jquery.com/jquery-3.6.0.min.js"
    integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
    crossorigin="anonymous"></script>
<script>
    $(document).ready(function () {
        var mousetimeout;
        var screensaver_active = false;
        var idletime = 5;

        function show_screensaver() {
            $('#screensaver').fadeIn();
            screensaver_active = true;
            screensaver_animation();
        }

        function stop_screensaver() {
            $('#screensaver').fadeOut();
            screensaver_active = false;
        }

        $(document).click(function () {
            clearTimeout(mousetimeout);

            if (screensaver_active) {
                stop_screensaver();
            }

            mousetimeout = setTimeout(function () {
                show_screensaver();
            }, 500 * idletime); // 5 secs
        });

        $(document).mousemove(function () {
            clearTimeout(mousetimeout);

            mousetimeout = setTimeout(function () {
                show_screensaver();
            }, 1000 * idletime); // 5 secs
        });

        function screensaver_animation() {
            if (screensaver_active) {
                $('#screensaver').animate(
                    {backgroundColor: '000000'},
                    400,
                    screensaver_animation);
            }
        }
    });
    window.addEventListener('keypress', event => {
        let element = event.target;
        element.dispatchEvent(new Event('input'));
    })

    function chooseRandom(maxInt) {
        let id = Math.floor(Math.random() * (maxInt - 1) + 1)
        axios.get(`/api/lights/light/${id}/on`)
        axios.get(`/api/release/${id}`)
            .then((release) => {
                $('#thumbnail').attr("src", release.data.full_image)
                $('#artist').text(release.data.artist)
                $('#title').text(release.data.title)
                $('#genre').text(release.data.genre)
                $('#timesPlayed').text(release.data.times_played ?? "0")
                $('#lastPlayed').text(release.data.last_played_at ?? "Never")
                $('#edit').attr("href", `/release/${release.data.id}/edit`)
                $('#releaseId').val(release.data.id)
                $('#detailsModal').modal('show')
            })
            .catch(error => {
                console.log(error);
            })
    }

    function getDetails(id) {
        axios.get(`/api/lights/light/${id}/on`)
        axios.get(`/api/release/${id}`)
            .then((release) => {
                console.log('release', release.data)
                $('#detailsModal').modal('show')
                $('#thumbnail').attr("src", release.data.full_image)
                $('#artist').text(release.data.artist)
                $('#title').text(release.data.title)
                $('#genre').text(release.data.genre)
                $('#timesPlayed').text(release.data.times_played ?? "0")
                $('#lastPlayed').text(release.data.last_played_at ?? "Never")
                $('#edit').attr("href", `/release/${release.data.id}/edit`)
                $('#releaseId').val(release.data.id)
            })
            .catch(error => {
                console.log(error);
            })
    }

</script>
<div style="overflow-x: hidden;">
    @if(\App\Models\User::query()->first())
        @if(count(\App\Models\Release::all()) !=0)
            <div class=d-flex">
                <div class="row justify-content-start">
                    <div class="col-6 align-self-start text-center">
                        <h3 class="mt-2 mb-0">Now Playing</h3>
                        <br>
                        @if(!$nowPlaying)
                            <h4>Nothing! Go Spin A Record!</h4>
                        @else
                            <img id="lastPlayed" class="w-75" src="{{$nowPlaying->full_image  ?? ''}}">
                            <h4>{{$nowPlaying->artist ?? ''}} - {{$nowPlaying->title ?? ''}}</h4>
                        @endif
                    </div>
                    <div class="col-5 align-self-center text-center mt-1">
                        <livewire:search/>
                    </div>
                </div>
            </div>
        @endif
        <x-modal></x-modal>
    @else
        <div class="text-center">
            <a href="{{route('register')}}">
                <button class="btn btn-primary">Register Your Account</button>
            </a>
        </div>
    @endif
        @livewireScripts()
</div>
<x-controls :nowPlaying="$nowPlaying"></x-controls>
<div id="screensaver">

    <x-stats-comp :mostPlayed="$mostPlayed" :lastPlayed="$lastPlayed"></x-stats-comp>
</div>
