<div>

    <form wire:submit.prevent="submit" class="flex justify-around items-center py-2">
        <div>
            <label for="wled">WLED IP</label>
            <br>
            <input type="text" class="mr-2 text-lg leading-none border border-gray-400 rounded px-4 py-2" name="wled"
                   id="wled" wire:model="userSettings.wled_ip">
            <p>Leave Blank If Not Using WLED</p>
            @error('userSettings.wled_ip') <span class="error">{{ $message }}</span> @enderror
            <input class="p-4 bg-blue-500 rounded-lg cursor-pointer text-white" type="submit">
        </div>
        <div>
            <button type="button" class="p-4 bg-blue-500 rounded-lg text-white" onclick="toggleWifiModal()">
                Connect To Wifi
            </button>

        </div>
    </form>
    <div class="col-auto ms-2 mb-3">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                data-bs-target="#wifiModal">
            Connect To Wifi
        </button>
    </div>
    <x-wifi></x-wifi>
    <script>
        function toggleWifiModal() {
            $('#wifiModal').toggleClass('hidden');
        }
    </script>
</div>

