<x-navbar></x-navbar>
<script>
    function toggleLights() {
        axios.get(`/api/lights/toggle`)
    }

    function lightSegments() {
        axios.get(`/api/lights/segments`)
    }

    function lightStrip() {
        axios.get(`/api/lights/strip`, {
            params: {
                colour: '#FFFFFF'
            }
        })
    }

    function chooseRandom(maxInt) {
        let id = Math.floor(Math.random() * (maxInt - 1) + 1)
        axios.get(`/api/release/${id}`)
            .then((release) => {
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
<body style="overflow-x: hidden;">
<h2 class="text-center">What's on your shelf?</h2>
@if(\App\Models\User::query()->first())
    @if(count(\App\Models\Release::all()) !=0)
        <div class=d-flex">
            <div class="row justify-content-start">
                <div class="col-md-6 align-self-start text-center">
                    <h3 class="m-0">Last Played</h3>
                    <br>
                    @if(!$lastPlayed)
                        <h4>Nothing! Go Spin A Record!</h4>
                    @else
                        <img id="lastPlayed" class="w-75" src="{{$lastPlayed->full_image  ?? ''}}">
                        <h4>{{$lastPlayed->artist ?? ''}} - {{$lastPlayed->title ?? ''}}</h4>
                        <h4>Last Played
                            At: {{\Carbon\Carbon::parse($lastPlayed->last_played_at)->setTimezone('America/Toronto')->format('g:i a d/m/y') ?? ''}}</h4>
                    @endif

                </div>
                <div class="col-md-5 align-self-center text-center">
                    <h3>Most Played Records</h3>
                    <table class="table">
                        <thead>
                        <th class="w-25"></th>
                        <th>Artist</th>
                        <th>Title</th>
                        <th>Times Played</th>
                        </thead>
                        <tbody>
                        @foreach($mostPlayed as $release)
                            <tr>
                                <td><img style="height: 100px; width: 100px" src="{{$release->full_image ?? ''}}">
                                </td>
                                <td>{{$release->artist ?? ''}}</td>
                                <td>{{$release->title ?? ''}}</td>
                                <td>{{$release->times_played ?? ''}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
        <div class="d-block row text-center">
            <a href="{{route('collection.index')}}">
                <button class="btn-md btn-primary">View Your Collection</button>
            </a>
            <button class="btn-md btn-primary" onclick="lightSegments()">Collection View</button>
            <button class="btn-md btn-primary" onclick="lightStrip()">Solid View</button>
            <button class="btn-md btn-primary" onclick="toggleLights()">Toggle Lights</button>
            <button class="btn-md btn-primary" onclick="chooseRandom({{\App\Models\Release::query()->count()}})">
                Select Random Album
            </button>
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

</body>
