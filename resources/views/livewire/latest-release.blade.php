<div>
    <div wire:poll.visible.500ms="getLatest">
        <div class="text-center">
            <div class="row">
                <div class="col-12">
                    <h2 class="m-0">Loading</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <img id="lastPlayed" src="{{$release->full_image  ?? ''}}">
                    <br>
                    <h4>{{$release->artist ?? ''}} - {{$release->title ?? ''}}</h4>
                </div>
            </div>
        </div>
    </div>
</div>
