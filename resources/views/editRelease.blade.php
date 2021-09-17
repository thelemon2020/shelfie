<x-navbar></x-navbar>
<script>
    invoke = () => {
        axios.get("/api/release/images", {
            params: {
                artist: $("#artist").val(),
                title: $("#title").val(),
            }
        })
            .then((images) => {
                console.log(images.data)
                let htmlInsert = ''
                images.data.forEach((image, index) => {
                    htmlInsert += index !== 0 ?
                        `<div class='carousel-item'><img src="${image.thumbnail}"></div>` :
                        `<div class='carousel-item active'><img src="${image.thumbnail}"></div>`
                })
                $('#image-carousel > .carousel-inner').html(htmlInsert)

                $('#image-carousel').carousel()
            })
    }
</script>
<h1 class="text-center">Edit Release</h1>
<form class="col-lg-6 offset-lg-3 " method="post" action="{{route('api.release.edit', ['id'=>$release->id])}}">
    <div class="row justify-content-center">
        <div class="col-auto">
            <label>Cover Image</label>
            <br>
            <img src="{{$release->full_image}}">
            <br>
            <btn class="btn btn-primary mt-2" onclick="invoke()" data-toggle="modal"
                 data-target="#imageModal">Change Cover Image
            </btn>
        </div>
        <div class="col-5 align-self-center">
            <div class="form-group">
                <label for="artist">Artist</label>
                <br>
                <input type="text" class="form-control" name="artist" id="artist" value="{{$release->artist}}">
            </div>
            <div class="form-group">
                <label for="title">Title</label>
                <br>
                <input type="text" class="form-control" name="title" id="title" value="{{$release->title}}">
            </div>
            <div class="form-group">
                <label for="shelf_order">Shelf Position</label>
                <br>
                <input type="number" class="form-control-sm" id="shelf_order" min="1"
                       max="{{count(\App\Models\Release::all())}}" value="{{$release->shelf_order}}">
            </div>
            <input type="hidden" name="thumbnail" value="{{$release->thumbnail}}">
            <input type="hidden" name="full_image" value="{{$release->full_image}}">
        </div>
    </div>
    <div class="row justify-content-center">
        <input type="submit">
    </div>
    <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="imageModal"
         aria-hidden="true" id="imageModal">
        <div class="modal-dialog modal-dialog-centered" style="max-width: max-content; min-width: 27%" role="document">
            <div class="modal-content">
                <div class="carousel lazy" data-interval="false" id="image-carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="">
                        </div>
                        <div class="carousel-item">
                            <img data-src="">
                        </div>
                    </div>
                    <a class="carousel-control-prev" href="#image-carousel" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#image-carousel" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</form>


