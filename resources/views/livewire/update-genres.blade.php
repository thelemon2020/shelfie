<div style="min-width: 10%">
    <li class="list-group-item d-flex justify-content-center align-items-center">
        <input type="text" class="form-control" wire:model="genre.name">
        <div class="d-flex flex-column text-center ml-1">
            <select wire:model="genre.shelf_order">
                @for($i = 1; $i <= count(\App\Models\Genre::all()); $i++)
                    <option value="{{$i}}">{{$i}}</option>
                @endfor
            </select>
            <input type="color" wire:model="genre.colour">
        </div>
    </li>
</div>
