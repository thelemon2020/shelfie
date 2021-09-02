<x-navbar></x-navbar>
<form method="post" action="{{route('api.release.edit', ['id'=>$release->id])}}">
    <input type="text" id="artist" value="{{$release->artist}}">
    <input type="text" id="title" value="{{$release->title}}">
    <input type="number" id="shelf_order" value="{{$release->shelf_order}}">
    <input type="submit">
</form>
