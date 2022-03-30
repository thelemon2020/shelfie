<div>
    <div wire:poll.visible.500ms="getLatest">
        <h2>Loading</h2>
        @if($release)
            <img id="lastPlayed" src="{{$release->full_image  ?? ''}}">
            <br>
            <h4>{{$release->artist ?? ''}} - {{$release->title ?? ''}}</h4>
        @endif
    </div>
</div>
