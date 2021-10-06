<x-navbar></x-navbar>
@livewireStyles()
<script>
    invoke = (id) => {
        axios.get(`/api/release/${id}`)
            .then((release) => {
                console.log('release', release.data)
                $('#exampleModalLong').modal('show')
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
<h1 class="text-center">What's on your shelf?</h1>
@if(count($releases) === 0)
    <div class="text-center">
        <a class="btn btn-primary"{{\App\Models\User::query()->first()->discogs_token ? "href=/loadingScreen" : "href=/release/add"}}>
            Build
            Collection
        </a>
    </div>
@else
    @livewire('search')
    <x-modal></x-modal>
@endif
@livewireScripts()
