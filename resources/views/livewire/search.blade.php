<div xmlns:wire="http://www.w3.org/1999/xhtml">
    <script>
        window.addEventListener('keypress', event => {
            let element = event.target;
            element.dispatchEvent(new Event('input'));
        })

        function addRelease() {
            Livewire.emit('editRelease')
            $('#editModal').toggleClass('hidden')
        }
    </script>
    <div class="justify-between flex">
        <div class="flex flex py-2 px-4 items-center">
            <input wire:model="search" class="mr-2 text-lg leading-none border border-gray-400 rounded p-2"
                   id="searchField" type="text"
                   placeholder="Search records..." {{$sort == 'shelf_order' ? 'disabled' : ''}}/>
            <select wire:model="sort" class="mr-2 w-36 text-lg border leading-none border-gray-400 rounded p-2">
                <option value="artist">Artist</option>
                <option value="title">Title</option>
                <option value="genre">Genre</option>
                <option value="release_year">Release Year</option>
                <option value="shelf_order">Shelf Order</option>
            </select>
            <button class="bg-blue-700 p-3 rounded text-blue-100"
                    onclick="chooseRandom({{\App\Models\Release::query()->count()}})">
                <i class="fas fa-random"></i>
            </button>
        </div>
        <div class="py-2">
            <select wire:model="pagination">
                <option value=10>10</option>
                <option value=25>25</option>
                <option selected value=50>50</option>
                <option value=75>75</option>
                <option value=100>100</option>
            </select>
            <button class="text-white rounded bg-blue-700 p-2 mx-1" wire:click="refreshCollection">
                <i class="fas fa-sync"></i>
            </button>
            <button onclick="addRelease()"
                    type="button" class="text-white rounded bg-blue-700 p-2 mx-1">+
            </button>
        </div>
    </div>
    <div wire:loading.flex wire:target="refreshCollection">
        <div class="mx-auto text-center">
            <div class="spinner-border" role="status">
                <span class="sr-only">Loading...</span>
            </div>
            <div>
                <h1>Refreshing Collection</h1>
            </div>
        </div>
    </div>
    <div wire:loading.remove wire:target="refreshCollection" class="h-[calc(100vh_-_9.5rem)] overflow-y-scroll">
        <table class="w-full align-top">
            <thead class="bg-black text-white font-bold sticky top-0">
            <tr>
                <th scope="col"></th>
                <th scope="col">Artist</th>
                <th scope="col">Title</th>
                <th scope="col">Genre</th>
                @if(config('app.env') != 'raspi')
                    <th scope="col">Year</th>
                @endif
            </tr>
            </thead>
            <tbody>
            @foreach($releases as $release)
                <tr>
                    <td>
                        <img class="raspi:w-64 w-80 raspi:ml-0 ml-4 cursor-pointer"
                             onClick="getDetails({{$release->id}})"
                             src="{{$release->full_image}}"
                             alt="{{$release->artist . "-" . $release->title}}"/>
                    </td>
                    <td class="align-top text-center pt-2 ml-2">{{$release->artist}}</td>
                    <td class="align-top text-center pt-2">{{$release->title}}</td>
                    <td class="align-top text-center pt-2">{{$release->genre->name ?? "Uncategorized"}}</td>
                    @if(config('app.env') != 'raspi')
                        <td class="align-top text-center pt-2">{{$release->release_year}}</td>
                    @endif
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div wire:loading.remove wire:target="refreshCollection">
        {{ $releases->links() }}
    </div>
</div>

