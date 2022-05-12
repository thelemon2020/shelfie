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
            <select wire:model="sort" class="mr-2 text-lg border leading-none border-gray-400 rounded p-2">
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
    <div wire:loading.remove wire:target="refreshCollection" class="h-[83vh] raspi:h-[66vh] overflow-y-scroll">
        <table class="w-full align-top">
            <thead class="bg-black text-white font-bold sticky top-0">
            <tr>
                <th scope="col"></th>
                <th scope="col"></th>
                <th scope="col">Artist</th>
                <th scope="col">Title</th>
                <th scope="col">Genre</th>
                <th scope="col">Year</th>
            </tr>
            </thead>
            <tbody>
            @foreach($releases as $release)
                <tr>
                    <td class="w-48 raspi:w-24 text-center">
                        <button
                            onClick="getDetails({{$release->id}})">
                            <svg xmlns="http://www.w3.org/2000/svg" class="raspi:h-16 raspi:w-16 h-32 w-32"
                                 viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                      d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                      clip-rule="evenodd"/>
                            </svg>
                        </button>
                    </td>
                    <td>
                        <img class="raspi:w-64 w-80"
                             src="{{$release->full_image}}"
                             alt="{{$release->artist . "-" . $release->title}}"/>
                    </td>
                    <td class="align-top text-center pt-2">{{$release->artist}}</td>
                    <td class="align-top text-center pt-2">{{$release->title}}</td>
                    <td class="align-top text-center pt-2 raspi:break-all">{{$release->genre->name ?? "Uncategorized"}}</td>
                    <td class="align-top text-center pt-2">{{$release->release_year}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    {{ $releases->links() }}
</div>

