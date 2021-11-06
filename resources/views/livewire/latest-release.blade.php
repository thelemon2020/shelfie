<div>
    <div wire:poll.visible.500ms="getLatest">
        <div class="text-center">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="m-0">Loading</h2>
                </div>
            </div>
            @if($release)
                <div class="row">
                    <div class="col-md-12">
                        <img id="lastPlayed" class="w-50 h-50" src="{{$release->full_image  ?? ''}}">
                        <br>
                        <h4>{{$release->artist ?? ''}} - {{$release->title ?? ''}}</h4>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
