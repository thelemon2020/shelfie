<!DOCTYPE html>
<script
    src="https://code.jquery.com/jquery-3.6.0.js"
    integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
    crossorigin="anonymous"></script>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<div class="modal fade" id="detailsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
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
                <div class="container-md">
                    <div class="row">
                        <div class="col-md-8 align-self-center">
                            <img id="thumbnail" class="w-100 h-100" src="">
                        </div>
                        <div class="col-md-4">
                            <label><b>Artist</b></label>
                            <p id="artist"></p>
                            <label><b>Title</b></label>
                            <p id="title"></p>
                            <label><b>Genre</b></label>
                            <p id="genre"></p>
                            <label><b>Times Played</b></label>
                            <p id="timesPlayed"></p>
                            <label><b>Last Played At</b></label>
                            <p id="lastPlayed"></p>
                            <input id="releaseId" hidden value="">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
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
        axios.get(`/api/lights/turnoffone`)
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
