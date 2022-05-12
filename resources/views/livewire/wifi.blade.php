<div>
    <script>
        function changeLoadingMessage(message) {
            $('#loadingMessage').empty();
            $('#loadingMessage').append(message);
        }
    </script>
    <form wire:submit.prevent="submit">
        <div wire:loading.remove wire:target="submit">
            <div class="row mb-2">
                <div class="ml-7">
                    <label for="ssid">Wifi Network Name</label>
                    <br>
                    <select class="text-lg leading-none border w-60 border-gray-400 rounded px-2 py-2"
                            wire:model="ssid">
                        <option selected value="">Choose Network</option>
                        @if ($networks)
                            @foreach($networks as $network)
                                <option value={{$network}}>{{$network}}</option>
                            @endforeach
                        @endif
                    </select>
                    <button class="mr-4" wire:click="getNetworks"
                            onclick="changeLoadingMessage('Scanning For Networks')"><i class="fas fa-redo"></i></button>
                </div>
                <div>
                    <label for="SSID">Wifi Password</label>
                    <br>
                    <input type="password" class="mr-2 text-lg leading-none border border-gray-400 rounded px-4 py-2"
                           wire:model="password" name="wifi_password"
                           id="wifi_password">
                </div>
                @error('connection')
                <div class="text-red-700">{{ $message }}</div> @enderror
            </div>
            <div class="mx-auto">
                <button type="submit" onclick="changeLoadingMessage('Attempting To Connect')"
                        class="p-4 bg-blue-500 rounded-lg text-white">
                    Connect
                </button>
            </div>
        </div>
        <div wire:loading.flex>
            <div class="mx-auto text-center">
                <div class="spinner-border" role="status">
                    <span class="sr-only">Connecting...</span>
                </div>
                <div>
                    <h1 id="loadingMessage"></h1>
                </div>
            </div>
        </div>
    </form>
</div>
