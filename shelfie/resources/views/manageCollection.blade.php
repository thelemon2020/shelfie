<x-navbar></x-navbar>
<div class="container">
    <div class="d-flex justify-content-center">
        <h2>Set Shelf Order</h2>
    </div>
        <form>
            @csrf
            <div class="row justify-content-center">
                <ul class="d-flex list-group list-group-horizontal  align-content-stretch">
                    @foreach($genres as $genre)
                        <div>
                            <li class="list-group-item align-items-stretch">
                                <div class="overflow-none text-nowrap d-flex flex-column">{{$genre->name}}</div>
                                <div class="d-block flex-column">
                                    <select>
                                        @for($i = 0; $i < count($genres); $i++)
                                            @if($genre->shelf_order == $i +1)
                                                <option selected>{{$i + 1}}</option>
                                            @else
                                                <option>{{$i + 1}}</option>
                                            @endif
                                        @endfor
                                    </select>
                                </div>
                            </li>
                        </div>
                    @endforeach
                </ul>
                <input>
            </div>
        </form>
    </div>
