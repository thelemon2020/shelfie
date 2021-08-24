<x-navbar></x-navbar>
<br>
<div>
    <a  class="btn btn-primary" href="{{route('collection.index')}}">Return to Collection</a>
</div>
<div class="container">
    <div class="d-flex justify-content-center">
        <h2>Set Shelf Order</h2>
    </div>
    <form action="{{route('collection.manage.shelf')}}" method="post">
        @csrf
        <div class="row justify-content-center">
            <ul class="d-flex list-group list-group-horizontal align-content-stretch">
                @foreach($genres as $genre)
                    <div>
                        <li class="list-group-item align-items-stretch">
                            <input type="hidden"  name="genreNames[]" value="{{$genre->name}}">
                            <div class="overflow-none text-nowrap d-flex flex-column">{{$genre->name}}</div>
                            <div class="d-block flex-column">
                                <select name="genreShelfOrder[]">
                                    @for($i = 0; $i < count($genres); $i++)
                                        @if($genre->shelf_order == $i +1)
                                            <option selected value="{{$i +1}}">{{$i + 1}}</option>
                                        @else
                                            <option value="{{$i +1}}">{{$i + 1}}</option>
                                        @endif
                                    @endfor
                                </select>
                            </div>
                        </li>
                    </div>
                @endforeach
            </ul>
            <input type="submit" class="btn btn-primary d-flex"></input>
        </div>
    </form>
</div>
