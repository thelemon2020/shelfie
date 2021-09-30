<div>
    <div wire:poll>
        <div class="text-center">
            <h2 class="m-0">Loading</h2>
            <img id="lastPlayed" src="{{$lastPlayed->full_image  ?? ''}}">
            <h4>{{$lastPlayed->artist ?? ''}} - {{$lastPlayed->title ?? ''}}</h4>
        </div>
    </div>
</div>
