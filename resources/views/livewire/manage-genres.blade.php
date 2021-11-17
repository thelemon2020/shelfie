<div class="m-4">
    <script>
        window.addEventListener('reloadPage', event => {
            location.reload()
        })
    </script>
    <div class="d-inline text-center">
        <form wire:submit.prevent="submit">
            <ul class="d-flex flex-wrap list-group-horizontal">
                @foreach($genres as $genre)
                    <livewire:update-genres :genre="$genre" :wire:key="$genre->id"/>
                @endforeach
                <li class="d-flex justify-content-center align-items-center" style="width: 18%">
                    <button type="button" class="btn btn-primary" wire:click="createGenre">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                             class="bi bi-plus-circle" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                            <path
                                d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                        </svg>
                        Add Genre
                    </button>
                </li>
            </ul>
            <button type="submit" class="btn btn-primary mt-1">Submit</button>
        </form>
    </div>
</div>
