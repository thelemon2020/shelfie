@livewireStyles()
<x-navbar></x-navbar>
<div class="row">
    <div class="col-2">
        <a class="btn-primary btn m-2" href="{{route('collection.index')}}">Back</a>
    </div>
    <div class="col-8">
        <h1 class="text-center">Add Release</h1>
    </div>
</div>
<livewire:edit/>
<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="imageModal"
     aria-hidden="true" id="imageModal">
    <div class="modal-dialog modal-dialog-centered" style="max-width: max-content; min-width: 27%" role="document">
        <div class="modal-content">
            <div class="carousel lazy" data-interval="false" id="image-carousel">
                <div class="carousel-inner">
                    <div class="text-center">
                        <div class="spinner-border" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                        <div>
                            <p>Loading Images</p>
                        </div>
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
            </div>
            <button class="btn btn-primary" onclick="setImage()" data-toggle="modal"
                    data-target="#imageModal">Select
            </button>
        </div>
    </div>
</div>
@livewireScripts()

