<x-navbar></x-navbar>
<h1 class="text-center">Edit Release</h1>
<form class="col-lg-6 offset-lg-3 " method="post" action="{{route('api.release.edit', ['id'=>$release->id])}}">
    <div class="row justify-content-center">
        <div class="col-auto">
            <label>Cover Image</label>
            <br>
            <img src="{{$release->full_image}}">
            <br>
            <btn class="btn btn-primary mt-2">Change Cover Image</btn>
        </div>
        <div class="col-5 align-self-center">
            <div class="form-group">
                <label for="artist">Artist</label>
                <br>
                <input type="text" class="form-control" id="artist" value="{{$release->artist}}">
            </div>
            <div class="form-group">
                <label for="title">Title</label>
                <br>
                <input type="text" class="form-control" id="title" value="{{$release->title}}">
            </div>
            <div class="form-group">
                <label for="shelf_order">Shelf Position</label>
                <br>
                <input type="number" class="form-control-sm" id="shelf_order" min="1"
                       max="{{count(\App\Models\Release::all())}}" value="{{$release->shelf_order}}">
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <input type="submit">
    </div>
</form>
