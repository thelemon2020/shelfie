<div>
    <form wire:submit.prevent="submit">
        <div class="flex justify-around text-center">
            <div>
                <label for="sort-method">Sort Method</label>
                <br>
                <select class="rounded rounded-lg" id="sort-method" wire:model="userSettings.sort_method">
                    <option selected="selected">Choose a Sorting Method...</option>
                    <option value="artist">Artist</option>
                    <option value="title">Title</option>
                    <option value="genre_id">Genre</option>
                    <option value="release_year">Release Year</option>
                    <option value="custom">Custom</option>
                </select>
            </div>
            @error('userSettings.sort_method') <span class="error">{{ $message }}</span> @enderror

            <div>
                <label for="sortOrderRadio">Sort Order</label>
                <div id="sortOrderRadio" class="form-check form-check-inline">
                    <input type="radio"
                           wire:model="userSettings.sort_order"
                           id="order1"
                           value="asc">
                    <label for="order1">
                        Ascending
                    </label>
                    <input type="radio" class="ml-2" wire:model="userSettings.sort_order"
                           id="order2"
                           value="desc">
                    <label for="order2">
                        Descending
                    </label>
                    <input type="radio" class="ml-2" wire:model="userSettings.sort_order"
                           id="order3"
                           value="custom">
                    <label for="order3">
                        Custom
                    </label>
                </div>
                @error('userSettings.sort_order') <span class="error">{{ $message }}</span> @enderror
            </div>
        </div>
        <button class="p-4 bg-blue-500 rounded-lg text-xs text-white" wire:click="submit">Submit</button>
    </form>
</div>
