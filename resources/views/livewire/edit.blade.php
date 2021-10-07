<form class="col-lg-6 offset-lg-3" wire:submit.prevent="submit">
    <div class="row justify-content-center">
        <div class="col-6">
            <label>Cover Image</label>
            <br>
            <img id="coverImage" class="img-fluid" src="{{$release->full_image ?? ''}}">
            <br>
            <btn class="btn btn-primary mt-2" onclick="invoke()" data-toggle="modal"
                 data-target="#imageModal">Change Cover Image
            </btn>
            @error('release.full_image')<span class="error">{{ $message }}</span> @enderror
        </div>
        <div class="col-6 align-self-center">
            <div class="form-group">
                <label for="artist">Artist</label>
                <br>
                <input type="text" class="form-control" name="artist" id="artist" wire:model="release.artist">
                @error('release.artist') <span class="error">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label for="title">Title</label>
                <br>
                <input type="text" class="form-control" name="title" id="title" wire:model="release.title">
                @error('release.title') <span class="error">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label for="release_year">Release Year</label>
                <br>
                <input type="number" class="form-control" name="release_year" id="release_year"
                       wire:model="release.release_year">
                @error('release.release_year') <span class="error">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label for="shelf_order">Shelf Position</label>
                <br>
                <input type="number" class="form-control-sm" id="shelf_order" min="1"
                       wire:model="release.shelf_order">
                @error('release.shelf_order') <span class="error">{{ $message }}</span> @enderror
            </div>
            <input type="hidden" id='thumbnail' name="thumbnail" wire:model="release.thumbnail">
            <input type="hidden" id='full_image' name="full_image" wire:model="release.full_image">
        </div>
    </div>
    <div class="row justify-content-center">
        <input type="submit">
    </div>
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif
    @if (session()->has('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
</form>

