<x-navbar></x-navbar>
<script>
    invoke = () => {
         axios.get("/api/release/images", {params: {artist: $('#artist').value, title: $('#title').value}})
        .then((images) =>{
          console.log(images.data)
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
                <div class="carousel" data-interval="false" id="carousel-of-hope-and-friendship">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img
                                src="https://img.discogs.com/jKTmuxcsYe2TqcahU3QqVXJLssU=/fit-in/600x600/filters:strip_icc():format(jpeg):mode_rgb():quality(90)/discogs-images/R-1873013-1471100381-3022.jpeg.jpg">
                        </div>
                        <div class="carousel-item">
                            <img
                                 src="https://img.discogs.com/CeFTpRsYLhibJZRaFEDyXP3DLeM=/fit-in/600x600/filters:strip_icc():format(jpeg):mode_rgb():quality(90)/discogs-images/R-1873013-1627994684-3522.jpeg.jpg">
                        </div>
                        <div class="carousel-item">
                            <img
                                 src="https://img.discogs.com/adx12vdubjXCOB9nmwVFCL7X4kI=/fit-in/600x600/filters:strip_icc():format(jpeg):mode_rgb():quality(90)/discogs-images/R-1873013-1471101128-7297.jpeg.jpg">
                        </div>
                    </div>
                    <a class="carousel-control-prev" href="#carousel-of-hope-and-friendship" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carousel-of-hope-and-friendship" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</form>


