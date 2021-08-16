<x-navbar></x-navbar>
<h1 class="text-center">What's on your shelf?</h1>
@if(auth()->user()->discogs_token)
    @if(!auth()->user()->releases)
    <div class="text-center">
        <button type="button" onclick="window.location={{route('collection.build')}}">Build Collection</button>
    </div>
    @else
        <div class="dropdown show">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Sort By
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item" href="{{route('collection.index', ['sort'=>'artist'])}}#">Artist</a>
                <a class="dropdown-item" href="{{route('collection.index', ['sort'=>'title'])}}">Title</a>
                <a class="dropdown-item" href="{{route('collection.index', ['sort'=>'genre'])}}">Genre</a>
                <a class="dropdown-item" href="{{route('collection.index', ['sort'=>'release_year'])}}">Year</a>
                <a class="dropdown-item" href="{{route('collection.index', ['sort'=>'shelf'])}}">Shelf Order</a>
            </div>
        </div>
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
                    <td><img src="{{$release->thumbnail}}" alt=test></td>
                    <td>{{$release->artist}}</td>
                    <td>{{$release->title}}</td>
                    <td>{{$release->genre->name}}</td>
                    <td>{{$release->release_year}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $releases->links() }}
    @endif
@else
    <div class="align-content-md-center">
        <p>Please Authenticate with Discogs</p>
        <button type="button" onclick="window.location='{{url("/discogs/token")}}'">Authenicate</button>
    </div>
@endif
