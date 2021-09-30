<x-navbar></x-navbar>
<body style="overflow-x: hidden">
<h1 class="text-center">What's on your shelf?</h1>
@if(\App\Models\User::query()->first())
    <div class="d-block row text-center">
        <a class="btn btn-primary" href="{{route('collection.index')}}">View Your Collection</a>
    </div>
    <br>
    @if(count(\App\Models\Release::all()) !=0)
        <div class=d-flex">
            <div class="row justify-content-start">
                <div class="col-6 align-self-start text-center">
                    <h2 class="m-0">Last Played</h2>
                    <br>
                    @if(!$lastPlayed)
                        <h4>Nothing! Go Spin A Record!</h4>
                    @else
                        <img id="lastPlayed" src="{{$lastPlayed->full_image  ?? ''}}">
                        <h4>{{$lastPlayed->artist ?? ''}} - {{$lastPlayed->title ?? ''}}</h4>
                        <h4>Last Played
                            At: {{\Carbon\Carbon::parse($lastPlayed->last_played_at)->setTimezone('America/Toronto')->format('g:i a d/m/y') ?? ''}}</h4>
                    @endif
                </div>
                <div class="col-5 align-self-center text-center">
                    <h2>Most Played Records</h2>
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
    @endif
@else
    <div class="text-center">
        <a href="{{route('register')}}">Register Your Account</a>
        @endif
    </div>
</body>
