<x-navbar></x-navbar>
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
                $('#edit').attr("href", `/release/${release.data.id}/edit`)
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
        <div style="display: flex; justify-content: space-between">
            <div class="dropdown show">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    @if(app('request')->input('sort') != "")
                        {{ucwords(str_replace("_", " ", app('request')->input('sort')))}}
                    @else
                        Sort By
                    @endif
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="{{route('collection.index', ['sort'=>'artist'])}}">Artist</a>
                    <a class="dropdown-item" href="{{route('collection.index', ['sort'=>'title'])}}">Title</a>
                    <a class="dropdown-item" href="{{route('collection.index', ['sort'=>'genre'])}}">Genre</a>
                    <a class="dropdown-item" href="{{route('collection.index', ['sort'=>'release_year'])}}">Year</a>
                    <a class="dropdown-item" href="{{route('collection.index', ['sort'=>'shelf_order'])}}">Shelf
                        Order</a>
                </div>
            </div>
            <div>
                <a href="{{route('collection.manage.index')}}" type="button" class="btn btn-info">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                         class="bi bi-gear"
                         viewBox="0 0 16 16">
                        <path
                            d="M8 4.754a3.246 3.246 0 1 0 0 6.492 3.246 3.246 0 0 0 0-6.492zM5.754 8a2.246 2.246 0 1 1 4.492 0 2.246 2.246 0 0 1-4.492 0z"/>
                        <path
                            d="M9.796 1.343c-.527-1.79-3.065-1.79-3.592 0l-.094.319a.873.873 0 0 1-1.255.52l-.292-.16c-1.64-.892-3.433.902-2.54 2.541l.159.292a.873.873 0 0 1-.52 1.255l-.319.094c-1.79.527-1.79 3.065 0 3.592l.319.094a.873.873 0 0 1 .52 1.255l-.16.292c-.892 1.64.901 3.434 2.541 2.54l.292-.159a.873.873 0 0 1 1.255.52l.094.319c.527 1.79 3.065 1.79 3.592 0l.094-.319a.873.873 0 0 1 1.255-.52l.292.16c1.64.893 3.434-.902 2.54-2.541l-.159-.292a.873.873 0 0 1 .52-1.255l.319-.094c1.79-.527 1.79-3.065 0-3.592l-.319-.094a.873.873 0 0 1-.52-1.255l.16-.292c.893-1.64-.902-3.433-2.541-2.54l-.292.159a.873.873 0 0 1-1.255-.52l-.094-.319zm-2.633.283c.246-.835 1.428-.835 1.674 0l.094.319a1.873 1.873 0 0 0 2.693 1.115l.291-.16c.764-.415 1.6.42 1.184 1.185l-.159.292a1.873 1.873 0 0 0 1.116 2.692l.318.094c.835.246.835 1.428 0 1.674l-.319.094a1.873 1.873 0 0 0-1.115 2.693l.16.291c.415.764-.42 1.6-1.185 1.184l-.291-.159a1.873 1.873 0 0 0-2.693 1.116l-.094.318c-.246.835-1.428.835-1.674 0l-.094-.319a1.873 1.873 0 0 0-2.692-1.115l-.292.16c-.764.415-1.6-.42-1.184-1.185l.159-.291A1.873 1.873 0 0 0 1.945 8.93l-.319-.094c-.835-.246-.835-1.428 0-1.674l.319-.094A1.873 1.873 0 0 0 3.06 4.377l-.16-.292c-.415-.764.42-1.6 1.185-1.184l.292.159a1.873 1.873 0 0 0 2.692-1.115l.094-.319z"/>
                    </svg>
                </a>
            </div>
        </div>
        <div>
            <table class="table">
                <thead>
                <tr>
                    <th>Image</th>
                    <th>Artist</th>
                    <th>Title</th>
                    <th>Genre</th>
                    <th>Year</th>
                </tr>
                </thead>
                <tbody>
                @foreach($releases as $release)
                    <tr>
                        <td>
                            <img
                                onClick="invoke({{$release->id}})"
                                src="{{$release->thumbnail}}"
                                alt="{{$release->artist . "-" . $release->title}}"/>
                        </td>
                        <td>{{$release->artist}}</td>
                        <td>{{$release->title}}</td>
                        <td>{{$release->genre->name}}</td>
                        <td>{{$release->release_year}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{ $releases->links() }}
        </div>
        <x-modal></x-modal>
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
