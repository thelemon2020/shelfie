<div>
    <div wire:poll.visible.500ms="getLatest">
        <h2>Loading</h2>
        @if($release)
            <img id="lastPlayed" class="raspi:w-60" src="{{$release->full_image  ?? ''}}">
            <h4>{{$release->artist ?? ''}} - {{$release->title ?? ''}}</h4>
        @endif
    </div>
</div>
