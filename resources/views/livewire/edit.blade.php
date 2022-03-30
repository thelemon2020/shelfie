<div>
    <script>
        window.addEventListener('add-genre', event => {
            $('#genreModal').toggleClass('hidden')
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
    <form class="" wire:submit.prevent="submit">
        <label>Cover Image</label>
        <br>
        <img id="coverImage" class=""
             src="{{$full_image ?? ''}}">
        <br>
        <btn class="" wire:click="loadImages">
            Change Cover Image
        </btn>
        @error('release.full_image')<span class="error">{{ $message }}</span> @enderror

        <div class="">
            <div class="">
                <label for="artist">Artist</label>
                <br>
                <input type="text" class="" name="artist" id="artistEdit" wire:model="release.artist">
                @error('release.artist') <span class="error">{{ $message }}</span> @enderror
            </div>
            <div class="">
                <label for="title">Title</label>
                <br>
                <input type="text" class="" name="title" id="titleEdit" wire:model="release.title">
                @error('release.title') <span class="error">{{ $message }}</span> @enderror
            </div>
            <div class="">
                <label for="release_year">Release Year</label>
                <br>
                <input type="number" class="" name="release_year" id="releaseYearEdit"
                       wire:model="release.release_year">
                @error('release.release_year') <span class="error">{{ $message }}</span> @enderror
            </div>
            <div class="">
                <label for="shelf_order">Shelf Position</label>
                <br>
                <input type="number" class="" id="shelfOrderEdit" min="1"
                       wire:model="release.shelf_order">
                @error('release.shelf_order') <span class="error">{{ $message }}</span> @enderror
            </div>
            <div class="">
                <label for="genre">Genre</label>
                <br>
                <select class="" wire:model="release.genre_id">
                    <option selected="selected">Choose a Genre...</option>
                    @foreach($allGenres as $genreItem)
                        <option value="{{$genreItem->id}}">{{$genreItem->name}}</option>
                    @endforeach
                    <option value="add-modal">Add Genre...</option>
                </select>
                @error('release.genre_id') <span class="error">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="">
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
    <div class="absolute hidden top-0 left-0 bg-gray-500/50 items-center grid h-screen w-screen" id="genreModal"
         tabindex="-1"
         role="dialog"
         aria-labelledby="detailsModal"
         aria-hidden="true">
        <div class="mx-auto my-auto bg-white w-1/4">
            <div class="h-2/4 p-2 shadow-lg">
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

