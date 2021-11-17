<div style="min-width: 10%">
    <li class="list-group-item d-flex justify-content-center align-items-center">
        <button type="button" wire:click="deleteGenre" class="close mr-3 text-danger" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <input type="text" class="form-control" wire:model="genre.name">
    </li>
</div>
