<x-navbar></x-navbar>
@livewireStyles
<script>
    invoke = (id) => {
        axios.get(`/api/release/${id}`)
            .then((release) => {
                console.log('release', release.data)
                $('#exampleModalLong').modal('show')
                $('#thumbnail').attr("src", release.data.thumbnail)
                $('#artist').text(release.data.artist)
                $('#title').text(release.data.title)
                $('#genre').text(release.data.genre)
                $('#timesPlayed').text(release.data.times_played ?? "0")
                $('#lastPlayed').text(release.data.last_played_at ?? "Never")
                $('#edit').attr("href", `/release/edit/${release.data.id}`)
            })
            .finally((release) => {

            })
            .catch(error => {
                console.log(error);
            })
    }

</script>
<h1 class="text-center">What's on your shelf?</h1>
@if(\App\Models\User::query()->first()->discogs_token)
    @if(count($releases) === 0)
        <div class="text-center">
            <a class="btn btn-primary" href="{{route('loadingScreen')}}">Build
                Collection
            </a>
        </div>
    @else
        @livewire('search')
    @endif
@else
    <div class="text-center ">
        <h3>Please Authenticate with Discogs</h3>
        <form action="{{route('api.discogs.authenticate')}}" method="post">
            <div class="form-group justify-content-lg-center">
                <label for="userNameInput">Discogs Username</label>
                <input type="text" style="margin-left: auto; margin-right: auto" class="form-control w-25"
                       id="userNameInput" name="username">
                @isset($message)
                    <span class="invalid-feedback d-block" role="alert">
                         <strong>{{ $message }}</strong>
                    </span>
                @endisset
            </div>
            <button type="submit" class="btn btn-primary">Authenticate</button>
        </form>
    </div>
@endif
@livewireScripts
