<div class="m-1 border border-gray-500 shadow-lg relative">
    <button wire:click="deleteSegment" type="button" class="absolute top-0 left-0 text-red-500 pl-4" aria-label="Close">
        X
    </button>
    <div class="grid grid-rows-4 items-center pt-4 ml-2">
        <div>
            <label for="segment-name">Segment Name</label>
            <input type="text" id="segment-name"
                   class="mr-2 text-lg leading-none border border-gray-400 rounded px-4 py-2"
                   wire:model="segment.name">
        </div>
        <div>
            <label for="segment-shelf-order">Shelf Order</label>
            <br>
            <select id="segment-shelf-order" wire:model="segment.shelf_order"
                    @if(\App\Models\User::all()->first()->userSettings->sort_order != 'custom') disabled @endif>
                @for($i = 1; $i <= count(\App\Models\LightSegment::all()) + 1; $i++)
                    <option value="{{$i}}">{{$i}}</option>
                @endfor
            </select>
        </div>
        <div>
            <label for="segment-size">Size</label>
            <br>
            <input type="number" class="mr-2 text-lg leading-none border border-gray-400 rounded px-4 py-2"
                   id='segment-size' wire:model="segment.size"
                   @if(\App\Models\User::all()->first()->userSettings->sort_method != 'custom') disabled @endif>
        </div>
        <div>
            <label for="segment-colour">Light Colour</label>
            <br>
            <input type="color" id="segment-colour" wire:model="segment.colour">
        </div>
    </div>
</div>
