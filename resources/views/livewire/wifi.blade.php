<div>
    <form wire:submit.prevent="submit">
        @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif
        @error('connection')
        <div class="alert alert-danger">{{ $message }}</div> @enderror
        <div wire:loading.remove wire:target="submit">
            <div class="row mb-2">
                <div class="col-auto">
                    <label for="ssid">Wifi Network Name</label>
                    <br>
                    <select class="form-control ml-1" wire:model="ssid">
                        <option selected value="">Choose a Network</option>
                        @foreach($networks as $network)
                            <option value={{$network}}>{{$network}}</option>
                        @endforeach
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
