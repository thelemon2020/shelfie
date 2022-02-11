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
                    <select class="form-control ml-1" wire:model="ssid">
                        <option selected value="">Choose a Network</option>
                        @if ($networks)
                            @foreach($networks as $network)
                                <option value={{$network}}>{{$network}}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="col-auto">
                    <label for="SSID">Wifi Password</label>
                    <br>
                    <input type="password" class="form-control" wire:model="password" name="wifi_password"
                           id="wifi_password">
                </div>
            </div>
            <div class="modal-footer">
                <div class="align-self-start">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Close
                    </button>
                </div>
                <div class="align-self-end">
                    <button type="submit" class="btn btn-primary">
                        Connect
                    </button>
                </div>
            </div>
        </div>
        <div wire:loading wire:target="getNetworks">
            <div class="mx-auto text-center">
                <div class="spinner-border" role="status">
                    <span class="sr-only">Connecting...</span>
                </div>
                <div>
                    <p>Scanning for Networks</p>
                </div>
            </div>
        </div>
    </form>
</div>
