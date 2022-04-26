<div class="text-center">
    <form wire:submit.prevent="submit">
        <input type="text" class="mr-2 text-lg leading-none border border-gray-400 mt-2 rounded px-4 py-2" name="genre"
               id="genre" wire:model="genre">
        @error('genre') <span class="error"><strong>{{ $message }}</strong></span> @enderror
        <div class="flex justify-between p-2">
            <button type="button" class="px-6 py-2 mt-2 text-white bg-blue-600 rounded-lg hover:bg-blue-900"
                    data-dismiss="modal">Close
            </button>
            <button type="button" wire:click="submit"
                    class="px-6 py-2 mt-2 text-white bg-blue-600 rounded-lg hover:bg-blue-900">
                Add
            </button>
        </div>
    </form>
</div>
