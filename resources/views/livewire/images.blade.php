<div>
    <script>
        window.addEventListener('image-selected', event => {
            const selectedImage = $('.carousel-item.active').children('img')[0]
            Livewire.emitTo('edit', 'changeImage', selectedImage.src, selectedImage.alt)
        })
    </script>
    <div class="carousel-inner">
        <div {{$images ? 'wire:ignore' : ''}}>
            @if($images)
                @foreach($images as $key => $image)
                    @if($key === 0 )
                        <div class="carousel-item active">
                            <img id="albumImage" src={{$image['image']}} alt={{$image['thumbnail']}}/>
                        </div>
                    @else
                        <div class="carousel-item">
                            <img id="albumImage" src={{$image['image']}} alt={{$image['thumbnail']}}/>
                        </div>
                    @endif
                @endforeach
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
    <a class="carousel-control-prev" href="#image-carousel" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#image-carousel" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
    <button class="btn btn-primary w-100" wire:click="imageSelected" data-toggle="modal"
            data-target="#imageModal">Select
    </button>
</div>
