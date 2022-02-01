<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<div class="modal fade" id="detailsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered my-md-0 h-100" role="document">
        <div class="modal-content h-100 d-flex">
            <div class="modal-header flex-shrink-0">
                <h5 class="modal-title" id="modal-title">Record Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body d-flex flex-column flex-grow-1">
                <div class="container flex-grow-1">
                    <div class="row">
                        <div class="col align-self-center">
                            <img id="thumbnail" class="w-100 h-100" src="">
                        </div>
                        <div class="col-4">
                            <label><b>Artist</b></label>
                            <p id="artist"></p>
                            <label><b>Title</b></label>
                            <p id="title"></p>
                            <label><b>Genre</b></label>
                            <p id="genre"></p>
                            <p>Played <span id="timesPlayed" ></span> times</p>
                            <p>Last played on <span id="lastPlayedAt"></span></p>
                            <input id="releaseId" hidden value="">
                        </div>
                    </div>
                </div>
                <div class="modal-footer p-0">
                    <div class="mr-auto">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            Close
                        </button>
                        <a class="btn btn-secondary" id="edit" onclick="turnOffLight()" href="">Edit</a>
                        <button type="button" class="btn btn-danger" onclick="deleteRecord()">Delete</button>
                    </div>
                    <div class="align-self-end">
                        <button type="button" onclick="playRecord()" data-dismiss="modal" class="btn btn-primary">Play
                            Album
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function turnOffLight() {
        axios.get(`/api/lights/light/off`)
    }

    function playRecord() {
        let id = $('#releaseId').val()
        turnOffLight()
        axios.get(`/api/release/${id}/play`)
            .then((response) => {
                if (response.data.success === true) {
                    window.location.replace("/")
                }
            })
    }

    function deleteRecord() {
        turnOffLight()
        let id = $('#releaseId').val()
        axios.get(`/api/release/${id}/delete`)
            .then((response) => {
                if (response.data.message === 'success') {
                    location.reload()
                }
            })
    }

    $(function () {
        $('#detailsModal').on('hide.bs.modal', function (e) {
            turnOffLight()
        })
    })
</script>
</html>
