<div xmlns:wire="http://www.w3.org/1999/xhtml">
    <script>
        window.addEventListener('keypress', event => {
            let element = event.target;
            element.dispatchEvent(new Event('input'));
        })
    </script>
    <div style="display: flex; justify-content: space-between">
        <div class="d-flex m-1">
            <input wire:model="search" id="searchField" type="text"
                   placeholder="Search records..." {{$sort == 'shelf_order' ? 'disabled' : ''}}/>
            <div class="dropdown show">
                <select class="form-control ml-1" wire:model="sort">
                    <option value="artist">Artist</option>
                    <option value="title">Title</option>
                    <option value="genre">Genre</option>
                    <option value="release_year">Release Year</option>
                    <option value="shelf_order">Shelf Order</option>
                </select>
            </div>
            <button class="btn btn-primary ml-2" onclick="chooseRandom({{\App\Models\Release::query()->count()}})">
                <i class="fas fa-random"></i>
            </button>
        </div>
        <div>
            <div class="d-flex mr-1">
                <div class="dropdown show mr-1">
                    <select class="form-control" wire:model="pagination">
                        <option value=10>10</option>
                        <option value=25>25</option>
                        <option selected value=50>50</option>
                        <option value=75>75</option>
                        <option value=100>100</option>
                    </select>
                </div>
                @if(\App\Models\User::all()->first->discogs_username)
                    <button class="btn btn-primary mr-2" wire:click="refreshCollection">
                        <i class="fas fa-sync"></i>
                    </button>
                @else()
                    <a href="{{route('release.create')}}"
                       type="button" class="btn btn-info mr-1">+</a>
                @endif
            </div>
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
    <div wire:loading.remove wire:target="refreshCollection" style="overflow-y: auto; height: 80vh">
        <table class="table">
            <thead style="position: sticky; top: 0">
            <tr>
                <th style="background-color: black; color: white" scope="col"></th>
                <th style="background-color: black; color: white" class="w-25" scope="col"></th>
                <th style="background-color: black; color: white" scope="col">Artist</th>
                <th style="background-color: black; color: white" scope="col">Title</th>
                <th style="background-color: black; color: white" scope="col">Genre</th>
                <th style="background-color: black; color: white" scope="col">Year</th>
            </tr>
            </thead>
            <tbody>
            @foreach($releases as $release)
                <tr>
                    <td class="align-middle">
                        <i class="fas fa-info-circle fa-5x p-2" style="cursor: pointer"
                           onClick="getDetails({{$release->id}})"></i>
                    </td>
                    <td>
                        <img class="img-thumbnail img-fluid w-75"
                             src="{{$release->full_image}}"
                             alt="{{$release->artist . "-" . $release->title}}"/>
                    </td>
                    <td>{{$release->artist}}</td>
                    <td>{{$release->title}}</td>
                    <td>{{$release->genre->name ?? "Uncategorized"}}</td>
                    <td>{{$release->release_year}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="d-flex">
            <div class="mx-auto">
                {{ $releases->links() }}
            </div>
        </div>
    </div>
</div>
