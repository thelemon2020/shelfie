<div>
    <form wire:submit.prevent="submit" class="text-center">
        <div class="container">
            <div class="row">
                <div class="col w-50">
                    <div class="form-group">
                        <label for="sort-method">Sort Method</label>
                        <br>
                        <div class="dropdown show">
                            <select class="form-control ml-1" id="sort-method" wire:model="userSettings.sort_method">
                                <option selected="selected">Choose a Sorting Method...</option>
                                <option value="artist">Artist</option>
                                <option value="title">Title</option>
                                <option value="genre_id">Genre</option>
                                <option value="release_year">Release Year</option>
                                <option value="custom">Custom</option>
                            </select>
                        </div>
                        @error('userSettings.sort_method') <span class="error">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col w-50 align-content-center ml-2">
                    <label for="sortOrderRadio">Sort Order</label>
                    <div id="sortOrderRadio" class="mt-1">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" wire:model="userSettings.sort_order"
                                   id="order1"
                                   value="asc">
                            <label class="form-check-label" for="order1">
                                Ascending
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" wire:model="userSettings.sort_order"
                                   id="order2"
                                   value="desc">
                            <label class="form-check-label" for="order2">
                                Descending
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" wire:model="userSettings.sort_order"
                                   id="order3"
                                   value="custom">
                            <label class="form-check-label" for="order3">
                                Custom
                            </label>
                        </div>
                    </div>
                    @error('userSettings.sort_order') <span class="error">{{ $message }}</span> @enderror
                </div>
            </div>
            <input class="btn btn-primary mt-2" type="submit">
        </div>
    </form>
</div>
