<div>
    <form wire:submit.prevent="submit">
        <div class="form-group">
            <label for="genre">Add a Genre</label>
            <br>
            <input type="text" class="form-control" name="genre" id="genre" wire:model="genre">
            @error('genre') <span class="error"><strong>{{ $message }}</strong></span> @enderror
        </div>
        <div class="modal-footer">
            <div class="mr-auto">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
            <div class="align-self-end">
                <button type="button" wire:click="submit" data-dismiss="modal" class="btn btn-primary">
                    Add
                </button>
            </div>
        </div>
    </form>
</div>
