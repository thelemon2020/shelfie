<div>
    <p> Knowing others is intelligence; knowing yourself is true wisdom. </p>

    <div wire:init="getImages" class="modal fade show" role="dialog"
         id="imageModal">
        <div class="modal-dialog modal-dialog-centered" style="max-width: max-content; min-width: 27%" role="document">
            <div class="modal-content">
                <div class="carousel lazy" data-interval="false" id="image-carousel">
                    <div class="carousel-inner">
                        <div wire:loading>
                            <div class="text-center">
                                <div class="spinner-border" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>
                                <div>
                                    <p>Loading Images</p>
                                </div>
                            </div>
                        </div>
                        @if($images)
                            <div wire:loading.remove>
                                @foreach($images as $image)
                                    <img src={{$image->image}} alt={{$image->thumbnail}}/>
                                @endforeach
                            </div>
                        @endif
                    </div>
                    <a class="carousel-control-prev" href="#image-carousel" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#image-carousel" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
                <button class="btn btn-primary" onclick="setImage()" data-toggle="modal"
                        data-target="#imageModal">Select
                </button>
            </div>
        </div>
    </div>
</div>
