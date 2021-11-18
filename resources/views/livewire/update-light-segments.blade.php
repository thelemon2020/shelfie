<div style="min-width: 10%">
    <li class="list-group-item">
        <button type="button" wire:click="deleteSegment" class="close text-danger" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <label for="segment-name">Segment Name</label>
        <input type="text" id="segment-name" class="form-control" wire:model="segment.name">
        <div class="d-flex flex-column ml-auto mr-auto">
            <label for="segment-shelf-order">Shelf Order</label>
            <select id="segment-shelf-order" wire:model="segment.shelf_order"
                    @if(\App\Models\User::all()->first()->userSettings->sort_order != 'custom') disabled @endif>
                @for($i = 1; $i <= count(\App\Models\LightSegment::all()) + 1; $i++)
                    <option value="{{$i}}">{{$i}}</option>
                @endfor
            </select>
            <label for="segment-size">Size</label>
            <input type="number" id='segment-size' wire:model="segment.size"
                   @if(\App\Models\User::all()->first()->userSettings->sort_method != 'custom') disabled @endif>
            <input type="color" class="mt-2" wire:model="segment.colour">
        </div>
    </li>
</div>
