<x-navbar></x-navbar>
<div class="container">
    <div class="text-center">
        <h1>{{$release->artist }} - {{$release->title}}</h1>
    </div>
</div>
<div class="container text-center">
    <div class="row">
        <div class="col-auto align-items-md-center">
            <img src={{$release->full_image}}>
        </div>
        <div class="col-auto align-self-center">
            <label>Times Played</label>
            <p>{{$release->times_played ?? 0}}</p>
            <label>Last Played At</label>
            <p>{{$release->last_played_at ?? "Never"}}</p>
        </div>
    </div>
    <div class="row">
        <div class="col-auto align-self-center">
            <button class="btn btn-primary">Play</button>
            <button class="btn btn-primary">Edit</button>
        </div>
    </div>
</div>
