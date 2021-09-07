<x-navbar></x-navbar>
<div class="row">
    <div class="col-3">
        <a class="btn btn-primary" href="{{session()->previousUrl()}}">Back</a>
    </div>
    <div class="col-6">
        <div class="text-center">
            <h1>{{$release->artist }} - {{$release->title}}</h1>
        </div>
    </div>
</div>
<div class="container text-center">
    <div class="row">
        <div class="col-auto align-items-md-center">
            <img src={{$release->thumbnail}}>
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
