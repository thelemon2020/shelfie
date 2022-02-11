<div>
    <form wire:submit.prevent="submit" class="text-center">
        <div class="form-row ">
            <div class="form-group d-flex justify-content-center align-items-center">
                <div class="col-auto">
                    <label for="wled">WLED IP</label>
                    <br>
                    <input type="text" class="form-control" name="wled" id="wled" wire:model="userSettings.wled_ip">
                    <p>Leave Blank If Not Using WLED</p>
                    @error('userSettings.wled_ip') <span class="error">{{ $message }}</span> @enderror
                </div>
            </div>
            <input class="btn btn-primary" type="submit">
        </div>
    </form>
    <div class="col-auto ms-2 mb-3">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                data-bs-target="#wifiModal">
            Connect To Wifi
        </button>
    </div>
    <x-wifi></x-wifi>
</div>

