<div>
    <div wire:init="getImages">
        @foreach($images as $image)

        @endforeach
    </div>
    <div class="text-center">
        <div class="spinner-border" role="status">
            <span class="sr-only">Loading...</span>
        </div>
        <div>
            <p>Loading Images</p>
        </div>
    </div>
</div>
