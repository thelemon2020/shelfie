<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<!-- Modal -->
<div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title">Record Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container text-left">
                    <div class="row">
                        <div class="col-auto align-self-center">
                            <img id="thumbnail" src="">
                        </div>
                        <div class="col-auto align-self-center">
                            <label><b>Artist</b></label>
                            <p id="artist"></p>
                            <label><b>Title</b></label>
                            <p id="title"></p>
                            <label><b>Times Played</b></label>
                            <p id="timesPlayed"></p>
                            <label><b>Last Played At</b></label>
                            <p id-="lastPlayed"></p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="col-auto">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Edit</button>
                    </div>
                    <div class="col-auto">
                        <button type="button" class="btn btn-primary">Play Album</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</html>
