<x-navbar></x-navbar>
@livewireStyles()
<script>
    invoke = (id) => {
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
<body>
<h1 class="text-center">What's on your shelf?</h1>
@if(count(\App\Models\Release::all()) === 0)
    <div class="text-center">
        <div class="d-block row">
            <div class="col-md-12">Nothing Here! Let's Start Building Your Collection</div>
        </div>
        <div class="row">
            <div class="col-md-5 justify-content-start">
                <a class="btn btn-primary" href={{route('release.create')}}>
                    Build Collection
                </a>
            </div>
            <div class="col-md-2">
                <strong>OR</strong>
            </div>
            <div class="col-md-5 justify-content-end">
                <a class="btn btn-primary" href={{route('api.discogs.authenticate')}}>
                    Authenticate With Discogs
                </a>
            </div>
        </div>
    </div>
@else
    @livewire('search')
    <x-modal></x-modal>
@endif
</body>
@livewireScripts()
