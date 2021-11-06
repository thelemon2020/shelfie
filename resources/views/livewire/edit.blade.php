<div>
    <script>
        window.addEventListener('add-genre', event => {
            $('#genreModal').modal('toggle')
        })
        window.addEventListener('image-modal', event => {
            const elementsToRemove = document.getElementsByClassName('carousel-item');
            console.log(elementsToRemove)
            for (var i = 0; i < elementsToRemove.length; i++) {
                elementsToRemove[i].remove()
            }
            $('#imageModal').modal('toggle')
        })
    </script>
    <form class="col-md-6 offset-md-3" wire:submit.prevent="submit">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <label>Cover Image</label>
                <br>
                <img id="coverImage" class="img-thumbnail img-fluid h-75 w-75"
                     src="{{$full_image ?? ''}}">
                <br>
                <btn class="btn btn-primary mt-2" wire:click="loadImages">
                    Change Cover Image
                </btn>
                @error('release.full_image')<span class="error">{{ $message }}</span> @enderror
            </div>
            <div class="col-md-6 align-self-center">
                <div class="form-group">
                    <label for="artist">Artist</label>
                    <br>
                    <input type="text" class="form-control" name="artist" id="artist" wire:model="release.artist">
                    @error('release.artist') <span class="error">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="title">Title</label>
                    <br>
                    <input type="text" class="form-control" name="title" id="title" wire:model="release.title">
                    @error('release.title') <span class="error">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="release_year">Release Year</label>
                    <br>
                    <input type="number" class="form-control" name="release_year" id="release_year"
                           wire:model="release.release_year">
                    @error('release.release_year') <span class="error">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="shelf_order">Shelf Position</label>
                    <br>
                    <input type="number" class="form-control-sm" id="shelf_order" min="1"
                           wire:model="release.shelf_order">
                    @error('release.shelf_order') <span class="error">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="genre">Genre</label>
                    <br>
                    <div class="dropdown show">
                        <select class="form-control ml-1" wire:model="release.genre_id">
                            <option selected="selected">Choose a Genre...</option>
                            @foreach($allGenres as $genreItem)
                                <option value="{{$genreItem->id}}">{{$genreItem->name}}</option>
                            @endforeach
                            <option value="add-modal">Add Genre...</option>
                        </select>
                    </div>
                    @error('release.genre_id') <span class="error">{{ $message }}</span> @enderror
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
    <div class="modal fade" role="dialog" id="imageModal">
        <div class="modal-dialog modal-dialog-centered" style="max-width: max-content; min-width: 27%" role="document">
            <div class="modal-content w-auto">
                <div class="modal-body" style="min-height: 100%; min-width: 100%">
                    <div class="carousel lazy" data-interval="false" id="image-carousel">
                        <livewire:images/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

