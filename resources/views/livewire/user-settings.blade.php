<div>
    <form wire:submit.prevent="submit" class="flex justify-around items-center py-2">
        <div>
            <label for="wled">WLED IP</label>
            <br>
            <input type="text" class="mr-2 text-lg leading-none border border-gray-400 rounded px-4 py-2" name="wled"
                   id="wled" wire:model="userSettings.wled_ip">
            <p>Leave Blank If Not Using WLED</p>
            @error('userSettings.wled_ip') <span class="error">{{ $message }}</span> @enderror
            <input class="p-4 bg-blue-500 rounded-lg text-xs text-white" type="submit">
        </div>
        <div>
            <button type="button" class="p-4 bg-blue-500 rounded-lg text-xs text-white" onclick="openWifiModal()">
                Connect To Wifi
            </button>

        </div>
    </form>
    <x-wifi></x-wifi>
    <script>
        function openWifiModal() {
            $('#wifiModal').toggleClass('hidden');
        }
    </script>
</div>

