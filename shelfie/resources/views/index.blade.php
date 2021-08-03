<x-navbar></x-navbar>
<h1 class="text-center">What's on your shelf?</h1>
@if(auth()->user()->discogs_token)
    <div class="text-center">
        <a href="/collection">View Collection</a>
    </div>
@else
    <div class="align-content-md-center">
        <p>Please Authenticate with Discogs</p>
        <button type="button" onclick="window.location='{{url("/discogs/token")}}'">Authenicate</button>
    </div>
@endif
