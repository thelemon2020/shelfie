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
                        <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px"
                             width="24" height="24"
                             viewBox="0 0 24 24"
                             style=" fill:#000000;">
                            <path
                                d="M 7.1601562 3 L 8.7617188 5 L 19 5 L 19 15 L 16 15 L 20 20 L 24 15 L 21 15 L 21 3 L 7.1601562 3 z M 4 4 L 0 9 L 3 9 L 3 21 L 16.839844 21 L 15.238281 19 L 5 19 L 5 9 L 8 9 L 4 4 z"></path>
                        </svg>
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
    <div wire:loading.remove wire:target="refreshCollection">
        <table class="table">
            <thead>
            <tr>
                <th class="w-25" scope="col">Image</th>
                <th scope="col">Artist</th>
                <th scope="col">Title</th>
                <th scope="col">Genre</th>
                <th scope="col">Year</th>
            </tr>
            </thead>
            <tbody>
            @foreach($releases as $release)
                <tr>
                    <td>
                        <img class="img-thumbnail img-fluid w-50"
                             onClick="invoke({{$release->id}})"
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
        {{ $releases->links() }}
    </div>
</div>
