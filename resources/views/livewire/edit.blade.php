<div>
    <script>
        window.addEventListener('add-genre', event => {
            console.log('here')
            $('#genreModal').modal('toggle')
        })
        invoke = () => {
            axios.get("/api/release/images", {
                params: {
                    artist: $("#artist").val(),
                    title: $("#title").val(),
                }
            })
                .then((images) => {
                    let htmlInsert = ''
                    images.data.forEach((image, index) => {
                        index === 0 ? htmlInsert += `<div class='carousel-item active'><img class="d-block w-100 img-thumbnail" alt="${image.thumbnail}" src="${image.image}"></div>`
                            : htmlInsert += `<div class='carousel-item'><img class="d-block w-100 img-thumbnail" alt="${image.thumbnail}" src="${image.image}"></div>`
                    })
                    $('#image-carousel > .carousel-inner').html(htmlInsert)

                    $('#image-carousel').carousel()
                })
        }

        setImage = () => {
            const selectedImage = $('.carousel-item.active').children('img')[0]
        @this.thumbnail
            = selectedImage.alt
        @this.full_image
            = selectedImage.src
            $('#coverImage').attr("src", selectedImage.src)
        }
    </script>
    <form class="col-lg-6 offset-lg-3" wire:submit.prevent="submit">
        <div class="row justify-content-center">
            <div class="col-6">
                <label>Cover Image</label>
                <br>
                <img id="coverImage" class="img-fluid" src="{{$full_image ?? ''}}">
                <br>
                <btn class="btn btn-primary mt-2" wire:click="openImageModal">Change Cover Image
                </btn>
                @error('release.full_image')<span class="error">{{ $message }}</span> @enderror
            </div>
            <div class="col-6 align-self-center">
                <div class="form-group">
                    <label for="artist">Artist</label>
                    <br>
                    <input type="text" class="form-control" name="artist" id="artist" wire:model="artist">
                    @error('release.artist') <span class="error">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="title">Title</label>
                    <br>
                    <input type="text" class="form-control" name="title" id="title" wire:model="title">
                    @error('release.title') <span class="error">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="release_year">Release Year</label>
                    <br>
                    <input type="number" class="form-control" name="release_year" id="release_year"
                           wire:model="release_year">
                    @error('release.release_year') <span class="error">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="shelf_order">Shelf Position</label>
                    <br>
                    <input type="number" class="form-control-sm" id="shelf_order" min="1"
                           wire:model="shelf_order">
                    @error('release.shelf_order') <span class="error">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="genre">Genre</label>
                    <br>
                    <div class="dropdown show">
                        <select class="form-control ml-1" wire:model="genre">
                            <option selected="selected">Choose a Genre...</option>
                            @foreach($allGenres as $genreItem)
                                <option value="{{$genreItem->id}}">{{$genreItem->name}}</option>
                            @endforeach
                            <option value="add-modal">Add Genre...</option>
                        </select>
                    </div>
                    @error('release.shelf_order') <span class="error">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <input type="submit">
        </div>
        @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif
        @if (session()->has('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
    </form>
    <div class="modal fade" id="genreModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: max-content; min-width: 27%" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-title">Record Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <livewire:genres/>
                </div>
            </div>
        </div>
    </div>
    <livewire:images/>
</div>

