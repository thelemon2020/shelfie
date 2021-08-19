<x-navbar></x-navbar>
<h1 class="text-center">What's on your shelf?</h1>
<div class="d-flex justify-content-center">
    @if(auth()->user())
        <a href="{{route('collection.index')}}">View Your Collection</a>
    @endif
</div>
