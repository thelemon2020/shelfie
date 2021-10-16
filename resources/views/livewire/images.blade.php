<div>
    <div class="carousel lazy" data-interval="false" id="image-carousel">
        <div class="carousel-inner">
            <div>
                @if($image)
                    <div class="carousel-item active">
                        <img src={{$image['image']}} alt={{$image['thumbnail']}}/>
                    </div>
                @else
                    <div class="text-center">
                        <div class="spinner-border" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                        <div>
                            <p>Loading Images</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <a class="carousel-control-prev" wire:click="$emit('previousImage')" role="button">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" wire:click="$emit('nextImage')" role="button">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
    <button class="btn btn-primary w-100" wire:click="selectImage" data-toggle="modal"
            data-target="#imageModal">Select
    </button>
</div>
