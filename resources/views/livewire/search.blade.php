<div xmlns:wire="http://www.w3.org/1999/xhtml">
    <div style="display: flex; justify-content: space-between">
        <div class="d-flex m-1">
            <input wire:model="search" type="text"
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
                <div class="dropdown show mr-1">
                    <select class="form-control" wire:model="pagination">
                        <option value=10>10</option>
                        <option value=25>25</option>
                        <option selected value=50>50</option>
                        <option value=75>75</option>
                        <option value=100>100</option>
                    </select>
                </div>
                <a href="{{route('collection.manage.index')}}" type="button" class="btn btn-info">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                         class="bi bi-gear"
                         viewBox="0 0 16 16">
                        <path
                            d="M8 4.754a3.246 3.246 0 1 0 0 6.492 3.246 3.246 0 0 0 0-6.492zM5.754 8a2.246 2.246 0 1 1 4.492 0 2.246 2.246 0 0 1-4.492 0z"/>
                        <path
                            d="M9.796 1.343c-.527-1.79-3.065-1.79-3.592 0l-.094.319a.873.873 0 0 1-1.255.52l-.292-.16c-1.64-.892-3.433.902-2.54 2.541l.159.292a.873.873 0 0 1-.52 1.255l-.319.094c-1.79.527-1.79 3.065 0 3.592l.319.094a.873.873 0 0 1 .52 1.255l-.16.292c-.892 1.64.901 3.434 2.541 2.54l.292-.159a.873.873 0 0 1 1.255.52l.094.319c.527 1.79 3.065 1.79 3.592 0l.094-.319a.873.873 0 0 1 1.255-.52l.292.16c1.64.893 3.434-.902 2.54-2.541l-.159-.292a.873.873 0 0 1 .52-1.255l.319-.094c1.79-.527 1.79-3.065 0-3.592l-.319-.094a.873.873 0 0 1-.52-1.255l.16-.292c.893-1.64-.902-3.433-2.541-2.54l-.292.159a.873.873 0 0 1-1.255-.52l-.094-.319zm-2.633.283c.246-.835 1.428-.835 1.674 0l.094.319a1.873 1.873 0 0 0 2.693 1.115l.291-.16c.764-.415 1.6.42 1.184 1.185l-.159.292a1.873 1.873 0 0 0 1.116 2.692l.318.094c.835.246.835 1.428 0 1.674l-.319.094a1.873 1.873 0 0 0-1.115 2.693l.16.291c.415.764-.42 1.6-1.185 1.184l-.291-.159a1.873 1.873 0 0 0-2.693 1.116l-.094.318c-.246.835-1.428.835-1.674 0l-.094-.319a1.873 1.873 0 0 0-2.692-1.115l-.292.16c-.764.415-1.6-.42-1.184-1.185l.159-.291A1.873 1.873 0 0 0 1.945 8.93l-.319-.094c-.835-.246-.835-1.428 0-1.674l.319-.094A1.873 1.873 0 0 0 3.06 4.377l-.16-.292c-.415-.764.42-1.6 1.185-1.184l.292.159a1.873 1.873 0 0 0 2.692-1.115l.094-.319z"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>
    <div wire:loading.remove>
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
                        <img class="img-thumbnail img-fluid" style="width: 250px; height: 250px"
                             onClick="invoke({{$release->id}})"
                             src="{{$release->full_image}}"
                             alt="{{$release->artist . "-" . $release->title}}"/>
                    </td>
                    <td>{{$release->artist}}</td>
                    <td>{{$release->title}}</td>
                    <td>{{$release->genre->name}}</td>
                    <td>{{$release->release_year}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $releases->links() }}
    </div>
    <div class="d-inline text-center" wire:loading wire:target="refreshCollection">
        <div>
            <div class="spinner-border" role="status">
                <span class="sr-only">Loading...</span>
            </div>
            <div>
                <h1>Refreshing Collection</h1>
            </div>
        </div>
    </div>
</div>
