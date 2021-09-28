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
                let htmlInsert = `<div class='carousel-item active'><img class="d-block w-100 img-thumbnail" alt="${$('#thumbnail').val()}" src="${$('#full_image').val()}"></div>`
                images.data.forEach((image) => {
                    htmlInsert += `<div class='carousel-item'><img class="d-block w-100 img-thumbnail" alt="${image.thumbnail}" src="${image.image}"></div>`
                })
                $('#image-carousel > .carousel-inner').html(htmlInsert)

                $('#image-carousel').carousel()
            })
    }

    setImage = () => {
        const selectedImage = $('.carousel-item.active').children('img')[0]
        $('#thumbnail').val(selectedImage.src)
        $('#full_image').val(selectedImage.alt)
        $('#coverImage').attr("src", selectedImage.alt)
    }
</script>
@if(request()->query('message') === 'success')
    <div class="alert alert-success alert-dismissible fade show text-center">Record Updated Successfully
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
<div class="row">
    <div class="col-2">
        <a class="btn-primary btn m-2" href="{{route('collection.index')}}">Back</a>
    </div>
    <div class="col-8">
        <h1 class="text-center">Edit Release</h1>
    </div>
</div>
<form class="col-lg-6 offset-lg-3 " method="post" action="{{route('api.release.edit', ['id'=>$release->id])}}">
    <div class="row justify-content-center">
        <div class="col-6">
            <label>Cover Image</label>
            <br>
            <img id="coverImage" class="img-fluid" src="{{$release->full_image}}">
            <br>
            <btn class="btn btn-primary mt-2" onclick="invoke()" data-toggle="modal"
                 data-target="#imageModal">Change Cover Image
            </btn>
        </div>
        <div class="col-6 align-self-center">
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
            <input type="hidden" id='thumbnail' name="thumbnail" value="{{$release->thumbnail}}">
            <input type="hidden" id='full_image' name="full_image" value="{{$release->full_image}}">
        </div>
    </div>
    <div class="row justify-content-center">
        <input type="submit">
    </div>
</form>
<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="imageModal"
     aria-hidden="true" id="imageModal">
    <div class="modal-dialog modal-dialog-centered" style="max-width: max-content; min-width: 27%" role="document">
        <div class="modal-content">
            <div class="carousel lazy" data-interval="false" id="image-carousel">
                <div class="carousel-inner">
                    <div class="text-center">
                        <div class="spinner-border" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                        <div>
                            <p>Loading Images</p>
                        </div>
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
            <button class="btn btn-primary" onclick="setImage()" data-toggle="modal"
                    data-target="#imageModal">Select
            </button>
        </div>
    </div>
</div>

