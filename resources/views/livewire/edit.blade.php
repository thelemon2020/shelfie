<div>
    <script>
        window.addEventListener('add-genre', event => {
            $('#genreModal').toggleClass('hidden')
        })
        window.addEventListener('add-subgenre', event => {
            console.log('here')
            $('#subgenreModal').toggleClass('hidden')
        })
        window.addEventListener('open-image-modal', event => {
            const elementsToRemove = $('#image-content').children('img');
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
        </div>
        <div class="w-2/4 raspi:flex">
            <div class="raspi:pr-2">
                <label class="block" for="artist">Artist</label>
                <input type="text" name="artist" id="artistEdit" wire:model="release.artist">
                <label class="block" for="title">Title</label>
                <input type="text" name="title" id="titleEdit" wire:model="release.title">
                <label class="block" for="release_year">Release Year</label>
                <input type="number" name="release_year" id="releaseYearEdit"
                       wire:model="release.release_year">
            </div>
            <div class="raspi:pl-2 pt-4">
                <label class="block" for="genre">Primary Genres</label>
                <select wire:model="genre" class="overflow-hidden">
                    <option selected="selected">Choose a Genre...</option>
                    @foreach($allGenres as $genreItem)
                        <option @if(!$genres?->where('id',$genreItem->id)->isEmpty()) disabled
                                @endif value="{{$loop->index}}">{{$genreItem->name}}</option>
                    @endforeach
                    <option value="add-modal">Add Genre...</option>
                </select>
                @if($genres)
                    <div class="flex flex-row">
                        @foreach($genres as $genre)
                            <span class="text-red-700 cursor-pointer" :wire:key="'genre-'{{$genre->id}}"
                                  wire:click="removeGenre({{$genre->id}})">
                            {{$genre->name}}&nbsp;
                        </span>
                        @endforeach
                    </div>
                @endif
                <label class="block" for="subgenre">Secondary Genres</label>
                <select wire:model="subgenre" class="overflow-hidden">
                    <option selected="selected">Choose a Subgenre...</option>
                    @foreach($allSubgenres as $subgenreItem)
                        <option @if(!$subgenres?->where('id',$subgenreItem->id)->isEmpty()) disabled
                                @endif value="{{$loop->index}}">{{$subgenreItem->name}}</option>
                    @endforeach
                    <option value="add-modal">Add Subgenre...</option>
                </select>
                @if($subgenres)
                    <div class="flex flex-row">
                        @foreach($subgenres as $subgenre)
                            <span class="text-red-700 cursor-pointer" :wire:key="'subgenre-'{{$subgenre->id}}"
                                  wire:click="removeSubgenre({{$subgenre->id}})">
                                {{$subgenre->name}}&nbsp;
                            </span>
                        @endforeach
                    </div>
                @endif
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
    <x-subgenre-modal></x-subgenre-modal>
</div>

