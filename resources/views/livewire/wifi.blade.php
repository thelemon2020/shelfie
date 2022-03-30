<div>
    <form wire:submit.prevent="submit">
        @error('connection')
        <div class="alert alert-danger">{{ $message }}</div> @enderror
        <div wire:loading.remove wire:target="getNetworks">
            <div class="row mb-2">
                <div class="col-auto mt-4">
                    <button class="btn btn-primary" wire:click="getNetworks"><i class="fas fa-redo"></i></button>
                </div>
                <div class="col-auto">

                    <label for="ssid">Wifi Network Name</label>
                    <br>

                    <input type="text" class="mr-2 text-lg leading-none border border-gray-400 rounded px-4 py-2"
                           wire:model="ssid" name="ssid" id="wifi_ssid">

                </div>
                <div class="col-auto">
                    <label for="SSID">Wifi Password</label>
                    <br>
                    <input type="password" class="mr-2 text-lg leading-none border border-gray-400 rounded px-4 py-2"
                           wire:model="password" name="wifi_password"
                           id="wifi_password">
                </div>
            </div>
            <div class="flex justify-between">
                <button type="button" class="p-4 bg-blue-500 rounded-lg text-white" onclick="toggleWifiModal()">
                    Close
                </button>

                <button type="submit" class="p-4 bg-blue-500 rounded-lg text-white">
                    Connect
                </button>
            </div>
        </div>
            <div wire:loading.flex wire:target="submit">
                <div class="mx-auto text-center">
                    <div class="spinner-border" role="status">
                        <span class="sr-only">Connecting...</span>
                    </div>
                    <div>
                    <h1>Trying To Connect</h1>

                </div>
            </div>
        </div>
    </form>
</div>
