<div>
    <script>
        window.addEventListener('add-genre', event => {
            $('#genreModal').toggleClass('hidden')
        })
        window.addEventListener('open-image-modal', event => {
            const elementsToRemove = $('#image-content').children('img');
            console.log('here', elementsToRemove)
            for (let i = 0; i < elementsToRemove.length; i++) {
                elementsToRemove[i].remove()
            }
            $('#imageModal').toggleClass('hidden')
        })
    </script>
    <form class="grid grid-cols-2 raspi:grid-cols-1" wire:submit.prevent="submit">
        <div class="mr-2">
            <label>Cover Image</label>
            <br>
            <img class="raspi:w-48" :wire:key="$full_image" id="coverImage" src="{{$full_image}}" alt="">
            <br>
            <btn class="w-full px-6 py-2 mt-4 text-white bg-blue-600 rounded-lg hover:bg-blue-900"
                 wire:click="loadImages">
                Change Cover Image
            </btn>
            @error('release.full_image')<span class="error">{{ $message }}</span> @enderror
        </div>
        <div class="w-2/4 raspi:flex">
            <div class="raspi:pr-2">
                <label class="block" for="artist">Artist</label>
                <input type="text" name="artist" id="artistEdit" wire:model="release.artist">
                @error('release.artist') <span class="error">{{ $message }}</span> @enderror


                <label class="block" for="title">Title</label>
                <input type="text" name="title" id="titleEdit" wire:model="release.title">
                @error('release.title') <span class="error">{{ $message }}</span> @enderror

                <label class="block" for="release_year">Release Year</label>
                <input type="number" name="release_year" id="releaseYearEdit"
                       wire:model="release.release_year">
                @error('release.release_year') <span class="error">{{ $message }}</span> @enderror
            </div>
            <div class="raspi:pl-2">
                <label class="block" for="shelf_order">Shelf Position</label>
                <input type="number" id="shelfOrderEdit" min="1"
                       wire:model="release.shelf_order">
                @error('release.shelf_order') <span class="error">{{ $message }}</span> @enderror

                <label class="block" for="genre">Genre</label>
                <select wire:model="genre" class="overflow-hidden">
                    <option selected="selected">Choose a Genre...</option>
                    @foreach($allGenres as $genreItem)
                        <option value="{{$genreItem->id}}">{{$genreItem->name}}</option>
                    @endforeach
                    <option value="add-modal">Add Genre...</option>
                </select>
                @error('release.genre_id') <span class="error">{{ $message }}</span> @enderror
            </div>
        </div>

        <input class="col-span-2 py-2 mt-4 text-center text-white bg-blue-600 rounded-lg hover:bg-blue-900"
               type="submit" wire:click="submit">
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
    <x-genre-modal></x-genre-modal>
    <x-image-modal></x-image-modal>
</div>

