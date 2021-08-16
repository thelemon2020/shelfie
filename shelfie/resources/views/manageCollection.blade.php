<x-navbar></x-navbar>
<div>
    <ul>
        @foreach($genres as $genre)
            <li>{{$genre->name}}</li>
        @endforeach
    </ul>
</div>
