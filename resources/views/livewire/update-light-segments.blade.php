<div style="min-width: 10%">
    <li class="list-group-item d-flex justify-content-center align-items-center">
        <button type="button" wire:click="deleteSegment" class="close mr-3 text-danger" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <input type="text" class="form-control" wire:model="segment.name">
        <div class="d-flex flex-column text-center ml-1">
            <select wire:model="segment.shelf_order">
                @for($i = 1; $i <= count(\App\Models\Genre::all()) + 1; $i++)
                    <option value="{{$i}}">{{$i}}</option>
                @endfor
            </select>
            <input type="color" wire:model="segment.colour">
        </div>
    </li>
</div>
