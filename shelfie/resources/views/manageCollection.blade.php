<x-navbar></x-navbar>
<div>
    <ul>
        @foreach($genres as $genre)
            <li>{{$genre->name}}<select class="form-control">{{$genre->shelf_order}}</select></li>
        @endforeach
    </ul>
</div>
