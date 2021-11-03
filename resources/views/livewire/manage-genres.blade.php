<div class="m-4">
    <script>
        window.addEventListener('reloadPage', event => {
            location.reload()
        })
    </script>
    <div class="text-center">
        <h2>Edit Genres</h2>
    </div>
    <div class="d-inline text-center">
        <form wire:submit.prevent="submit">
            <ul class="d-flex flex-wrap list-group-horizontal">
                @foreach($genres as $genre)
                    <livewire:update-genres :genre="$genre" :wire:key="$genre->id"/>
                @endforeach
            </ul>
            <input type="submit" class="btn btn-primary mt-1"/>
        </form>
    </div>
</div>
