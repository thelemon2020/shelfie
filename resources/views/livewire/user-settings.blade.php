<div>
    <form wire:submit.prevent="submit" class="text-center">
        <div class="form-row">
            <div class="form-group">
                <label for="artist">WLED IP</label>
                <br>
                <input type="text" class="form-control" name="artist" id="artist" wire:model="userSettings.wled_ip">
                <p>Leave Blank If Not Using WLED</p>
                @error('userSettings.wled_ip') <span class="error">{{ $message }}</span> @enderror
            </div>
        </div>
        <input class="btn btn-primary" type="submit">
    </form>
</div>
