<x-navbar id="navbar"></x-navbar>
@livewireStyles()
<script>
    window.addEventListener('keypress', event => {
        let element = event.target;
        element.dispatchEvent(new Event('input'));
    })

    function chooseRandom(maxInt) {
        let id = Math.floor(Math.random() * (maxInt - 1) + 1)
        getDetails(id)
    }

    function getDetails(id) {
        axios.get(`/api/lights/light/${id}/on`)
        axios.get(`/api/release/${id}`)
            .then((release) => {
                console.log('release', release.data)
                $('#thumbnail').attr("src", release.data.full_image)
                $('#artist').text(release.data.artist)
                $('#title').text(release.data.title)
                $('#genre').text(release.data.genre)
                $('#thumbnailEdit').attr("src", release.data.full_image)
                $('#artistEdit').val(release.data.artist)
                $('#titleEdit').val(release.data.title)
                $('#genreEdit').val(release.data.genre)
                $('#releaseYearEdit').val(release.data.release_year)
                $('#timesPlayed').text(release.data.times_played ?? "0")
                $('#lastPlayedAt').text(release.data.last_played_at ?? "Never")
                $('#releaseId').val(release.data.id)
                $('#detailsModal').toggleClass('hidden')
            })
            .catch(error => {
                console.log(error);
            })
    }

</script>
<div id="home" class="overflow-hidden">
    @if(\App\Models\User::query()->first())
            <div class="tab-content" id="pills-tabContent">
                <div id="pills-playing" role="tabpanel" class="hidden min-w-screen min-h-screen text-center flex items-center justify-center"
                     aria-labelledby="pills-playing-tab">
                    <div>
                        <h3>Now Playing</h3>
                        <br>
                        @if(!$nowPlaying)
                            <h4>Nothing! Go Spin A Record!</h4>
                        @else
                            <img id="lastPlayed" src="{{$nowPlaying->full_image  ?? ''}}">
                            <h4>{{$nowPlaying->artist ?? ''}} - {{$nowPlaying->title ?? ''}}</h4>
                        @endif

                    </div>
                </div>
                <div class="" id="pills-collection" role="tabpanel"
                     aria-labelledby="pills-collection-tab">
                    <livewire:search/>
                </div>
                <div class="hidden" id="pills-stats" role="tabpanel"
                     aria-labelledby="pills-stats-tab">
                    <div class="d-flex">
                        <x-stats-comp :mostPlayed="$mostPlayed" :lastPlayed="$lastPlayed"></x-stats-comp>
                    </div>
                </div>
                <div class="hidden" id="pills-options" role="tabpanel"
                     aria-labelledby="pills-options-tab">
                    <div class=d-flex">
                        <div class="align-self-center text-center mt-1">
                            <x-options></x-options>
                        </div>
                    </div>
                </div>
                <div class="hidden" id="pills-register" role="tabpanel"
                     aria-labelledby="pills-register-tab">
                    <div class=d-flex">
                        <div class="align-self-center text-center mt-1">
                            <x-register></x-register>
                        </div>
                    </div>
                </div>

            </div>
    @else
        <div class="text-center hidden">
            <a href="{{route('register')}}">
                <button class="btn btn-primary">Register Your Account</button>
            </a>
        </div>
    @endif
    <x-controls :nowPlaying="$nowPlaying"></x-controls>
    <x-modal></x-modal>
    @livewireScripts()
</div>

