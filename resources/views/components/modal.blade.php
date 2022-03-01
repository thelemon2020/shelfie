
<div class="absolute top-0 left-0 bg-gray-500/50 h-full w-full flex" id="detailsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
     aria-hidden="true">
    <div class="mx-auto my-auto bg-white w-1/3" role="document">
        <div class="h-100 p-2 shadow-lg">
            <div class="modal-header flex-shrink-0">
                <h5 class="modal-title" id="modal-title">Record Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
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
                        <button type="button" onclick="playRecord()" data-bs-dismiss="modal" class="btn btn-primary">
                            Play
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
