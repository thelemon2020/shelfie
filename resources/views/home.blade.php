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

    window.addEventListener('new-release-updated', event => {
        getDetails(event.detail.id)
        $('#editModal').toggleClass('hidden')
    })

    function getDetails(id) {
        axios.get(`/api/lights/light/${id}/on`)
        axios.get(`/api/release/${id}`)
            .then((release) => {
                console.log('release', release.data)
                $('#thumbnail').attr("src", release.data.full_image)
                $('#artist').text(release.data.artist)
                $('#title').text(release.data.title)
                $('#genre').text(release.data.genre)
                $('#timesPlayed').text(release.data.times_played ?? "0")
                $('#lastPlayedAt').text(release.data.last_played_at ?? "Never")
                $('#releaseId').val(release.data.id)
                $('#coverImage').attr("src", release.data.full_image)
                $('#detailsModal').toggleClass('hidden')
            })
            .catch(error => {
                console.log(error);
            })
    }

</script>
<div id="home" class="overflow-hidden">
    <div class="tab-content" id="pills-tabContent">
        <div id="pills-playing" class="@if(\App\Models\User::query()->count() <1) hidden @endif" role="tabpanel"
             aria-labelledby="pills-playing-tab">
            <div class="text-center">
                <h3>Now Playing</h3>
                <br>
                @if(!$nowPlaying)
                    <h4>Nothing! Go Spin A Record!</h4>
                @else
                    <img class="raspi:w-48 h-48 inline-flex" id="lastPlayed"
                         src="{{$nowPlaying->full_image  ?? ''}}">
                    <h4>{{$nowPlaying->artist ?? ''}} - {{$nowPlaying->title ?? ''}}</h4>
                @endif
            </div>
        </div>
        <div class="hidden" id="pills-collection" role="tabpanel"
             aria-labelledby="pills-collection-tab">
            <livewire:search/>
        </div>
        <div class="overflow-x-hidden hidden" id="pills-stats" role="tabpanel"
             aria-labelledby="pills-stats-tab">
            <div class="d-flex">
                <x-stats-comp :mostPlayed="$mostPlayed" :lastPlayed="$lastPlayed"></x-stats-comp>
            </div>
        </div>
        @if(\App\Models\UserSettings::query()->count() > 0)
        <div class="hidden" id="pills-options" role="tabpanel"
             aria-labelledby="pills-options-tab">
            <div class=d-flex">
                <div class="align-self-center text-center mt-1">
                    <x-options></x-options>
                </div>
            </div>
        </div>
        @endif
        <div class="@if(\App\Models\User::query()->count() >=1) hidden @endif" id="pills-register" role="tabpanel"
             aria-labelledby="pills-register-tab">
            <div class=d-flex">
                <div class="align-self-center text-center mt-1">
                    <x-register></x-register>
                </div>
            </div>
        </div>

    </div>
    <x-controls :nowPlaying="$nowPlaying"></x-controls>
    <x-modal></x-modal>
    <x-edit-modal></x-edit-modal>
    @livewireScripts()
</div>

