<x-navbar id="navbar"></x-navbar>
@livewireStyles()
<script>
    $(document).ready(function () {
        var mousetimeout;
        var screensaver_active = false;
        var idletime = 30;

        function show_screensaver() {
            $('#screensaver').fadeIn();
            screensaver_active = true;
            screensaver_animation();
        }

        function stop_screensaver() {
            $('#screensaver').fadeOut();
            $('#home').fadeIn()
            $('.navbar').fadeIn()
            screensaver_active = false;
        }

        $(document).click(function () {
            console.log('click')
            clearTimeout(mousetimeout);

            if (screensaver_active) {
                stop_screensaver();
            }

            mousetimeout = setTimeout(function () {
                show_screensaver();
            }, 500 * idletime);
        });

        $(document).mousemove(function () {
            clearTimeout(mousetimeout);

            mousetimeout = setTimeout(function () {
                show_screensaver();
            }, 1000 * idletime);
        });

        function screensaver_animation() {
            if (screensaver_active) {
                $('#home').fadeOut()
                $('.navbar').fadeOut()
                $('#screensaver').animate(
                    {backgroundColor: '#000000'},
                    600,
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
                $('#lastPlayedAt').text(release.data.last_played_at ?? "Never")
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
                $('#lastPlayedAt').text(release.data.last_played_at ?? "Never")
                $('#edit').attr("href", `/release/${release.data.id}/edit`)
                $('#releaseId').val(release.data.id)
            })
            .catch(error => {
                console.log(error);
            })
    }

</script>
<div id="screensaver" style="
    position: absolute;
    width: 100%;
    height: 100%;
    left: 0px;
    top: 0px;
    display: none;
    z-index: 9999;
background-color: #ffffff">
    <x-stats-comp :mostPlayed="$mostPlayed" :lastPlayed="$lastPlayed"></x-stats-comp>
</div>
<div id="home" class="d-block" style="overflow-x: hidden;">
    @if(\App\Models\User::query()->first())
        <div style="text-align: center;">
            <ul class="nav nav-pills mb-3 mt-1 d-block" id="pills-tab" role="tablist">
                <li class="nav-item border border-0 rounded-1 ml-3 border-primary" style="display: inline-block"
                    role="presentation">
                    <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-playing" type="button" role="tab" aria-controls="pills-home"
                            aria-selected="true">Now Playing
                    </button>
                </li>
                <li class="nav-item border border-0 rounded-1 ml-3 border-primary" role="presentation"
                    style="display: inline-block">
                    <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-collection"
                            type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Collection
                    </button>
                </li>
            </ul>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-playing" role="tabpanel"
                     aria-labelledby="pills-playing-tab">
                    <div style="display: inline-block">
                        <div class=d-flex">
                            <div class="row justify-content-start">
                                <div class="align-self-start text-center">
                                    <h3 class="mt-2 mb-0">Now Playing</h3>
                                    <br>
                                    @if(!$nowPlaying)
                                        <h4>Nothing! Go Spin A Record!</h4>
                                    @else
                                        <img id="lastPlayed" class="w-75" src="{{$nowPlaying->full_image  ?? ''}}">
                                        <h4>{{$nowPlaying->artist ?? ''}} - {{$nowPlaying->title ?? ''}}</h4>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="pills-collection" role="tabpanel"
                     aria-labelledby="pills-profile-tab">
                    <div style="display: inline-block">
                        <div class=d-flex">
                            <div class="align-self-center text-center mt-1">
                                <livewire:search/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <x-modal></x-modal>
    @else
        <div class="text-center">
            <a href="{{route('register')}}">
                <button class="btn btn-primary">Register Your Account</button>
            </a>
        </div>
    @endif
    @livewireScripts()
    <x-controls :nowPlaying="$nowPlaying"></x-controls>
</div>


