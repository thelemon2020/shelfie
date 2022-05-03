<div>
    <script>
        window.addEventListener('reloadPage', event => {
            location.reload()
        })
    </script>
    <form wire:submit.prevent="submit">
        <div class="flex flex-row overflow-y-scroll mb-2">
            @foreach($genres as $genre)
                <livewire:update-genres :genre="$genre" :wire:key="$genre->id"/>
            @endforeach
            <button type="button"
                    class="flex justify-center items-center bg-blue-500 h-12 w-18 p-4 mt-1 rounded rounded-lg text-white"
                    wire:click="createGenre">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                     class="bi bi-plus-circle" viewBox="0 0 16 16">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                    <path
                        d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                </svg>
            </button>
        </div>
        <button type="submit" class="bg-blue-500 rounded p-4 rounded-md mb-1 text-lg text-white">Submit</button>
    </form>
</div>
